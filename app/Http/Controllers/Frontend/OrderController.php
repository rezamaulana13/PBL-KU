<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Cash On Delivery Order
     */
    public function CashOrder(Request $request)
    {
        // Validasi data form
        $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'address' => 'required',
        ]);

        // Hitung total belanja dari cart
        $cart = Session::get('cart', []);
        $totalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);

        // Jika ada kupon, pakai nilai diskon, kalau tidak total belanja
        $tt = Session::has('coupon')
            ? Session::get('coupon')['discount_amount']
            : $totalAmount;

        // Simpan order
        $order_id = Order::insertGetId([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'payment_type'  => 'Cash On Delivery',
            'payment_method'=> 'Cash On Delivery',
            'currency'      => 'IDR',
            'amount'        => $totalAmount,
            'total_amount'  => $tt,
            'invoice_no'    => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'    => Carbon::now()->format('d F Y'),
            'order_month'   => Carbon::now()->format('F'),
            'order_year'    => Carbon::now()->format('Y'),
            'status'        => 'Pending',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        // Simpan item order
        foreach ($cart as $c) {
            OrderItem::insert([
                'order_id'  => $order_id,
                'product_id'=> $c['id'],
                'client_id' => $c['client_id'],
                'qty'       => $c['quantity'],
                'price'     => $c['price'],
                'created_at'=> Carbon::now(),
            ]);
        }

        // Hapus cart & kupon dari session
        Session::forget(['cart', 'coupon']);

        return view('frontend.checkout.thanks')->with([
            'message'    => 'Order Placed Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Stripe Order
     */
    public function StripeOrder(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'address' => 'required',
        ]);

        $cart = Session::get('cart', []);
        $totalAmount = collect($cart)->sum(fn($c) => $c['price'] * $c['quantity']);

        $tt = Session::has('coupon')
            ? Session::get('coupon')['discount_amount']
            : $totalAmount;

        // Stripe charge
        \Stripe\Stripe::setApiKey('sk_test_51QRCFaGbu7uS4hyTGxE78S3pWpkxSd2GbxF2cRiFYhkk2aFxSCAxKJJU6kl8pLkTSLPJ4TnR6vQeAof1DC5P5ZCx00vUFHMtFa');

        $token = $request->stripeToken;

        $charge = \Stripe\Charge::create([
            'amount'      => $totalAmount * 100, // cent
            'currency'    => 'usd',
            'description' => 'EasyFood Delivery',
            'source'      => $token,
            'metadata'    => ['order_id' => '6735'],
        ]);

        // Simpan order
        $order_id = Order::insertGetId([
            'user_id'        => Auth::id(),
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'payment_type'   => 'Stripe',
            'payment_method' => $charge->payment_method ?? 'Stripe',
            'currency'       => 'IDR', // dipaksa IDR biar konsisten
            'transaction_id' => $charge->balance_transaction,
            'amount'         => $totalAmount,
            'total_amount'   => $tt,
            'order_number'   => $charge->metadata->order_id,
            'invoice_no'     => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date'     => Carbon::now()->format('d F Y'),
            'order_month'    => Carbon::now()->format('F'),
            'order_year'     => Carbon::now()->format('Y'),
            'status'         => 'Pending',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);


        foreach ($cart as $c) {
            OrderItem::insert([
                'order_id'  => $order_id,
                'product_id'=> $c['id'],
                'client_id' => $c['client_id'],
                'qty'       => $c['quantity'],
                'price'     => $c['price'],
                'created_at'=> Carbon::now(),
            ]);
        }

        Session::forget(['cart', 'coupon']);

        return view('frontend.checkout.thanks')->with([
            'message'    => 'Order Placed Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Cancel Order
     */
    // Pastikan ini adalah fungsi yang Anda gunakan
public function CancelOrder($id)
{
    $order = Order::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    if (in_array(strtolower($order->status), ['pending', 'processing', 'confirm'])) {
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with([
            'message'    => 'Pesanan berhasil dibatalkan.',
            'alert-type' => 'success'
        ]);
    } else {
        // Tambahkan baris ini di sini
        dd($order->status);

        return redirect()->back()->with([
            'message'    => 'Pesanan tidak bisa dibatalkan.',
            'alert-type' => 'error'
        ]);
    }
}
}
