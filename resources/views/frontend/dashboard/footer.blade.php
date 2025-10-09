<section class="section pt-5 pb-5 bg-secondary text-dark shadow-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 class="m-0 fw-bold">
                    Ingin Bergabung sebagai Mitra Raracookies?
                </h3>
                <p class="text-muted mb-4 mt-2">
                    Daftarkan toko Anda dan kembangkan bisnis kue Anda bersama kami.
                </p>
                {{-- Ganti link 'login.html' dengan route Laravel yang benar --}}
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold text-uppercase shadow">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<section class="footer pt-5 pb-5 bg-dark text-light">
    <div class="container">
        <div class="row">

            {{-- KOLOM 1: INFO & DOWNLOAD APP (Fokus di Kiri) --}}
            <div class="col-md-5 col-12 col-sm-12 mb-5">
                <h5 class="mb-4 text-uppercase fw-bolder border-bottom pb-2 text-primary">Raracookies</h5>

                <p class="text-white-50">Raracookies adalah platform yang menghubungkan Anda dengan aneka ragam kue terbaik di Banyuwangi dan sekitarnya. Temukan favorit Anda sekarang!</p>

                <div class="social-icons mt-4 mb-4">
                    <a href="#" class="text-light me-3 fs-4 hover-primary"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="text-light me-3 fs-4 hover-primary"><i class="fab fa-twitter-square"></i></a>
                    <a href="#" class="text-light me-3 fs-4 hover-primary"><i class="fab fa-instagram-square"></i></a>
                    <a href="#" class="text-light me-3 fs-4 hover-primary"><i class="fab fa-youtube-square"></i></a>
                </div>

                <div class="app">
                    <p class="mb-2 fw-bold small text-light">DOWNLOAD APP</p>
                    <a href="#" class="me-2 d-inline-block">
                        <img class="img-fluid" src="img/google.png" alt="Google Play" style="height: 40px;">
                    </a>
                    <a href="#" class="d-inline-block">
                        <img class="img-fluid" src="img/apple.png" alt="App Store" style="height: 40px;">
                    </a>
                </div>
            </div>

            {{-- KOLOM 2-4: LINKS (Menggunakan 7 kolom sisanya) --}}
            <div class="col-md-7">
                <div class="row">

                    {{-- KOLOM 2: ABOUT --}}
                    <div class="col-md-4 col-4 mb-4">
                        <h6 class="mb-3 text-uppercase fw-bold border-bottom pb-2">Tentang</h6>
                        <ul class="list-unstyled footer-links">
                            <li><a href="#" class="text-white-50">Tentang Kami</a></li>
                            <li><a href="#" class="text-white-50">Budaya</a></li>
                            <li><a href="#" class="text-white-50">Blog</a></li>
                            <li><a href="#" class="text-white-50">Karir</a></li>
                            <li><a href="#" class="text-white-50">Kontak</a></li>
                        </ul>
                    </div>

                    {{-- KOLOM 3: FOR PENGGUNA --}}
                    <div class="col-md-4 col-4 mb-4">
                        <h6 class="mb-3 text-uppercase fw-bold border-bottom pb-2">Pengguna</h6>
                        <ul class="list-unstyled footer-links">
                            <li><a href="#" class="text-white-50">Komunitas</a></li>
                            <li><a href="#" class="text-white-50">Bantuan</a></li>
                            <li><a href="#" class="text-white-50">Kode Etik</a></li>
                            <li><a href="#" class="text-white-50">Verified Users</a></li>
                            <li><a href="#" class="text-white-50">Sitemap</a></li>
                        </ul>
                    </div>

                    {{-- KOLOM 4: FOR MITRA --}}
                    <div class="col-md-4 col-4 mb-4">
                        <h6 class="mb-3 text-uppercase fw-bold border-bottom pb-2">Mitra</h6>
                        <ul class="list-unstyled footer-links">
                            <li><a href="#" class="text-white-50">Iklankan Produk</a></li>
                            <li><a href="#" class="text-white-50">Tambah Toko</a></li>
                            <li><a href="#" class="text-white-50">Untuk Bisnis</a></li>
                            <li><a href="#" class="text-white-50">Pedoman Pemilik</a></li>
                            <li><a href="#" class="text-white-50">Media Kit</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            {{-- Kolom Newsletter diganti dengan Form di bawah link untuk mobile visibility --}}
            <div class="col-md-7 col-12 mt-4">
                 <p class="mb-2 fw-bold text-light">Langganan Info Promo & Kupon</p>
                 <form class="newsletter-form mb-3">
                    <div class="input-group">
                        <input type="email" placeholder="Masukkan email Anda" class="form-control">
                        <button type="button" class="btn btn-primary">
                            Subscribe
                        </button>
                    </div>
                 </form>
            </div>


        </div>
    </div>
