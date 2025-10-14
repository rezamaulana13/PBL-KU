<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Stripe\Stripe;

class OrderController extends Controller
{
    /**
     * Cash On Delivery Order
     */
    public function CashOrder(Request $request)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $cart = Session::get('cart', []);

        // Pastikan cart tidak kosong
        if (empty($cart)) {
            return redirect()->route('cart.view')->with([
                'message'    => 'Keranjang belanja kosong!',
                'alert-type' => 'error'
            ]);
        }

        $subtotalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);
        $discountAmount = Session::has('coupon') ? Session::get('coupon')['discount_amount'] : 0;
        $totalAmountAfterDiscount = $subtotalAmount - $discountAmount;

        // Simpan order
        $order = Order::create([
            'user_id'         => Auth::id(),
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'payment_type'    => 'Cash On Delivery',
            'payment_method'  => 'COD',
            'currency'        => 'IDR',
            'amount'          => $subtotalAmount,
            'discount_amount' => $discountAmount,
            'total_amount'    => $totalAmountAfterDiscount,
            'invoice_no'      => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'      => Carbon::now(),
            'status'          => 'Pending',
        ]);

        // Simpan item order
        $orderItemsData = collect($cart)->map(fn($c) => [
            'order_id'   => $order->id,
            'product_id' => $c['id'],
            'client_id'  => $c['client_id'] ?? null,
            'qty'        => $c['quantity'],
            'price'      => $c['price'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->toArray();

        OrderItem::insert($orderItemsData);

        // Hapus session cart & coupon
        Session::forget(['cart', 'coupon']);

        return redirect()->route('thanks')->with([
            'message'    => 'Order berhasil dibuat.',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Stripe Order
     */
    public function StripeOrder(Request $request)
    {
        // Validasi
        $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'address' => 'required',
            'stripeToken' => 'required',
        ]);

        $cart = Session::get('cart', []);
        $subtotalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);
        $discountAmount = Session::has('coupon') ? Session::get('coupon')['discount_amount'] : 0;
        $totalAmountAfterDiscount = $subtotalAmount - $discountAmount;

        Stripe::setApiKey(env('STRIPE_SECRET')); // ambil dari .env

        $token = $request->stripeToken;

        try {
            $charge = \Stripe\Charge::create([
                'amount'      => $totalAmountAfterDiscount * 100, // Stripe pakai sen
                'currency'    => 'idr',
                'description' => 'EasyFood Delivery',
                'source'      => $token,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message'    => 'Pembayaran Stripe gagal: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }

        // Simpan order
        $order = Order::create([
            'user_id'         => Auth::id(),
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'payment_type'    => 'Stripe',
            'payment_method'  => 'Stripe',
            'currency'        => 'IDR',
            'transaction_id'  => $charge->balance_transaction,
            'amount'          => $subtotalAmount,
            'discount_amount' => $discountAmount,
            'total_amount'    => $totalAmountAfterDiscount,
            'invoice_no'      => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'      => Carbon::now(),
            'status'          => 'Confirm',
        ]);

        $orderItemsData = collect($cart)->map(fn($c) => [
            'order_id'   => $order->id,
            'product_id' => $c['id'],
            'client_id'  => $c['client_id'] ?? null,
            'qty'        => $c['quantity'],
            'price'      => $c['price'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->toArray();

        OrderItem::insert($orderItemsData);

        Session::forget(['cart', 'coupon']);

        return redirect()->route('thanks')->with([
            'message'    => 'Order berhasil dibuat via Stripe.',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Cancel Order
     */
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->back()->with([
                'message'    => 'Pesanan tidak ditemukan.',
                'alert-type' => 'error'
            ]);
        }

        if (in_array(strtolower($order->status), ['pending', 'processing', 'confirm'])) {
            $order->status = 'Cancelled';
            $order->save();

            return redirect()->back()->with([
                'message'    => 'Pesanan berhasil dibatalkan.',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message'    => 'Pesanan tidak bisa dibatalkan pada status: ' . $order->status,
            'alert-type' => 'error'
        ]);
    }

    /**
     * Detail Order User
     */
    public function UserOrderDetails($id)
    {
        $order = Order::with(['orderItems.product', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $orderItem = $order->orderItems;

        $totalPrice = $orderItem->sum(fn($item) => $item->price * $item->qty);

        $timeline = $this->generateTimeline($order);

        return view('tracking.order_details', compact('order', 'orderItem', 'totalPrice', 'timeline'));
    }

    /**
     * Generate timeline order
     */
    private function generateTimeline($order)
    {
        $status = strtolower($order->status);

        if ($status === 'cancelled') {
            return [
                ['label' => 'Pesanan Dibuat', 'time' => $order->created_at, 'completed' => true, 'status' => 'pending', 'icon' => 'file-invoice'],
                ['label' => 'Pesanan Dibatalkan', 'time' => $order->updated_at, 'completed' => true, 'status' => 'cancelled', 'icon' => 'times-circle'],
            ];
        }

        $is_confirmed = in_array($status, ['confirm', 'processing', 'shipped', 'in transit', 'delivered']);
        $is_processing = in_array($status, ['processing', 'shipped', 'in transit', 'delivered']);
        $is_shipped = in_array($status, ['shipped', 'in transit', 'delivered']);
        $is_delivered = $status == 'delivered';

        return [
            ['label' => 'Pesanan Dibuat', 'time' => $order->created_at, 'completed' => true, 'status' => 'pending', 'icon' => 'file-invoice'],
            ['label' => 'Dikonfirmasi', 'time' => $is_confirmed ? $order->updated_at : null, 'completed' => $is_confirmed, 'status' => 'confirm', 'icon' => 'check-circle'],
            ['label' => 'Sedang Diproses', 'time' => $is_processing ? $order->updated_at : null, 'completed' => $is_processing, 'status' => 'processing', 'icon' => 'cog'],
            ['label' => 'Dalam Pengiriman', 'time' => $is_shipped ? $order->updated_at : null, 'completed' => $is_shipped, 'status' => 'in transit', 'icon' => 'truck'],
            ['label' => 'Pesanan Diterima', 'time' => $is_delivered ? $order->updated_at : null, 'completed' => $is_delivered, 'status' => 'delivered', 'icon' => 'box-open'],
        ];
    }
}
