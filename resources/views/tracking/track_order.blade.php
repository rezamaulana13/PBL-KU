@extends('frontend.dashboard.dashboard')

@section('user')

@include('frontend.dashboard.sidebar')

<div class="tracking-container">

    <!-- Header Section -->
    <div class="tracking-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-location-arrow"></i>
                    Lacak Pesanan
                </h1>
                <p class="page-subtitle">Pantau perjalanan pesanan Anda dengan mudah</p>
            </div>
            <div class="breadcrumb-section">
                <nav class="breadcrumb-nav">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">Lacak Pesanan</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Quick Tracking Card -->
    <div class="tracking-card quick-track">
        <div class="card-header">
            <div class="header-icon">
                <i class="fas fa-rocket"></i>
            </div>
            <div class="header-text">
                <h3>Cepat & Mudah</h3>
                <p>Lacak pesanan dengan nomor resi atau invoice</p>
            </div>
        </div>

        <div class="card-body">
            @if(session('error'))
            <div class="alert-message error">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <strong>Pesanan tidak ditemukan</strong>
                    <p>{{ session('error') }}</p>
                </div>
                <button class="alert-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if(session('success'))
            <div class="alert-message success">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <strong>Berhasil!</strong>
                    <p>{{ session('success') }}</p>
                </div>
                <button class="alert-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <form method="POST" action="{{ route('user.track.by.number') }}" class="tracking-form">
                @csrf
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-barcode"></i>
                        <input
                            type="text"
                            name="tracking_number"
                            class="form-input"
                            placeholder="Masukkan TRK... atau INV..."
                            value="{{ old('tracking_number') }}"
                            required
                        >
                    </div>
                </div>
                <button type="submit" class="track-button">
                    <i class="fas fa-search"></i>
                    Lacak Sekarang
                </button>
            </form>
        </div>
    </div>

    <!-- Orders History Section -->
    <div class="orders-section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-clock-rotate-left"></i>
                <h2>Riwayat Pesanan</h2>
            </div>
            <div class="section-controls">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-filter"></i>
                        Filter:
                    </label>
                    <select class="filter-select" id="statusFilter" onchange="filterOrders()">
                        <option value="all">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirm">Dikonfirmasi</option>
                        <option value="processing">Diproses</option>
                        <option value="delivered">Terkirim</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="orders-grid">
            @forelse($orders as $item)
            <div class="order-card" data-status="{{ strtolower($item->status) }}">
                <div class="order-header">
                    <div class="order-id">
                        <span class="invoice-badge">INVOICE</span>
                        <h3>#{{ $item->invoice_no }}</h3>
                    </div>
                    <div class="order-date">
                        <i class="fas fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}
                    </div>
                </div>

                <div class="order-body">
                    <div class="order-info">
                        <div class="info-item">
                            <label>Total Pembayaran</label>
                            <span class="amount">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Nomor Resi</label>
                            @if($item->tracking_no)
                            <span class="tracking-number">{{ $item->tracking_no }}</span>
                            @else
                            <span class="no-tracking">Belum tersedia</span>
                            @endif
                        </div>
                    </div>

                    <div class="order-status">
                        @php
                            $statusConfig = [
                                'pending' => ['icon' => 'fas fa-clock', 'class' => 'status-pending', 'label' => 'Pending'],
                                'confirm' => ['icon' => 'fas fa-check', 'class' => 'status-confirm', 'label' => 'Dikonfirmasi'],
                                'processing' => ['icon' => 'fas fa-cog', 'class' => 'status-processing', 'label' => 'Diproses'],
                                'delivered' => ['icon' => 'fas fa-box-check', 'class' => 'status-delivered', 'label' => 'Terkirim'],
                                'cancelled' => ['icon' => 'fas fa-times', 'class' => 'status-cancelled', 'label' => 'Dibatalkan']
                            ];
                            $status = strtolower($item->status);
                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        @endphp
                        <div class="status-indicator {{ $config['class'] }}">
                            <i class="{{ $config['icon'] }}"></i>
                            <span>{{ $config['label'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('user.order.details', $item->id) }}" class="action-btn primary">
                        <i class="fas fa-eye"></i>
                        Detail
                    </a>

                    @if($item->tracking_no)
                    <form action="{{ route('user.track.by.number') }}" method="POST" class="action-form">
                        @csrf
                        <input type="hidden" name="tracking_number" value="{{ $item->tracking_no }}">
                        <button type="submit" class="action-btn secondary">
                            <i class="fas fa-route"></i>
                            Lacak
                        </button>
                    </form>
                    @endif

                    @if(strtolower($item->status) == 'pending')
                    <form action="{{ route('user.order.cancel', $item->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')" class="action-form">
                        @csrf
                        <button type="submit" class="action-btn danger">
                            <i class="fas fa-times"></i>
                            Batal
                        </button>
                    </form>
                    @endif

                    @if(strtolower($item->status) == 'delivered')
                    <a href="{{ route('user.invoice.download', $item->id) }}" class="action-btn success">
                        <i class="fas fa-download"></i>
                        Invoice
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3>Belum ada pesanan</h3>
                <p>Mulai berbelanja dan pesanan Anda akan muncul di sini</p>
                <a href="{{ route('index') }}" class="cta-button">
                    <i class="fas fa-shopping-cart"></i>
                    Belanja Sekarang
                </a>
            </div>
            @endforelse
        </div>

        <!-- No Results State -->
        <div class="no-results d-none" id="noResultsState">
            <div class="no-results-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>Tidak ada hasil</h3>
            <p>Tidak ada pesanan dengan status yang dipilih</p>
            <button class="cta-button outline" onclick="resetFilter()">
                Tampilkan Semua
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .tracking-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header Styles */
    .tracking-header {
        margin-bottom: 30px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 20px;
    }

    .title-section .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #3b82f6;
        font-size: 2.2rem;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1.1rem;
        margin: 0;
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

    /* Tracking Card */
    .tracking-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 0;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 30px 30px 20px;
    }

    .header-icon {
        font-size: 2rem;
        opacity: 0.9;
    }

    .header-text h3 {
        margin: 0 0 4px 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .header-text p {
        margin: 0;
        opacity: 0.9;
    }

    .card-body {
        padding: 0 30px 30px;
    }

    /* Alert Messages */
    .alert-message {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        animation: slideIn 0.3s ease;
    }

    .alert-message.error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-message.success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .alert-icon {
        font-size: 1.2rem;
    }

    .alert-message.error .alert-icon {
        color: #ef4444;
    }

    .alert-message.success .alert-icon {
        color: #22c55e;
    }

    .alert-content {
        flex: 1;
    }

    .alert-content strong {
        display: block;
        margin-bottom: 4px;
    }

    .alert-content p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .alert-close {
        background: none;
        border: none;
        color: currentColor;
        opacity: 0.7;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: opacity 0.2s;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Tracking Form */
    .tracking-form {
        display: flex;
        gap: 16px;
        align-items: flex-end;
    }

    .form-group {
        flex: 1;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 1.1rem;
    }

    .form-input {
        width: 100%;
        padding: 16px 20px 16px 50px;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .track-button {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .track-button:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    /* Orders Section */
    .orders-section {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .section-title i {
        color: #3b82f6;
        font-size: 1.5rem;
    }

    .section-controls {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-label {
        color: #6b7280;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-select {
        padding: 8px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        font-size: 0.9rem;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .filter-select:focus {
        outline: none;
        border-color: #3b82f6;
    }

    /* Orders Grid */
    .orders-grid {
        display: grid;
        gap: 20px;
    }

    .order-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #3b82f6;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .order-card:hover::before {
        opacity: 1;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .order-id {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .invoice-badge {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .order-id h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .order-date {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .order-body {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 30px;
        align-items: center;
        margin-bottom: 20px;
    }

    .order-info {
        display: grid;
        gap: 12px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-item label {
        color: #6b7280;
        font-size: 0.9rem;
        min-width: 120px;
    }

    .amount {
        font-weight: 600;
        color: #059669;
        font-size: 1.1rem;
    }

    .tracking-number {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .no-tracking {
        color: #6b7280;
        font-style: italic;
        font-size: 0.9rem;
    }

    /* Status Indicators */
    .status-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-confirm {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-processing {
        background: #e0e7ff;
        color: #4338ca;
    }

    .status-delivered {
        background: #f0fdf4;
        color: #15803d;
    }

    .status-cancelled {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .action-btn.primary {
        background: #3b82f6;
        color: white;
    }

    .action-btn.primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .action-btn.secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .action-btn.secondary:hover {
        background: #d1d5db;
        transform: translateY(-1px);
    }

    .action-btn.danger {
        background: #ef4444;
        color: white;
    }

    .action-btn.danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .action-btn.success {
        background: #10b981;
        color: white;
    }

    .action-btn.success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .action-form {
        margin: 0;
    }

    /* Empty States */
    .empty-state, .no-results {
        text-align: center;
        padding: 60px 20px;
        grid-column: 1 / -1;
    }

    .empty-icon, .no-results-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-state h3, .no-results h3 {
        margin: 0 0 12px 0;
        color: #6b7280;
        font-weight: 500;
    }

    .empty-state p, .no-results p {
        color: #9ca3af;
        margin: 0 0 24px 0;
    }

    .cta-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #3b82f6;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .cta-button:hover {
        background: #2563eb;
        transform: translateY(-2px);
        color: white;
    }

    .cta-button.outline {
        background: transparent;
        border: 2px solid #3b82f6;
        color: #3b82f6;
    }

    .cta-button.outline:hover {
        background: #3b82f6;
        color: white;
    }

    .d-none {
        display: none !important;
    }

    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .tracking-container {
            padding: 15px;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 2rem !important;
        }

        .tracking-form {
            flex-direction: column;
        }

        .order-body {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-actions {
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function filterOrders() {
        const filterValue = document.getElementById('statusFilter').value.toLowerCase();
        const orderCards = document.querySelectorAll('.order-card[data-status]');
        let found = false;

        document.getElementById('noResultsState').classList.add('d-none');

        if (orderCards.length === 0) return;

        orderCards.forEach(card => {
            if (filterValue === 'all' || card.dataset.status === filterValue) {
                card.style.display = 'block';
                found = true;
            } else {
                card.style.display = 'none';
            }
        });

        if (!found) {
            document.getElementById('noResultsState').classList.remove('d-none');
        }
    }

    function resetFilter() {
        document.getElementById('statusFilter').value = 'all';
        filterOrders();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert-message').forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);

        // Close alert buttons
        document.querySelectorAll('.alert-close').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert-message').style.display = 'none';
            });
        });
    });
</script>
@endpush

@endsection
