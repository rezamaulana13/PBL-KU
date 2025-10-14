@extends('admin.admin_dashboard')
@section('admin')

<style>
    /* PALET WARNA PREMIUM ADMIN:
    Cokelat Tua (Brand): #4E342E
    Merah Marun (Aksen Kritis): #C1272D
    Emas/Kuning Hangat (AOV/Keuntungan): #D4AF37
    Warna Info Umum: #566787 (Abu-abu Kebiruan)
    */
    .page-title-box h4 {
        color: #4E342E !important; /* Cokelat Tua */
    }
    .card {
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-radius: 16px !important; /* Lebih premium */
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .card:hover {
        transform: translateY(-8px); /* Lebih terasa 'kece' */
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .counter-value {
        font-weight: 800; /* Lebih tebal */
        color: #4E342E; /* Dominasi cokelat tua */
    }
    .text-maroon { color: #C1272D !important; }
    .border-maroon { border-color: #C1272D !important; }
    .text-gold { color: #D4AF37 !important; }
    .border-gold { border-color: #D4AF37 !important; }

    /* Stats Card Styling */
    .stat-card .text-muted {
        font-size: 14px;
    }
    .stat-card h4 {
        font-size: 24px;
    }

    /* Carousel Warning/Danger Styling */
    .bg-operational-danger {
        background: linear-gradient(135deg, #C1272D 0%, #a94442 100%) !important; /* Gradient Merah Marun Kritis */
    }
    .bg-operational-danger .avatar-title {
        background-color: rgba(255, 255, 255, 0.9);
        color: #C1272D;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Chart Legend Color */
    #product-sales-composition .mdi-circle {
        font-size: 14px;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-5 pb-2">
                    <h4 class="mb-sm-0 font-size-28 fw-bolder" style="letter-spacing: -1px;">
                        <i class="mdi mdi-cookie-outline me-2 text-maroon"></i> Ringkasan Bisnis Raracookies
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-muted">Beranda</a></li>
                            <li class="breadcrumb-item active" style="color: #4E342E;">Dashboard Admin</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-success stat-card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block">Total Penjualan Bulan Ini</span>
                                <h4 class="mb-2 text-success fw-bold">
                                    Rp<span class="counter-value text-success" data-target="15800000">0</span>
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-cash-multiple mdi-36px text-success opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success-subtle text-success px-2 py-1 fw-bold">+18.8%</span>
                            <span class="ms-1 text-muted font-size-12">Dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-maroon stat-card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block">Pesanan **Menunggu Proses**</span>
                                <h4 class="mb-2 text-maroon fw-bold">
                                    <span class="counter-value text-maroon" data-target="47">0</span> Pesanan
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-bell-badge mdi-36px text-maroon opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-danger-subtle text-danger px-2 py-1 fw-bold">Prioritas Tinggi</span>
                            <span class="ms-1 text-muted font-size-12">Aksi Cepat Diperlukan!</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-gold stat-card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block">Nilai Rata-rata Pesanan (AOV)</span>
                                <h4 class="mb-2 text-gold fw-bold">
                                    Rp<span class="counter-value text-gold" data-target="155000">0</span>
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-basket-outline mdi-36px text-gold opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning-subtle text-warning px-2 py-1 fw-bold">+1.8%</span>
                            <span class="ms-1 text-muted font-size-12">Dari minggu lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100 border-start border-4 border-info stat-card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-7">
                                <span class="text-muted mb-2 d-block">Rata-rata Rating Produk</span>
                                <h4 class="mb-2 text-info fw-bold">
                                    <span class="counter-value text-info" data-target="4.95">0</span>
                                    <i class="mdi mdi-star text-gold ms-1"></i>
                                </h4>
                            </div>
                            <div class="col-5 text-end">
                                <i class="mdi mdi-star-circle mdi-36px text-gold opacity-80"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-primary-subtle text-primary px-2 py-1 fw-bold">98% Puas</span>
                            <span class="ms-1 text-muted font-size-12">Total {{ number_format(1500, 0, ',', '.') }} Review</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 mt-1">
            <div class="col-xl-5">
                <div class="card shadow-lg h-100">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2 fw-bold" style="color: #C1272D;">
                                <i class="mdi mdi-chart-donut me-1"></i> Komposisi Produk Terfavorit
                            </h5>
                            <div class="ms-auto">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary">ALL</button>
                                    <button type="button" class="btn btn-maroon active" style="background-color: #C1272D; border-color: #C1272D; color: #fff;">1M</button>
                                    <button type="button" class="btn btn-outline-secondary">6M</button>
                                    <button type="button" class="btn btn-outline-secondary">1Y</button>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div id="product-sales-composition" data-colors='["#4E342E", "#C1272D", "#D4AF37", "#566787"]' class="apex-charts"></div>
                            </div>
                            <div class="col-sm-6 mt-4 mt-sm-0">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-circle me-2" style="color: #4E342E;"></i>
                                    <div>
                                        <p class="mb-1 fw-medium">Nastar Signature</p>
                                        <h6 class="text-dark mb-0">45% <span class="text-muted font-size-12">(Rp 4.025.000)</span></h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-circle me-2" style="color: #C1272D;"></i>
                                    <div>
                                        <p class="mb-1 fw-medium">Kastangel Premium</p>
                                        <h6 class="text-dark mb-0">30% <span class="text-muted font-size-12">(Rp 2.123.000)</span></h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="mdi mdi-circle me-2" style="color: #D4AF37;"></i>
                                    <div>
                                        <p class="mb-1 fw-medium">Chocochips Klasik</p>
                                        <h6 class="text-dark mb-0">15% <span class="text-muted font-size-12">(Rp 1.500.000)</span></h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-circle me-2" style="color: #566787;"></i>
                                    <div>
                                        <p class="mb-1 fw-medium">Lainnya</p>
                                        <h6 class="text-dark mb-0">10% <span class="text-muted font-size-12">(Rp 852.000)</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="row g-5 h-100">
                    <div class="col-xl-8">
                        <div class="card shadow-lg h-100">
                            <div class="card-body p-4">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <h5 class="card-title me-2 fw-bold" style="color: #4E342E;">
                                        <i class="mdi mdi-finance me-1"></i> Analisis Finansial & Target
                                    </h5>
                                    <div class="ms-auto">
                                        <select class="form-select form-select-sm" style="width: auto;">
                                            <option selected>Bulan Ini (Oktober)</option>
                                            <option>Bulan Lalu (September)</option>
                                            <option>Tahun Ini</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-7">
                                        <div id="sales-trend-overview" data-colors='["#4E342E", "#C1272D"]' class="apex-charts"></div>
                                    </div>
                                    <div class="col-sm-5 mt-4 mt-sm-0">
                                        <p class="mb-1 fw-bold text-dark">Laba Kotor (Gross Profit)</p>
                                        <h4 class="fw-bolder text-success">Rp 16.500.000</h4>
                                        <p class="text-muted mb-4 font-size-13">
                                            <i class="mdi mdi-arrow-up text-success"></i> **Rp 1.5 Juta** lebih tinggi dari target.
                                        </p>

                                        <div class="d-flex justify-content-between mb-2">
                                            <small class="text-muted">Total Pemasukan</small>
                                            <span class="fw-medium text-4E342E">Rp 21.000.000</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                            <small class="text-muted">Total Modal/HPP</small>
                                            <span class="fw-medium text-danger">-Rp 4.500.000</span>
                                        </div>

                                        <a href="#" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold" style="background-color: #4E342E; border-color: #4E342E;">
                                            Laporan Lengkap <i class="mdi mdi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card bg-operational-danger text-white h-100 shadow-lg">
                            <div class="card-body p-0">
                                <div id="carouselOperational" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="text-center p-4">
                                                <div class="avatar-md mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-white fs-3" style="color: #C1272D;">
                                                        <i class="mdi mdi-alert-outline"></i>
                                                    </span>
                                                </div>
                                                <h5 class="fw-bolder font-size-18">⚠️ STOK KRITIS</h5>
                                                <p class="text-white-75 mb-3 font-size-14">
                                                    **Mentega Premium** tersisa untuk **5 batch** produksi. Segera *restock*!
                                                </p>
                                                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="color: #C1272D;">
                                                    Cek Inventaris <i class="mdi mdi-arrow-right ms-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <div class="avatar-md mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-white fs-3" style="color: #4E342E;">
                                                        <i class="mdi mdi-cookie-plus-outline"></i>
                                                    </span>
                                                </div>
                                                <h5 class="fw-bolder font-size-18">PROSES 47 PESANAN</h5>
                                                <p class="text-white-75 mb-3 font-size-14">
                                                    47 pesanan siap diproduksi. Pastikan tim *baking* sudah *idle*.
                                                </p>
                                                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="color: #4E342E;">
                                                    Ke Manage Orders <i class="mdi mdi-arrow-right ms-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <div class="avatar-md mx-auto mb-3">
                                                    <span class="avatar-title rounded-circle bg-white fs-3" style="color: #28a745;">
                                                        <i class="mdi mdi-truck-fast-outline"></i>
                                                    </span>
                                                </div>
                                                <h5 class="fw-bolder font-size-18">34 SIAP KIRIM</h5>
                                                <p class="text-white-75 mb-3 font-size-14">
                                                    34 paket sudah *packing* dan menunggu *pickup* kurir hari ini.
                                                </p>
                                                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="color: #28a745;">
                                                    Cek Logistik <i class="mdi mdi-arrow-right ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-indicators position-relative mt-3">
                                        <button type="button" data-bs-target="#carouselOperational" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselOperational" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselOperational" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
