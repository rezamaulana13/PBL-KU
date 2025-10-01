<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" data-key="t-menu">Menu</li>

        <li>
            <a href="index.html">
                <i data-feather="home"></i>
                <span data-key="t-dashboard">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kategori</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('all.category') }}">
                        <span data-key="t-calendar">Semua Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('add.category') }}">
                        <span data-key="t-chat">Tambah Kategori</span>
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kota</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('all.city') }}">
                        <span data-key="t-calendar">Semua Kota</span>
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kelola Produk</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('admin.all.product') }}">
                        <span data-key="t-calendar">Semua Produk</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.add.product') }}">
                        <span data-key="t-chat">Tambah Produk</span>
                    </a>
                </li>

            </ul>
        </li>


        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kelola Restoran</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('pending.restaurant') }}">
                        <span data-key="t-calendar">Pendinng Restoran</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('approve.restaurant') }}">
                        <span data-key="t-chat">restoran Disetujui</span>
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kelola Banner</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('all.banner') }}">
                        <span data-key="t-calendar">Semua Banner </span>
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="grid"></i>
                <span data-key="t-apps">Kelola Pesanan</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li>
                    <a href="{{ route('pending.order') }}">
                        <span data-key="t-calendar">Pesanan Pending</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('confirm.order') }}">
                        <span data-key="t-calendar">Pesanan Dikonfirmasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('processing.order') }}">
                        <span data-key="t-calendar">Pesanan Diproses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('delivered.order') }}">
                        <span data-key="t-calendar">Pesanan Terkirim</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cancelled.order')}}">
                        <span data-key="t-calendar">Pesanan Dibatalkan</span>
                    </a>
                </li>

            </ul>
        </li>


        <li class="menu-title mt-2" data-key="t-components">Elements</li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="briefcase"></i>
                <span data-key="t-components">Kelola Laporan</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('admin.all.reports') }}" data-key="t-alerts">Semua Laporan</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow">
                <i data-feather="gift"></i>
                <span data-key="t-ui-elements">Kelola Ulasan</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('admin.pending.review') }}" data-key="t-lightbox">Ulasan Pending</a></li>
                <li><a href="{{ route('admin.approve.review') }}" data-key="t-range-slider">Ulasan Disetujui</a></li>

            </ul>
        </li>


    </ul>

    <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
        <div class="card-body">
            <img src="assets/images/giftbox.png" alt="">
            <div class="mt-4">
                <h5 class="alertcard-title font-size-16">Limited Edition</h5>
                <p class="font-size-13">Jadilah Admin Yang Konsisten dan Aktif</p>

            </div>
        </div>
    </div>
</div>
        <!-- Sidebar -->
    </div>
</div>
