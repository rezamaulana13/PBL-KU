<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ManageOrderController extends Controller
{
    // Method untuk User melihat list pesanan mereka dengan tracking
    public function UserOrderList()
    {
        $id = auth()->user()->id;
        $allUserOrder = Order::where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('frontend.dashboard.order.order_list', compact('allUserOrder'));
    }

    // Method untuk User melihat detail tracking pesanan
    public function UserOrderDetails($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        // Pastikan user hanya bisa melihat pesanan mereka sendiri
        if ($order->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $orderItem = OrderItem::where('order_id', $id)->get();
        $timeline = $order->getTrackingTimeline();

        return view('tracking.order_details', compact('order', 'orderItem', 'timeline'));
    }

    // Method untuk User tracking pesanan (halaman khusus tracking)
    public function UserTrackOrder(Request $request)
    {
        $id = auth()->user()->id;

        // Jika ada filter status
        $query = Order::where('user_id', $id);

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('id', 'DESC')->get();

        return view('tracking.track_order', compact('orders'));
    }

    // Method untuk User tracking by tracking number
    public function TrackByNumber(Request $request)
    {
        $request->validate([
            'tracking_no' => 'required|string'
        ]);

        $order = Order::where('tracking_no', $request->tracking_no)->first();

        if (!$order) {
            return back()->with('error', 'Nomor tracking tidak ditemukan!');
        }

        // Pastikan user hanya bisa tracking pesanan mereka sendiri
        if ($order->user_id !== auth()->user()->id) {
            return back()->with('error', 'Nomor tracking tidak valid!');
        }

        $timeline = $order->getTrackingTimeline();

        return view('frontend.order.track_result', compact('order', 'timeline'));
    }

    // ===== ADMIN METHODS =====

    public function PendingOrder()
    {
        $allData = Order::where('status', 'Pending')->orderBy('id', 'DESC')->get();
        return view('admin.backend.order.pending_order', compact('allData'));
    }

    public function AdminOrderDetails($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $orderItem = OrderItem::where('order_id', $id)->get();
        $timeline = $order->getTrackingTimeline();

        return view('admin.backend.order.admin_order_details', compact('order', 'orderItem', 'timeline'));
    }

    // Update: Generate tracking number saat confirm
    public function PendingToConfirm($id)
    {
        $order = Order::findOrFail($id);

        // Generate tracking number jika belum ada
        if (!$order->tracking_no) {
            $order->tracking_no = Order::generateTrackingNumber();
        }

        $order->status = 'Confirm';
        $order->confirmed_date = Carbon::now();
        $order->save();

        $notification = array(
            'message' => 'Order Confirmed Successfully & Tracking Number Generated',
            'alert-type' => 'success'
        );

        return redirect()->route('confirm.order')->with($notification);
    }

    public function ConfirmOrder()
    {
        $allData = Order::where('status', 'Confirm')->orderBy('id', 'DESC')->get();
        return view('admin.backend.order.confirm_order', compact('allData'));
    }

    public function ConfirmToProcessing($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Processing';
        $order->processing_date = Carbon::now();
        $order->save();

        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('processing.order')->with($notification);
    }

    public function ProcessingOrder()
    {
        $allData = Order::where('status', 'Processing')->orderBy('id', 'DESC')->get();
        return view('admin.backend.order.processing_order', compact('allData'));
    }

    public function ProcessingToDiliverd($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Delivered';
        $order->delivered_date = Carbon::now();
        $order->save();

        $notification = array(
            'message' => 'Order Delivered Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('delivered.order')->with($notification);
    }

    public function DeliveredOrder()
    {
        $allData = Order::where('status', 'Delivered')->orderBy('id', 'DESC')->get();
        return view('admin.backend.order.delivered_order', compact('allData'));
    }

    public function CancelledOrder()
    {
        $allData = Order::where('status', 'Cancelled')->orderBy('id', 'DESC')->get();
        return view('admin.backend.order.cancelled_order', compact('allData'));
    }

    // Method untuk user cancel order (hanya jika status masih Pending)
    public function UserOrderCancel($id)
    {
        $order = Order::findOrFail($id);

        // Validasi ownership
        if ($order->user_id !== auth()->user()->id) {
            abort(403);
        }

        // Hanya bisa cancel jika status masih Pending
        if ($order->status !== 'Pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses!');
        }

        $order->status = 'Cancelled';
        $order->save();

        $notification = array(
            'message' => 'Pesanan berhasil dibatalkan',
            'alert-type' => 'success'
        );

        return redirect()->route('user.order.list')->with($notification);
    }

    // Download Invoice
    public function UserInvoiceDownload($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        if ($order->user_id !== auth()->user()->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('frontend.dashboard.order.invoice_download', compact('order'));

        return $pdf->download('invoice_'.$order->invoice_no.'.pdf');
    }

    // ===== CLIENT/RESTAURANT METHODS =====

    public function AllClientOrders()
{
    $clientId = auth()->guard('client')->id();

    $orders = Order::whereHas('orderItems.product', function ($query) use ($clientId) {
        $query->where('client_id', $clientId);
    })->latest()->get();

    return view('client.backend.order.all_orders', compact('orders'));
}



  public function ClientOrderDetails($id)
{
    $order = Order::with('orderItems.product.client')->findOrFail($id);
    $clientId = auth()->guard('client')->id();

    if (! $clientId) {
        abort(403, 'Client not logged in');
    }

    // cek isi
    if (! $order->orderItems->count()) {
        abort(403, 'Order tidak punya item');
    }

    $hasItem = $order->orderItems->contains(fn($item) =>
        $item->product && $item->product->client_id == $clientId
    );

    if (! $hasItem) {
        abort(403, 'Order tidak ada untuk client ini');
    }

    $orderItem = $order->orderItems->filter(fn($item) =>
        $item->product && $item->product->client_id == $clientId
    );

    $totalPrice = $orderItem->sum(fn($item) => $item->price * $item->qty);
    $timeline = $order->getTrackingTimeline();

    return view('client.backend.order.client_order_details',
        compact('order', 'orderItem', 'totalPrice', 'timeline')
    );
}


    // Method untuk client update courier info
    public function UpdateCourierInfo(Request $request, $id)
    {
        $request->validate([
            'courier_name' => 'nullable|string|max:255',
            'courier_phone' => 'nullable|string|max:20',
            'delivery_notes' => 'nullable|string'
        ]);

        $order = Order::findOrFail($id);

        // Validasi client ownership
        if ($order->client_id !== auth()->guard('client')->user()->id) {
            abort(403);
        }

        $order->courier_name = $request->courier_name;
        $order->courier_phone = $request->courier_phone;
        $order->delivery_notes = $request->delivery_notes;
        $order->save();

        return back()->with([
            'message' => 'Informasi kurir berhasil diupdate',
            'alert-type' => 'success'
        ]);
    }
}
