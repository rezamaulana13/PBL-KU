<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Stripe\Stripe; // Tambahkan import untuk Stripe

class OrderController extends Controller
{
    /**
     * Cash On Delivery Order
     */
    public function CashOrder(Request $request)
    {
        // 1. Validasi data form
        $validated = $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'address'   => 'required',
        ]);

        $cart = Session::get('cart', []);

        // Cek jika keranjang kosong
        if (empty($cart)) {
            return redirect()->route('cart.view')->with([
                'message'    => 'Keranjang belanja kosong!',
                'alert-type' => 'error'
            ]);
        }

        // Hitung total belanja sebelum diskon
        $subtotalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);

        // Dapatkan nilai diskon (0 jika tidak ada kupon)
        $discountAmount = Session::has('coupon') ? Session::get('coupon')['discount_amount'] : 0;

        // HITUNG TOTAL HARGA AKHIR SETELAH DISKON
        $totalAmountAfterDiscount = $subtotalAmount - $discountAmount;


        // 2. Simpan order (Menggunakan create() jika Model Order Anda sudah memiliki $fillable)
        $order = Order::create([
            'user_id'           => Auth::id(),
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'payment_type'      => 'Cash On Delivery',
            'payment_method'    => 'Cash On Delivery',
            'currency'          => 'IDR',
            'amount'            => $subtotalAmount,           // Total sebelum diskon
            'discount_amount'   => $discountAmount,          // Tambah kolom ini di DB jika belum ada
            'total_amount'      => $totalAmountAfterDiscount, // <--- SUDAH BENAR: Total Bayar
            'invoice_no'        => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'        => Carbon::now()->format('d F Y'),
            'order_month'       => Carbon::now()->format('F'),
            'order_year'        => Carbon::now()->format('Y'),
            'status'            => 'Pending',
        ]);

        // 3. Siapkan Item Order
        $orderItemsData = collect($cart)->map(function($c) use ($order) {
            return [
                'order_id'      => $order->id,
                'product_id'    => $c['id'],
                'client_id'     => $c['client_id'],
                'qty'           => $c['quantity'],
                'price'         => $c['price'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        })->toArray();

        // Menggunakan createMany untuk menyimpan semua item dalam satu query
        OrderItem::insert($orderItemsData);
        // Jika Anda menggunakan relasi, Anda bisa pakai: $order->orderItems()->createMany($orderItemsData);

        // 4. Hapus cart & kupon dari session
        Session::forget(['cart', 'coupon']);

        // 5. Redirect ke halaman sukses
        return redirect()->route('user.order.page')->with([ // Ganti view('frontend.checkout.thanks') dengan redirect
            'message'    => 'Order Placed Successfully',
            'alert-type' => 'success'
        ]);
    }

    // ---

    /**
     * Stripe Order
     */
    public function StripeOrder(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'address'   => 'required',
        ]);

        $cart = Session::get('cart', []);

        // Hitung total belanja sebelum diskon
        $subtotalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);

        // Dapatkan nilai diskon
        $discountAmount = Session::has('coupon') ? Session::get('coupon')['discount_amount'] : 0;

        // HITUNG TOTAL HARGA AKHIR SETELAH DISKON (Ini yang harus dibayar)
        $totalAmountAfterDiscount = $subtotalAmount - $discountAmount;

        // Karena Stripe menggunakan mata uang dasar (cent/smallest currency unit),
        // kita perlu mengalikan dengan 100 jika menggunakan IDR (Stripe IDR tidak didukung cent, tapi kita jaga logikanya)
        // Catatan: Jika Anda menggunakan IDR, Stripe mengharuskan jumlah dalam unit penuh (misal 50000, bukan 500.00).
        // Saya asumsikan $totalAmountAfterDiscount adalah dalam Rupiah penuh (contoh: 50000)

        // Stripe charge
        Stripe::setApiKey('sk_test_51QRCFaGbu7uS4hyTGxE78S3pWpkxSd2GbxF2cRiFYhkk2aFxSCAxKJJU6kl8pLkTSLPJ4TnR6vQeAof1DC5P5ZCx00vUFHMtFa');

        $token = $request->stripeToken;

        try {
            $charge = \Stripe\Charge::create([
                'amount'        => $totalAmountAfterDiscount, // Gunakan total SETELAH DISKON
                'currency'      => 'idr',
                'description'   => 'EasyFood Delivery',
                'source'        => $token,
                'metadata'      => ['order_id' => '6735'],
            ]);
        } catch (\Exception $e) {
            // Tangani error Stripe (misal: kartu ditolak)
            return redirect()->back()->with([
                'message'    => 'Pembayaran Stripe Gagal: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }


        // Simpan order
        $order = Order::create([ // Menggunakan create()
            'user_id'           => Auth::id(),
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'payment_type'      => 'Stripe',
            'payment_method'    => $charge->payment_method ?? 'Stripe',
            'currency'          => 'IDR',
            'transaction_id'    => $charge->balance_transaction,
            'amount'            => $subtotalAmount,              // Total sebelum diskon
            'discount_amount'   => $discountAmount,             // Tambah kolom ini di DB jika belum ada
            'total_amount'      => $totalAmountAfterDiscount,    // <--- SUDAH BENAR: Total Bayar
            'order_number'      => $charge->metadata->order_id,
            'invoice_no'        => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'        => Carbon::now()->format('d F Y'),
            'order_month'       => Carbon::now()->format('F'),
            'order_year'        => Carbon::now()->format('Y'),
            'status'            => 'Confirm', // Biasanya Stripe langsung Confirm
        ]);

        // Siapkan Item Order
        $orderItemsData = collect($cart)->map(function($c) use ($order) {
            return [
                'order_id'      => $order->id,
                'product_id'    => $c['id'],
                'client_id'     => $c['client_id'],
                'qty'           => $c['quantity'],
                'price'         => $c['price'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        })->toArray();

        OrderItem::insert($orderItemsData);

        Session::forget(['cart', 'coupon']);

        return redirect()->route('user.order.page')->with([
            'message'    => 'Order Placed Successfully via Stripe',
            'alert-type' => 'success'
        ]);
    }

    // ---

    /**
     * Cancel Order
     */
    public function CancellOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first(); // Ganti firstOrFail, karena kita ingin cek status

        if (!$order) {
            return redirect()->back()->with([
                'message'    => 'Pesanan tidak ditemukan.',
                'alert-type' => 'error'
            ]);
        }

        if (in_array(strtolower(trim($order->status)), ['pending', 'processing', 'confirm'])) {
            $order->status = 'cancelled';
            $order->save();

            return redirect()->back()->with([
                'message'    => 'Pesanan berhasil dibatalkan.',
                'alert-type' => 'success'
            ]);
        } else {
            // Baris dd($order->status) dihilangkan agar tidak menghentikan aplikasi
            return redirect()->back()->with([
                'message'    => 'Pesanan tidak bisa dibatalkan karena status saat ini adalah: ' . $order->status,
                'alert-type' => 'error'
            ]);
        }
    }

    // ---

    /**
     * Helper function untuk format Rupiah
     */
    function formatRupiah($angka){
        return "Rp" . number_format($angka, 0, ',', '.');
    }

    public function UserOrderDetails($id)
{
    // 1. Ambil order dengan relasi
    $order = Order::with(['orderItems.product', 'user'])
                  ->where('id', $id)
                  ->where('user_id', Auth::id())
                  ->firstOrFail();

    // 2. Ambil order items (PASTIKAN NAMA VARIABLE SAMA DENGAN DI VIEW)
    $orderItem = $order->orderItems; // Di view pakai $orderItem (tanpa 's')

    // 3. Hitung total
    $totalPrice = $orderItem->sum(function($item) {
        return $item->price * $item->qty;
    });

    // 4. TAMBAHKAN VARIABLE TIMELINE (INI YANG HILANG!)
    $timeline = $this->generateTimeline($order);

    // 5. Return view dengan semua variable
    return view('tracking.order_details', compact('order', 'orderItem', 'totalPrice', 'timeline'));
}

/**
 * Generate timeline berdasarkan status order
 */
private function generateTimeline($order)
{
    // Jika order dibatalkan, tampilkan timeline khusus
    if (strtolower($order->status) == 'cancelled') {
        return [
            [
                'label' => 'Pesanan Dibuat',
                'time' => $order->created_at,
                'completed' => true
            ],
            [
                'label' => 'Pesanan Dibatalkan',
                'time' => $order->updated_at,
                'completed' => true
            ]
        ];
    }

    // Timeline normal
    $status = strtolower($order->status);

    return [
        [
            'label' => 'Pesanan Dibuat',
            'time' => $order->created_at,
            'completed' => true
        ],
        [
            'label' => 'Dikonfirmasi',
            'time' => in_array($status, ['confirm', 'processing', 'delivered']) ? $order->confirmed_date ?? $order->updated_at : null,
            'completed' => in_array($status, ['confirm', 'processing', 'delivered'])
        ],
        [
            'label' => 'Sedang Diproses',
            'time' => in_array($status, ['processing', 'delivered']) ? $order->processing_date ?? $order->updated_at : null,
            'completed' => in_array($status, ['processing', 'delivered'])
        ],
        [
            'label' => 'Dalam Pengiriman',
            'time' => $status == 'delivered' ? $order->shipped_date ?? $order->updated_at : null,
            'completed' => $status == 'delivered'
        ],
        [
            'label' => 'Pesanan Diterima',
            'time' => $status == 'delivered' ? $order->delivered_date ?? $order->updated_at : null,
            'completed' => $status == 'delivered'
        ]
    ];
}};