</section>

<section class="footer-bottom-search pt-4 pb-4 bg-white border-top border-light">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <p class="text-dark fw-bold mb-2">Daerah Populer</p>
                <div class="search-links small mb-4">
                    <span class="text-primary me-2 fw-bold">Tersedia:</span>
                    <a href="#" class="text-muted me-2">Banyuwangi Kota</a> |
                    <a href="#" class="text-muted me-2">Rogojampi</a> |
                    <a href="#" class="text-muted me-2">Parijatah</a> |
                    <a href="#" class="text-muted me-2">Srono</a> |
                    <a href="#" class="text-muted me-2">Cluring</a> |
                    <a href="#" class="text-muted me-2">Kabat</a> |
                    <a href="#" class="text-muted me-2">Silir</a> |
                    <a href="#" class="text-muted me-2">Pesanggaran</a> |
                    <a href="#" class="text-muted fw-bold">Luar Kota Lainnya...</a>
                </div>

                <p class="text-dark fw-bold mb-2">Makanan Populer</p>
                <div class="search-links small">
                    <span class="text-primary me-2 fw-bold">Kue:</span>
                    <a href="#" class="text-muted me-2">Nastar</a> |
                    <a href="#" class="text-muted me-2">Kastengel</a> |
                    <a href="#" class="text-muted me-2">Putri Salju</a> |
                    <a href="#" class="text-muted me-2">Ladrang Bawang</a> |
                    <a href="#" class="text-muted me-2">Lidah Kucing</a> |
                    <a href="#" class="text-muted me-2">Mawar Jadul</a> |
                    <a href="#" class="text-muted me-2">Sagu Keju</a> |
                    <a href="#" class="text-muted me-2">Kue Coklat Kacang Mede</a> |
                    <a href="#" class="text-muted me-2">Kuping Gajah</a> |
                    <a href="#" class="text-muted me-2">Pastel Abon Sapi</a> |
                    <a href="#" class="text-muted fw-bold">Dan Lainnya...</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="pt-3 pb-3 text-center bg-dark text-white-50">
    <div class="container">
        <p class="mt-0 mb-0 small">
            © Copyright 2025 RaraCookies. PT. Karya Inovasi
            <span class="ms-3 me-3 text-primary">|</span>
            Dibuat dengan <i class="fas fa-heart heart-icon text-danger"></i> oleh
            <a class="text-white-50" target="_blank" href="https://www.instagram.com/iamgurdeeposahan/">Gurdeep Raracookies</a>
        </p>
    </div>
</footer>

<style>
    /* CSS Tambahan untuk Kerapihan */
    .bg-secondary {
        background-color: #f8f9fa !important; /* Light Grey, tidak mencolok */
    }
    .footer-links a {
        transition: color 0.2s ease;
    }
    .footer-links a:hover {
        color: var(--bs-primary) !important; /* Tetap pakai primary untuk hover */
    }
    .hover-primary:hover {
        color: var(--bs-primary) !important;
    }
</style>
