<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title" data-key="t-menu">Navigasi Utama</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title mt-3" data-key="t-datamaster">Data Master</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="tag"></i> <span data-key="t-category-menu">Kategori</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('all.category') }}" data-key="t-all-category">
                                <span>Semua Kategori</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('add.category') }}" data-key="t-add-category">
                                <span>Tambah Kategori</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="map-pin"></i> <span data-key="t-city-menu">Kota</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('all.city') }}" data-key="t-all-city">
                                <span>Semua Kota</span>
                            </a>
                        </li>
                        </ul>
                </li>

                <li class="menu-title mt-3" data-key="t-management">Manajemen Konten & Mitra</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="package"></i> <span data-key="t-product-management">Kelola Produk</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.all.product') }}" data-key="t-all-product">
                                <span>Semua Produk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.add.product') }}" data-key="t-add-product">
                                <span>Tambah Produk</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i> <span data-key="t-restaurant-management">Kelola Restoran</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('pending.restaurant') }}" data-key="t-pending-restaurant">
                                <span>Restoran Pending</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('approve.restaurant') }}" data-key="t-approved-restaurant">
                                <span>Restoran Disetujui</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="image"></i> <span data-key="t-banner-management">Kelola Banner</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('all.banner') }}" data-key="t-all-banner">
                                <span>Semua Banner</span>
                            </a>
                        </li>
                        </ul>
                </li>

                <li class="menu-title mt-3" data-key="t-transaction">Kelola Transaksi</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-cart"></i> <span data-key="t-order-management">Kelola Pesanan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pending.order') }}" data-key="t-pending-order">Pesanan Pending</a></li>
                        <li><a href="{{ route('confirm.order') }}" data-key="t-confirmed-order">Pesanan Dikonfirmasi</a></li>
                        <li><a href="{{ route('processing.order') }}" data-key="t-processing-order">Pesanan Diproses</a></li>
                        <li><a href="{{ route('delivered.order') }}" data-key="t-delivered-order">Pesanan Terkirim</a></li>
                        <li><a href="{{ route('cancelled.order')}}" data-key="t-cancelled-order">Pesanan Dibatalkan</a></li>
                    </ul>
                </li>

                <li class="menu-title mt-3" data-key="t-reporting">Pelaporan & Ulasan</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="bar-chart-2"></i> <span data-key="t-report-management">Kelola Laporan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.all.reports') }}" data-key="t-all-reports">Semua Laporan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="message-square"></i> <span data-key="t-review-management">Kelola Ulasan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.pending.review') }}" data-key="t-pending-review">Ulasan Pending</a></li>
                        <li><a href="{{ route('admin.approve.review') }}" data-key="t-approved-review">Ulasan Disetujui</a></li>
                    </ul>
                </li>

            </ul>

            <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5 bg-primary-subtle">
                <div class="card-body">
                    <img src="{{ asset('backend/assets/images/giftbox.png') }}" alt="Giftbox" height="60">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16 text-primary">Edisi Terbatas</h5>
                        <p class="font-size-13 text-muted">Jadilah Admin Yang Konsisten dan Aktif!</p>
                        <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-primary mt-2">Perbarui Profil</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>
