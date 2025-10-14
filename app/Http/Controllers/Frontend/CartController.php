<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;

class CartController extends Controller
{
    /**
     * Menambahkan produk ke keranjang belanja (Session).
     */
    public function AddToCart($id)
    {
        $product = Product::findOrFail($id);
        Session::forget('coupon');

        $cart = session()->get('cart', []);
        $priceToShow = $product->discount_price ?? $product->price;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'        => $id,
                'name'      => $product->name,
                'image'     => $product->image,
                'price'     => round($priceToShow, 2), // Pastikan harga dibulatkan
                'client_id' => $product->client_id,
                'quantity'  => 1
            ];
        }

        session()->put('cart', $cart);

        $notification = [
            'message' => 'Produk berhasil ditambahkan ke Keranjang!',
            'alert-type' => 'success'
        ];

        return response()->json($notification);
    }
    // End Method

    /**
     * Display the main cart view page.
     * INI ADALAH METHOD YANG HILANG DAN PERLU DITAMBAHKAN.
     */
    public function viewCart()
{
    $cart = session()->get('cart', []);

    // Hitung total keranjang
    $totals = $this->calculateCartTotals();
    $subtotal = $totals['subtotal'];

    $coupon = Session::get('coupon');
    $finalAmount = $coupon['total_after_discount'] ?? $subtotal;

    // Ambil data user jika login, agar bisa dipakai di view
    $order = Auth::check() ? Auth::user() : null;

    return view('frontend.cart.view_cart', compact(
        'cart',
        'coupon',
        'subtotal',
        'finalAmount',
        'order'
    ));
}
 //End Method

    /**
     * Memperbarui kuantitas item keranjang.
     */
    public function updateCartQuanity(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            Session::forget('coupon');

            // Tambahkan data total terbaru ke respons JSON untuk update dinamis di front-end
            $totals = $this->calculateCartTotals();

            return response()->json([
                'message' => 'Kuantitas berhasil diperbarui.',
                'alert-type' => 'success',
                'subtotal' => $totals['subtotal'],
            ]);
        }

        return response()->json(['error' => 'Item tidak ditemukan di keranjang.'], 404);
    }
    // End Method

    /**
     * Menghapus item dari keranjang.
     */
    public function CartRemove(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            Session::forget('coupon');

            // Tambahkan data total terbaru ke respons JSON
            $totals = $this->calculateCartTotals();

            return response()->json([
                'message' => 'Item berhasil dihapus dari keranjang.',
                'alert-type' => 'success',
                'subtotal' => $totals['subtotal'],
            ]);
        }
        return response()->json(['error' => 'Item tidak ditemukan di keranjang.'], 404);
    }
    // End Method

    /**
     * Menghitung total jumlah keranjang saat ini.
     * Memastikan subtotal selalu dibulatkan (round) untuk konsistensi.
     * @return array
     */
    protected function calculateCartTotals()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $clientIds = [];

        foreach ($cart as $item) {
            // Menggunakan round untuk menghindari masalah floating point arithmetic
            $subtotal += round($item['price'] * $item['quantity'], 2);
            $clientIds[] = $item['client_id'];
        }

        // Memastikan subtotal akhir dibulatkan
        return [
            'subtotal' => round($subtotal, 2),
            'client_ids' => $clientIds,
            'cart_count' => count($cart),
        ];
    }

    /**
     * Menerapkan kupon diskon.
     */
    public function ApplyCoupon(Request $request)
    {
        $request->validate(['coupon_name' => 'required|string']);

        $cartData = $this->calculateCartTotals();

        if ($cartData['cart_count'] === 0) {
            return response()->json(['error' => 'Keranjang belanja kosong.']);
        }

        $coupon = Coupon::where('coupon_name', $request->coupon_name)
            ->where('validity', '>=', Carbon::now()->format('Y-m-d'))
            ->first();

        if (!$coupon) {
            return response()->json(['error' => 'Kupon tidak valid atau sudah kadaluarsa.']);
        }

        $uniqueClientIds = array_unique($cartData['client_ids']);

        // --- Logika Kupon Multi-Vendor ---
        if (count($uniqueClientIds) > 1) {
            return response()->json(['error' => 'Kupon ini tidak dapat digunakan untuk pesanan dari banyak restoran.']);
        }

        $cartVendorId = $uniqueClientIds[0];
        $couponVendorId = $coupon->client_id;

        if ((int)$couponVendorId !== (int)$cartVendorId) {
             return response()->json(['error' => 'Kupon ini tidak berlaku untuk restoran ini.']);
        }

        // --- Logika Perhitungan Diskon ---
        $discountAmount = $cartData['subtotal'] * ($coupon->discount / 100);
        $totalAfterDiscount = $cartData['subtotal'] - $discountAmount;

        Session::put('coupon', [
            'coupon_name'          => $coupon->coupon_name,
            'discount_percent'     => $coupon->discount,
            'discount_amount'      => round($discountAmount, 2),
            'total_after_discount' => round($totalAfterDiscount, 2),
        ]);

        $couponData = Session()->get('coupon');

        return response()->json(array(
            'validity' => true,
            'success' => 'Kupon berhasil diterapkan!',
            'couponData' => $couponData,
            'subtotal' => $cartData['subtotal']
        ));
    }
    // End Method

    /**
     * Menghapus kupon diskon dari Session.
     */
    public function CouponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Kupon berhasil dihapus.']);
    }
    // End Method

    /**
     * Memproses ke halaman checkout.
     */
    public function ShopCheckout()
    {
        if (!Auth::check()) {
            $notification = [
                'message' => 'Anda harus Login terlebih dahulu untuk melanjutkan ke Checkout.',
                'alert-type' => 'error'
            ];
            return redirect()->route('login')->with($notification);
        }

        $cartData = $this->calculateCartTotals();

        if ($cartData['subtotal'] <= 0) {
            $notification = [
                'message' => 'Silakan belanja setidaknya satu item.',
                'alert-type' => 'error'
            ];
            return redirect()->to('/')->with($notification);
        }

        $cart = session()->get('cart', []);
        $coupon = Session::get('coupon');
        $totalAmount = $cartData['subtotal'];
        $finalAmount = $coupon['total_after_discount'] ?? $totalAmount;

        return view('frontend.checkout.view_checkout', compact('cart', 'totalAmount', 'finalAmount', 'coupon'));
    }
    // End Method
}
