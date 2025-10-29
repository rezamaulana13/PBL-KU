@extends('frontend.dashboard.dashboard')

@section('user')

<div class="order-detail-container">
    <!-- Header Section -->
    <div class="detail-header">
        <div class="header-top">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-box-open"></i>
                    Detail Pesanan
                </h1>
                <p class="invoice-number">#{{ $order->invoice_no }}</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('user.track.order') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('user.track.order') }}" class="breadcrumb-link">Pesanan</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Detail</span>
        </nav>
    </div>

    <div class="detail-content">
        <!-- Left Column -->
        <div class="left-column">

            <!-- Status Card -->
            <div class="status-card">
                @php
                    $statusConfig = [
                        'Pending' => ['color' => 'warning', 'icon' => 'fas fa-clock', 'gradient' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'],
                        'Confirm' => ['color' => 'info', 'icon' => 'fas fa-check', 'gradient' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)'],
                        'Processing' => ['color' => 'primary', 'icon' => 'fas fa-cog', 'gradient' => 'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)'],
                        'Shipped' => ['color' => 'primary', 'icon' => 'fas fa-truck-fast', 'gradient' => 'linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%)'],
                        'Delivered' => ['color' => 'success', 'icon' => 'fas fa-check-circle', 'gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)'],
                        'Cancelled' => ['color' => 'danger', 'icon' => 'fas fa-times-circle', 'gradient' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)']
                    ];
                    $currentStatus = $statusConfig[$order->status] ?? $statusConfig['Pending'];
                @endphp

                <div class="status-hero" style="background: {{ $currentStatus['gradient'] }}">
                    <div class="status-icon">
                        <i class="{{ $currentStatus['icon'] }}"></i>
                    </div>
                    <div class="status-info">
                        <span class="status-label">Status Saat Ini</span>
                        <h2 class="status-value">{{ $order->status }}</h2>
                    </div>
                </div>

                <div class="status-details">
                    @php
                        $current_status = $order->status;
                        $location_detail = 'Menunggu update dari sistem.';
                        $latest_step = collect($timeline)->filter(fn($step) => $step['completed'])->last();

                        if ($latest_step) {
                            if ($current_status == 'Delivered') {
                                $location_detail = 'Telah diterima oleh ' . ($order->name ?? 'Penerima') . ' pada ' . \Carbon\Carbon::parse($order->delivered_date ?? $latest_step['time'])->format('d M Y H:i');
                            } elseif ($current_status == 'Processing' || $current_status == 'Shipped') {
                                $location_detail = 'Pesanan sedang dalam proses pengiriman';
                            } elseif ($current_status == 'Confirm') {
                                $location_detail = 'Pesanan sedang dipersiapkan';
                            }
                        }
                        if ($current_status == 'Cancelled') {
                            $location_detail = 'Pesanan ini telah dibatalkan.';
                        }
                    @endphp

                    <div class="detail-item">
                        <i class="fas fa-info-circle"></i>
                        <p>{{ $location_detail }}</p>
                    </div>

                    @if($order->tracking_no)
                    <div class="tracking-info">
                        <div class="tracking-label">
                            <i class="fas fa-barcode"></i>
                            Nomor Resi
                        </div>
                        <div class="tracking-number">{{ $order->tracking_no }}</div>
                        <div class="tracking-hint">
                            <i class="fas fa-shield-alt"></i>
                            Gunakan nomor ini untuk melacak di website kurir
                        </div>
                    </div>
                    @else
                    <div class="no-tracking-info">
                        <i class="fas fa-exclamation-circle"></i>
                        Nomor resi belum tersedia, pesanan masih dalam persiapan
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="timeline-card">
                <div class="card-header">
                    <i class="fas fa-clock-rotate-left"></i>
                    <h3>Riwayat Status Pesanan</h3>
                </div>

                <div class="timeline-container">
                    @foreach($timeline as $index => $step)
                    <div class="timeline-step {{ $step['completed'] ? 'completed' : 'pending' }}">
                        <div class="timeline-marker">
                            <div class="marker-dot">
                                @if($step['completed'])
                                    <i class="fas fa-check"></i>
                                @else
                                    <div class="dot-empty"></div>
                                @endif
                            </div>
                            @if($index < count($timeline) - 1)
                            <div class="marker-line"></div>
                            @endif
                        </div>
                        <div class="timeline-content">
                            <h4>{{ $step['label'] }}</h4>
                            @if($step['time'])
                                <span class="timeline-time">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($step['time'])->format('d M Y, H:i') }} WIB
                                </span>
                            @else
                                <span class="timeline-time pending">
                                    <i class="fas fa-hourglass-half"></i>
                                    Menunggu...
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($order->status != 'Delivered' && $order->status != 'Cancelled')
                <div class="timeline-info">
                    <i class="fas fa-info-circle"></i>
                    Status akan diperbarui secara berkala selama proses pengiriman
                </div>
                @endif
            </div>

            <!-- Products Card -->
            <div class="products-card">
                <div class="card-header">
                    <i class="fas fa-cookie-bite"></i>
                    <h3>Detail Produk</h3>
                </div>

                <div class="products-list">
                    @foreach($orderItem as $item)
                    <div class="product-item">
                        <div class="product-image">
                            <img src="{{ asset($item->product->image ?? 'upload/no_image.jpg') }}"
                                alt="{{ $item->product->name ?? 'Produk' }}">
                        </div>
                        <div class="product-info">
                            <h4>{{ $item->product->name ?? 'Nama Produk Tidak Ditemukan' }}</h4>
                            @if($item->size || $item->color)
                                <p class="product-variant">
                                    @if($item->size) Varian: {{ $item->size }} @endif
                                    @if($item->color) • Rasa: {{ $item->color }} @endif
                                </p>
                            @endif
                            <div class="product-price">
                                <span class="price-label">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                <span class="quantity">× {{ $item->qty }}</span>
                            </div>
                        </div>
                        <div class="product-total">
                            Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">

            <!-- Payment Summary Card -->
            <div class="summary-card">
                <div class="card-header">
                    <i class="fas fa-receipt"></i>
                    <h3>Ringkasan Pembayaran</h3>
                </div>

                <div class="summary-items">
                    <div class="summary-item">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item discount">
                        <span>Diskon Voucher</span>
                        <span>- Rp {{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Biaya Kirim</span>
                        <span>Rp {{ number_format($order->shipping_charge ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Akhir</span>
                        <span class="total-amount">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Recipient Info Card -->
            <div class="recipient-card">
                <div class="card-header">
                    <i class="fas fa-user-check"></i>
                    <h3>Informasi Penerima</h3>
                </div>

                <div class="recipient-details">
                    <div class="detail-group">
                        <label>Nama Penerima</label>
                        <p>{{ $order->name }}</p>
                    </div>
                    <div class="detail-group">
                        <label>Telepon</label>
                        <p>{{ $order->phone }}</p>
                    </div>
                    <div class="detail-group">
                        <label>Email</label>
                        <p>{{ $order->email }}</p>
                    </div>
                    <div class="detail-group">
                        <label>Metode Pembayaran</label>
                        <p class="payment-method">{{ $order->payment_method }}</p>
                    </div>
                    <div class="detail-group address">
                        <label>
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat Pengiriman
                        </label>
                        <div class="address-box">
                            {{ $order->address }}, {{ $order->district }}, {{ $order->city }}, {{ $order->province }}, {{ $order->post_code }}
                        </div>
                    </div>
                </div>

                <div class="info-note">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Informasi Kue</strong>
                        <p>Kue kering Rara Cookies dikirim dalam kondisi terbaik dengan kemasan khusus untuk menjaga kualitas dan kesegaran.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if($order->status == 'Delivered')
                <a href="{{ route('user.invoice.download', $order->id) }}" class="action-btn success">
                    <i class="fas fa-download"></i>
                    Download Invoice
                </a>
                @endif

                @if($order->status == 'Pending')
                <form action="{{ route('user.order.cancel', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat diulang.')">
                    @csrf
                    <button type="submit" class="action-btn danger">
                        <i class="fas fa-times"></i>
                        Batalkan Pesanan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .order-detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header Styles */
    .detail-header {
        margin-bottom: 30px;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .title-section .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #3b82f6;
        font-size: 1.8rem;
    }

    .invoice-number {
        color: #6b7280;
        font-size: 1.1rem;
        margin: 0;
        font-weight: 600;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f3f4f6;
        color: #374151;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .back-button:hover {
        background: #e5e7eb;
        color: #1f2937;
        transform: translateX(-4px);
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .breadcrumb-link {
        color: #6b7280;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s;
    }

    .breadcrumb-link:hover {
        color: #3b82f6;
    }

    .breadcrumb-separator {
        color: #d1d5db;
    }

    .breadcrumb-current {
        color: #3b82f6;
        font-weight: 500;
    }

    /* Layout */
    .detail-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
    }

    /* Status Card */
    .status-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .status-hero {
        padding: 40px 30px;
        color: white;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .status-icon {
        font-size: 3rem;
        opacity: 0.9;
    }

    .status-info {
        flex: 1;
    }

    .status-label {
        display: block;
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .status-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
    }

    .status-details {
        padding: 30px;
    }

    .detail-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 20px;
        color: #4b5563;
    }

    .detail-item i {
        color: #3b82f6;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .detail-item p {
        margin: 0;
        line-height: 1.6;
    }

    .tracking-info {
        background: #f0f9ff;
        border: 2px solid #3b82f6;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .tracking-label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #1e40af;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .tracking-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 8px;
    }

    .tracking-hint {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #60a5fa;
        font-size: 0.85rem;
    }

    .no-tracking-info {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 16px;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    /* Timeline Card */
    .timeline-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f3f4f6;
    }

    .card-header i {
        color: #3b82f6;
        font-size: 1.3rem;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .timeline-container {
        position: relative;
    }

    .timeline-step {
        display: flex;
        gap: 20px;
        position: relative;
    }

    .timeline-marker {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .marker-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        flex-shrink: 0;
    }

    .timeline-step.completed .marker-dot {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-size: 1.2rem;
    }

    .timeline-step.pending .marker-dot {
        background: #f3f4f6;
        border: 3px solid #e5e7eb;
    }

    .dot-empty {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #d1d5db;
    }

    .marker-line {
        width: 3px;
        height: calc(100% + 20px);
        position: absolute;
        top: 40px;
        left: 50%;
        transform: translateX(-50%);
    }

    .timeline-step.completed .marker-line {
        background: linear-gradient(180deg, #10b981, #e5e7eb);
    }

    .timeline-step.pending .marker-line {
        background: #e5e7eb;
    }

    .timeline-content {
        flex: 1;
        padding-bottom: 32px;
    }

    .timeline-content h4 {
        margin: 0 0 8px 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .timeline-step.pending .timeline-content h4 {
        color: #9ca3af;
    }

    .timeline-time {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .timeline-time.pending {
        color: #9ca3af;
        font-style: italic;
    }

    .timeline-info {
        background: #f0f9ff;
        border-left: 4px solid #3b82f6;
        padding: 16px;
        border-radius: 8px;
        color: #1e40af;
        font-size: 0.9rem;
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Products Card */
    .products-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .products-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .product-item {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #f9fafb;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .product-item:hover {
        background: #f3f4f6;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        flex: 1;
    }

    .product-info h4 {
        margin: 0 0 6px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .product-variant {
        color: #6b7280;
        font-size: 0.85rem;
        margin: 0 0 8px 0;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .price-label {
        color: #059669;
        font-weight: 600;
    }

    .quantity {
        color: #6b7280;
    }

    .product-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        align-self: center;
    }

    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .summary-items {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #4b5563;
    }

    .summary-item.discount {
        color: #ef4444;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 2px solid #f3f4f6;
        margin-top: 8px;
    }

    .summary-total span:first-child {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 1.1rem;
    }

    .total-amount {
        font-size: 1.8rem;
        font-weight: 700;
        color: #3b82f6;
    }

    /* Recipient Card */
    .recipient-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .recipient-details {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .detail-group label {
        display: block;
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 6px;
    }

    .detail-group p {
        margin: 0;
        color: #1a1a1a;
        font-weight: 500;
    }

    .payment-method {
        color: #3b82f6 !important;
        font-weight: 600 !important;
    }

    .detail-group.address label {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-group.address i {
        color: #ef4444;
    }

    .address-box {
        background: #f0f9ff;
        border-left: 4px solid #3b82f6;
        padding: 16px;
        border-radius: 8px;
        color: #1e40af;
        line-height: 1.6;
    }

    .info-note {
        background: #f0fdf4;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .info-note i {
        color: #10b981;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .info-note strong {
        display: block;
        color: #065f46;
        margin-bottom: 4px;
    }

    .info-note p {
        margin: 0;
        color: #047857;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    .action-btn.success {
        background: #10b981;
        color: white;
    }

    .action-btn.success:hover {
        background: #059669;
        transform: translateY(-2px);
        color: white;
    }

    .action-btn.danger {
        background: #ef4444;
        color: white;
    }

    .action-btn.danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .detail-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .order-detail-container {
            padding: 15px;
        }

        .header-top {
            flex-direction: column;
        }

        .page-title {
            font-size: 1.5rem !important;
        }

        .status-hero {
            flex-direction: column;
            text-align: center;
        }

        .status-value {
            font-size: 2rem !important;
        }

        .product-item {
            flex-direction: column;
        }

        .product-total {
            align-self: flex-start;
        }
    }
</style>
@endpush

@endsection
