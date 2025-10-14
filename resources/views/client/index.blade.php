@extends('client.client_dashboard')
@section('client')

@php
    // Data Dummy Client
    $user = (object)['name' => 'RaraCoockies '];
    $totalOrders = 12;
    $lastOrderDate = '28 Okt 2025';
    $points = 4800;
    $membership = 'Diamond Tier';
    $pendingOrders = 1;

    // DATA DUMMY PESANAN TERBARU (MENGGANTIKAN $latestOrder)
    $recentOrders = [
        [
            'id' => '#RC10250012',
            'date' => '28 Okt',
            'items' => 'Nastar Signature (2), Kastangel (1)',
            'total' => '650.000',
            'status' => 'Quality Check',
            'status_color' => '#D4AF37', // Gold
        ],
        [
            'id' => '#RC10250011',
            'date' => '15 Okt',
            'items' => 'Chocochips Klasik (3)',
            'total' => '300.000',
            'status' => 'Terkirim',
            'status_color' => '#28a745', // Green (Success)
        ],
        [
            'id' => '#RC10250010',
            'date' => '01 Okt',
            'items' => 'Kue Kering Spesial (1)',
            'total' => '225.000',
            'status' => 'Dibatalkan',
            'status_color' => '#C1272D', // Maroon (Danger)
        ],
    ];
@endphp

<style>
    /* PALET WARNA PREMIUM */
    .page-title-box h4 {
        color: #4E342E !important;
    }
    .card {
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-radius: 16px !important;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    .counter-value {
        font-weight: 800;
        color: #4E342E;
    }

    /* Warna border untuk statistik */
    .border-gold { border-color: #D4AF37 !important; }
    .border-maroon { border-color: #C1272D !important; }
    .text-gold { color: #D4AF37 !important; }
    .text-maroon { color: #C1272D !important; }

    /* Badge untuk status */
    .badge-premium-gold {
        background-color: #D4AF37;
        color: #4E342E;
        font-weight: 700;
        padding: 8px 15px;
        border-radius: 20px;
    }

    /* Status Table */
    .status-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 10px;
        /* Tambahkan style untuk kontras */
        filter: brightness(0.9);
    }

    /* Carousel Premium */
    .bg-promo-premium {
        background: linear-gradient(135deg, #4E342E 0%, #C1272D 100%) !important;
    }
    .bg-promo-premium .avatar-title {
        background-color: rgba(255, 255, 255, 0.9);
        color: #4E342E;
    }

    /* Tabel Styling Premium */
    .table-order-premium th {
        color: #4E342E;
        font-weight: 600;
        border-bottom-width: 2px !important;
    }
    .table-order-premium td {
        vertical-align: middle;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-5 pb-2">
                    <h4 class="mb-sm-0 font-size-28 fw-bolder" style="letter-spacing: -1px;">
                        <i class="mdi mdi-crown me-2"></i> Selamat Datang, {{ $user->name ?? 'Pelanggan Setia' }}!
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-muted">Akun</a></li>
                            <li class="breadcrumb-item active text-gold">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-gold shadow-lg h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block font-size-14">Keanggotaan Eksklusif</span>
                                <h4 class="mb-2 text-gold fw-bolder">
                                    {{ $membership }}
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-diamond-stone mdi-36px text-gold opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge badge-premium-gold px-3 py-1">Diskon 10% & Prioritas Pesanan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-info shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block font-size-14">Total Transaksi</span>
                                <h4 class="mb-2 text-info fw-bold">
                                    <span class="counter-value" data-target="{{ $totalOrders }}">0</span> Kali
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-history mdi-36px text-info opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted font-size-12">Pesanan Terakhir: {{ $lastOrderDate }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-warning shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block font-size-14">Akumulasi Poin</span>
                                <h4 class="mb-2 text-warning fw-bold">
                                    <span class="counter-value" data-target="{{ $points }}">0</span> Poin
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-wallet-giftcard mdi-36px text-warning opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted font-size-12">Poin Baru Bulan Ini: +320</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-maroon shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block font-size-14">Pesanan Aktif</span>
                                <h4 class="mb-2 text-maroon fw-bold">
                                    <span class="counter-value" data-target="{{ $pendingOrders }}">0</span> Sedang Diproses
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-cookie-plus mdi-36px text-maroon opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="text-maroon font-size-12 fw-medium">Lacak Detail <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-1">
            <div class="col-xl-6">
                <div class="card shadow-lg h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="card-title me-auto fw-bold" style="color: #4E342E;">
                                <i class="mdi mdi-format-list-bulleted me-1"></i> 3 Pesanan Terakhir Anda
                            </h5>
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                Ke Halaman Orders
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0 table-order-premium">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                    <tr>
                                        <td class="fw-bold">{{ $order['id'] }}</td>
                                        <td>{{ $order['date'] }}</td>
                                        <td class="fw-medium">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge status-badge text-white" style="background-color: {{ $order['status_color'] }};">
                                                {{ $order['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="text-info font-size-14">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card bg-promo-premium text-white h-100 shadow-lg">
                    <div class="card-body p-0">
                        <div id="carouselPromo" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="text-center p-5">
                                        <div class="avatar-md mx-auto mb-4">
                                            <span class="avatar-title rounded-circle fs-3 shadow">
                                                <i class="mdi mdi-gift-outline"></i>
                                            </span>
                                        </div>
                                        <h5 class="fw-bolder font-size-20">HADIAH SPESIAL DIAMOND TIER</h5>
                                        <p class="text-white-75 mb-4 font-size-14">
                                            Klaim *Exclusive Box* kue kering mini GRATIS dengan setiap pesanan di atas Rp 500.000.
                                        </p>
                                        <button class="btn btn-light btn-sm rounded-pill px-4 py-2 fw-bold" style="color: #4E342E;">
                                            Klaim Sekarang <i class="mdi mdi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="text-center p-5">
                                        <div class="avatar-md mx-auto mb-4">
                                            <span class="avatar-title rounded-circle fs-3 shadow">
                                                <i class="mdi mdi-calendar-star"></i>
                                            </span>
                                        </div>
                                        <h5 class="fw-bolder font-size-20">LIMITED EDITION</h5>
                                        <p class="text-white-75 mb-4 font-size-14">
                                            Pre-order 'Cookies of the Month' rasa Kopi Mocha hanya tersedia minggu ini.
                                        </p>
                                        <button class="btn btn-light btn-sm rounded-pill px-4 py-2 fw-bold" style="color: #4E342E;">
                                            Pesan Cepat <i class="mdi mdi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-indicators position-relative mt-3">
                                <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
