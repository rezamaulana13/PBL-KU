@extends('client.client_dashboard')
@section('client')

<style>
    /* Custom Styling untuk Tampilan Super Cerah & Profesional */
    .header-soft-teal {
        background-color: #e6f7ff !important; /* Biru langit sangat muda (Lebih Ceria) */
        color: #007bff !important; /* Bright Blue */
    }
    .header-light-primary {
        background-color: #e9f2ff !important; /* Biru muda sedikit berbeda */
        color: #1e88e5 !important;
    }
    .text-vibrant-orange {
        color: #ff8c00 !important; /* Aksen Orange yang Keren */
    }
    .card {
        border-radius: 15px; /* Sedikit lebih membulat */
        border: 1px solid #e0e0e0;
    }
    .card-header {
        border-bottom: 2px solid #007bff; /* Garis bawah biru cerah di header */
        font-size: 1.25rem;
        font-weight: 700;
        padding: 15px 20px;
    }
    .table-detail th {
        width: 170px; /* Lebar lebih nyaman */
        font-weight: 600;
        color: #555;
    }
    .table-product thead {
        background-color: #f0f2f5;
        color: #343a40;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        {{-- ===== 1. PAGE TITLE & STATUS BADGE (TETAP KEREN) ===== --}}
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="fw-bolder text-dark mb-0">
                    <i class="ri-box-3-line me-2" style="color: #007bff;"></i> Detail Pesanan <span class="text-secondary">#{{ $order->invoice_no }}</span>
                </h3>

                @php
                    $statusConfig = match ($order->status) {
                        'Delivered' => ['text' => 'SUKSES', 'bg' => 'success', 'icon' => 'ri-check-double-line'],
                        'Processing' => ['text' => 'DIPROSES', 'bg' => 'warning', 'icon' => 'ri-loader-4-line'],
                        'Confirm' => ['text' => 'DIKONFIRMASI', 'bg' => 'info', 'icon' => 'ri-calendar-check-line'],
                        'Cancelled' => ['text' => 'BATAL', 'bg' => 'danger', 'icon' => 'ri-close-circle-line'],
                        default => ['text' => 'PENDING', 'bg' => 'secondary', 'icon' => 'ri-time-line'],
                    };
                @endphp

                <span class="badge bg-{{ $statusConfig['bg'] }} fs-6 px-4 py-2 text-uppercase rounded-pill shadow-lg">
                    <i class="{{ $statusConfig['icon'] }} me-1"></i> {{ $statusConfig['text'] }}
                </span>
            </div>
        </div>


        {{-- ===== 2. TIMELINE TRACKING (GANTI DARK MENJADI SOFT TEAL) ===== --}}
        <div class="card shadow-lg mb-5">
            <div class="card-header header-soft-teal rounded-top">
                <h5 class="mb-0 fw-bold"><i class="ri-road-map-line me-2"></i> Status Pengiriman</h5>
            </div>
            <div class="card-body py-4">
                @php
                    $steps = ['Pending', 'Confirm', 'Processing', 'Delivered'];
                    $currentStatus = ucfirst($order->status);
                    $currentIndex = array_search($currentStatus, $steps);
                @endphp

                <div class="progress" style="height: 35px;">
                    @foreach($steps as $index => $step)
                        <div class="progress-bar
                            @if($index <= $currentIndex && $currentStatus != 'Cancelled') bg-success
                            @elseif($currentStatus == 'Cancelled') bg-danger
                            @else bg-light text-dark border @endif"
                            role="progressbar"
                            style="width: {{ 100/count($steps) }}%; font-weight: bold; font-size: 1rem; border-right: 1px solid #fff;">
                            {{ $step }}
                        </div>
                    @endforeach
                </div>

                @if($order->status == 'Cancelled')
                    <div class="alert alert-danger mt-4 fw-bold shadow-sm">
                        <i class="ri-error-warning-line me-2"></i> Pesanan ini telah **dibatalkan**.
                    </div>
                @elseif($order->status == 'Delivered')
                    <div class="alert alert-success mt-4 fw-bold shadow-sm">
                        <i class="ri-check-double-line me-2"></i> **Selamat!** Pesanan telah berhasil terkirim.
                    </div>
                @endif
            </div>
        </div>


        {{-- ===== 3. SHIPPING & ORDER INFO (GANTI DARK/ORANGE MENJADI CERAH) ===== --}}
        <div class="row g-4 mb-5">

            {{-- Shipping Details (Header Light Primary) --}}
            <div class="col-lg-6">
                <div class="card shadow-lg h-100">
                    <div class="card-header header-light-primary d-flex align-items-center">
                        <i class="ri-truck-line me-2 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Rincian Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless table-detail">
                            <tbody>
                                <tr><th>Nama Penerima</th><td><strong class="text-dark">{{ $order->name }}</strong></td></tr>
                                <tr><th>No. HP</th><td>{{ $order->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->email }}</td></tr>
                                <tr><th>Alamat Lengkap</th><td>{{ $order->address }}</td></tr>
                                <tr><th>Tanggal Order</th><td>{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y H:i') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Order Info (Header Soft Teal) --}}
            <div class="col-lg-6">
                <div class="card shadow-lg h-100">
                    <div class="card-header header-soft-teal d-flex align-items-center">
                        <i class="ri-file-text-line me-2 fs-5"></i>
                        <h5 class="mb-0 fw-bold">Informasi Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless table-detail">
                            <tbody>
                                <tr><th>Invoice ID</th><td class="fw-bold text-vibrant-orange fs-5">#{{ $order->invoice_no }}</td></tr>
                                <tr><th>Pemesan</th><td>{{ $order->user->name }}</td></tr>
                                <tr><th>Metode Pembayaran</th><td class="fw-bold text-success">{{ $order->payment_method }}</td></tr>
                                <tr><th>ID Transaksi</th><td>{{ $order->transaction_id ?? 'N/A' }}</td></tr>
                                <tr><th>Total Order</th><td class="fw-bold text-danger fs-3">Rp {{ number_format($order->amount, 0, ',', '.') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== 4. ORDER ITEMS (Header Soft Teal/Cerah) ===== --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header header-soft-teal">
                        <h5 class="mb-0 fw-bold"><i class="ri-shopping-bag-line me-2"></i> Daftar Produk Dipesan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0 table-product">
                                <thead class="text-center">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Penjual</th>
                                        <th>Kode</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItem as $item)
                                    <tr class="text-center">
                                        <td>
                                            <img src="{{ asset($item->product->image) }}" class="rounded shadow-sm" alt="{{ $item->product->name }}" style="width:70px; height:70px; object-fit: cover;">
                                        </td>
                                        <td class="fw-bold text-dark">{{ $item->product->name }}</td>
                                        <td>{{ $item->product->client ? $item->product->client->name : 'Owner' }}</td>
                                        <td><span class="badge bg-secondary text-white">{{ $item->product->code }}</span></td>
                                        <td class="fw-bolder fs-5 text-primary">{{ $item->qty }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="fw-bolder fs-5 text-danger">
                                            Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Footer Total (Tetap Kontras) --}}
                    <div class="card-footer text-end bg-light p-3">
                        <h3 class="fw-bolder mb-0 text-dark">
                            TOTAL ORDER AKHIR: <span class="text-danger fs-1">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
