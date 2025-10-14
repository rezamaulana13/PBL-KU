@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
/* Gaya Kustom untuk Halaman Daftar Produk */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.badge-status {
    font-size: 0.75em;
    padding: 6px 10px;
    border-radius: 20px;
}

.tombol-aksi .btn {
    margin: 2px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tombol-aksi .btn:hover {
    transform: translateY(-2px);
}

.tabel-rapat td, .tabel-rapat th {
    white-space: nowrap;
    vertical-align: middle;
}

.avatar-kecil {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.loading-spinner {
    display: none;
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.kotak-pencarian {
    position: relative;
}

.kotak-pencarian .form-control {
    padding-left: 40px;
    border-radius: 25px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.kotak-pencarian .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.25);
}

.kotak-pencarian i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}

.kartu-stats {
    border-left: 4px solid;
    transition: all 0.3s ease;
}

.kartu-stats:hover {
    transform: translateY(-3px);
}

.kartu-stats.primary { border-color: #667eea; }
.kartu-stats.success { border-color: #28a745; }
.kartu-stats.warning { border-color: #ffc107; }
.kartu-stats.info { border-color: #17a2b8; }
.kartu-stats.danger { border-color: #dc3545; }

.gambar-produk {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.gambar-produk:hover {
    transform: scale(1.1);
    border-color: #667eea;
}

.status-aktif {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.status-nonaktif {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.animasi-muncul {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-state {
    padding: 3rem 1rem;
    text-align: center;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.diskon-badge {
    font-size: 0.7em;
    padding: 3px 8px;
}

.harga-asli {
    text-decoration: line-through;
    color: #6c757d;
    font-size: 0.9em;
}

.toggle-switch {
    transform: scale(0.8);
    transform-origin: left center;
}

.filter-group {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #e9ecef;
}

.stok-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

.stok-tinggi { background-color: #28a745; }
.stok-sedang { background-color: #ffc107; }
.stok-rendah { background-color: #dc3545; }
.stok-habis { background-color: #6c757d; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-package me-2"></i>Manajemen Produk
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $product->count() }} Produk</span>
                    </div>

                    <div class="page-title-right">
                        <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="bx bx-plus me-1"></i>Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Judul -->

        <!-- Kartu Statistik -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Produk</h5>
                                <h3 class="mb-0">{{ $product->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-package"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats success card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Aktif</h5>
                                <h3 class="mb-0">{{ $product->where('status', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-aktif">
                                <i class="bx bx-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats warning card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Best Seller</h5>
                                <h3 class="mb-0">{{ $product->where('best_seller', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                <i class="bx bx-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats info card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Diskon</h5>
                                <h3 class="mb-0">{{ $product->where('discount_price', '!=', null)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-discount"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats danger card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Stok Habis</h5>
                                <h3 class="mb-0">{{ $product->where('qty', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-nonaktif">
                                <i class="bx bx-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Populer</h5>
                                <h3 class="mb-0">{{ $product->where('most_populer', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-trending-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-filter me-2"></i>Filter & Pencarian
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari produk, toko, atau kategori...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Status Produk</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" id="filterKategori">
                                    <option value="">Semua Kategori</option>
                                    @foreach($category as $cat)
                                    <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Stok</label>
                                <select class="form-select" id="filterStok">
                                    <option value="">Semua Stok</option>
                                    <option value="habis">Stok Habis</option>
                                    <option value="rendah">Stok Rendah (< 10)</option>
                                    <option value="sedang">Stok Sedang (10-50)</option>
                                    <option value="tinggi">Stok Tinggi (> 50)</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Diskon</label>
                                <select class="form-select" id="filterDiskon">
                                    <option value="">Semua</option>
                                    <option value="ada">Ada Diskon</option>
                                    <option value="tidak">Tidak Ada Diskon</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Produk -->
        <div class="row animasi-muncul" style="animation-delay: 0.3s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-list-ul me-2"></i>Daftar Semua Produk
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-primary btn-sm" onclick="resetFilter()">
                                    <i class="bx bx-reset me-1"></i>Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th style="width: 80px;">Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Toko / Restoran</th>
                                        <th class="text-center" style="width: 100px;">Stok</th>
                                        <th style="width: 120px;">Harga</th>
                                        <th class="text-center" style="width: 100px;">Diskon</th>
                                        <th class="text-center" style="width: 100px;">Status</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelProduk">
                                    @foreach ($product as $key=> $item)
                                    <tr class="baris-produk"
                                        data-status="{{ $item->status }}"
                                        data-kategori="{{ $item->category->category_name ?? '' }}"
                                        data-stok="{{ $item->qty }}"
                                        data-diskon="{{ $item->discount_price ? 'ada' : 'tidak' }}">
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key+1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                 class="gambar-produk"
                                                 data-bs-toggle="tooltip"
                                                 data-bs-title="Lihat gambar {{ $item->name }}"
                                                 onclick="tampilkanGambarBesar('{{ asset($item->image) }}', '{{ $item->name }}')">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    <small class="text-muted">{{ $item->category->category_name ?? 'Tidak ada kategori' }}</small>
                                                    <div class="mt-1">
                                                        @if($item->best_seller)
                                                        <span class="badge bg-warning badge-status me-1">
                                                            <i class="bx bx-trophy me-1"></i>Best Seller
                                                        </span>
                                                        @endif
                                                        @if($item->most_populer)
                                                        <span class="badge bg-info badge-status">
                                                            <i class="bx bx-trending-up me-1"></i>Populer
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <i class="bx bx-store text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item['client']['name'] }}</h6>
                                                    <small class="text-muted">{{ $item->city->city_name ?? 'Tidak ada kota' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $stokClass = 'stok-tinggi';
                                                $stokText = 'Tinggi';
                                                if ($item->qty == 0) {
                                                    $stokClass = 'stok-habis';
                                                    $stokText = 'Habis';
                                                } elseif ($item->qty < 10) {
                                                    $stokClass = 'stok-rendah';
                                                    $stokText = 'Rendah';
                                                } elseif ($item->qty <= 50) {
                                                    $stokClass = 'stok-sedang';
                                                    $stokText = 'Sedang';
                                                }
                                            @endphp
                                            <span class="badge bg-light text-dark">
                                                <span class="stok-indicator {{ $stokClass }}"></span>
                                                {{ $item->qty }}
                                            </span>
                                            <small class="d-block text-muted">{{ $stokText }}</small>
                                        </td>
                                        <td>
                                            @if($item->discount_price)
                                                <div class="harga-asli">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                                <div class="text-success fw-bold">
                                                    Rp {{ number_format($item->discount_price, 0, ',', '.') }}
                                                </div>
                                            @else
                                                <div class="fw-bold">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->discount_price == NULL)
                                                <span class="badge bg-secondary diskon-badge">Tidak Ada</span>
                                            @else
                                                @php
                                                    $amount = $item->price - $item->discount_price;
                                                    $discount = ($amount / $item->price) * 100;
                                                @endphp
                                                <span class="badge bg-success diskon-badge">{{ round($discount) }}%</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <input data-id="{{$item->id}}" class="toggle-class toggle-switch" type="checkbox"
                                                   data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                   data-on="Aktif" data-off="Nonaktif" {{ $item->status ? 'checked' : '' }}>
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <a href="{{ route('admin.edit.product',$item->id) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect"
                                               data-bs-toggle="tooltip"
                                               data-bs-title="Edit {{ $item->name }}">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger waves-effect tombol-hapus"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->name }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Hapus {{ $item->name }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <a href="#"
                                               class="btn btn-sm btn-outline-info waves-effect"
                                               data-bs-toggle="tooltip"
                                               data-bs-title="Detail {{ $item->name }}">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($product->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-package"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Produk Ditemukan</h4>
                            <p class="text-muted">Mulai dengan menambahkan produk pertama Anda.</p>
                            <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light mt-3">
                                <i class="bx bx-plus me-1"></i>Tambah Produk Pertama
                            </a>
                        </div>
                        @endif
                    </div>

                    @if($product->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $product->firstItem() }} sampai {{ $product->lastItem() }} dari {{ $product->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $product->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusProduk" class="modal fade" tabindex="-1" aria-labelledby="modalHapusProdukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusProdukLabel">
                    <i class="bx bx-trash me-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bx bx-error-circle display-1 text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus produk ini?</h5>
                <p class="text-center text-muted">Anda akan menghapus: <strong id="namaProdukHapus"></strong></p>
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="bx bx-info-circle me-2"></i>
                    <small>Penghapusan produk akan menghapus semua data terkait termasuk gambar.</small>
                </div>
                <p class="text-center text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusProduk" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger waves-effect waves-light" id="tombolKonfirmasiHapus">
                        <div class="loading-spinner" id="spinnerHapusProduk"></div>
                        <i class="bx bx-trash me-1"></i>
                        <span id="teksHapusProduk">Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tampilan Gambar Besar -->
<div id="modalGambarBesar" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambarBesarLabel">Gambar Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img id="gambarBesar" src="" alt="" class="img-fluid rounded" style="max-height: 500px;">
                <h6 class="mt-3" id="judulGambarBesar"></h6>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Manajemen Produk
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian real-time
    $('#inputPencarian').on('keyup', function() {
        filterTabel();
    });

    // Filter perubahan
    $('#filterStatus, #filterKategori, #filterStok, #filterDiskon').on('change', function() {
        filterTabel();
    });

    // Handler tombol hapus
    $('.tombol-hapus').on('click', function() {
        const idProduk = $(this).data('id');
        const namaProduk = $(this).data('nama');

        $('#namaProdukHapus').text(namaProduk);
        $('#formHapusProduk').attr('action', '/admin/delete/product/' + idProduk);
        $('#modalHapusProduk').modal('show');
    });

    // Handler pengiriman form hapus
    $('#formHapusProduk').on('submit', function() {
        const tombol = $('#tombolKonfirmasiHapus');
        tombol.prop('disabled', true);
        $('#spinnerHapusProduk').show();
        $('#teksHapusProduk').text('Menghapus...');
    });

    // Reset modal ketika ditutup
    $('#modalHapusProduk').on('hidden.bs.modal', function () {
        $('#tombolKonfirmasiHapus').prop('disabled', false);
        $('#spinnerHapusProduk').hide();
        $('#teksHapusProduk').text('Ya, Hapus');
    });
});

/**
 * Filter tabel berdasarkan pencarian dan filter
 */
function filterTabel() {
    const pencarian = $('#inputPencarian').val().toLowerCase();
    const status = $('#filterStatus').val();
    const kategori = $('#filterKategori').val().toLowerCase();
    const stok = $('#filterStok').val();
    const diskon = $('#filterDiskon').val();

    $('.baris-produk').each(function() {
        const teksBaris = $(this).text().toLowerCase();
        const dataStatus = $(this).data('status').toString();
        const dataKategori = $(this).data('kategori').toLowerCase();
        const dataStok = parseInt($(this).data('stok'));
        const dataDiskon = $(this).data('diskon');

        let tampilkan = true;

        // Filter pencarian
        if (pencarian && !teksBaris.includes(pencarian)) {
            tampilkan = false;
        }

        // Filter status
        if (status && dataStatus !== status) {
            tampilkan = false;
        }

        // Filter kategori
        if (kategori && !dataKategori.includes(kategori)) {
            tampilkan = false;
        }

        // Filter stok
        if (stok) {
            if (stok === 'habis' && dataStok > 0) tampilkan = false;
            if (stok === 'rendah' && (dataStok >= 10 || dataStok === 0)) tampilkan = false;
            if (stok === 'sedang' && (dataStok < 10 || dataStok > 50)) tampilkan = false;
            if (stok === 'tinggi' && dataStok <= 50) tampilkan = false;
        }

        // Filter diskon
        if (diskon && dataDiskon !== diskon) {
            tampilkan = false;
        }

        $(this).toggle(tampilkan);
    });

    // Tampilkan pesan jika tidak ada hasil
    const barisTampil = $('.baris-produk:visible').length;
    if (barisTampil === 0) {
        $('#bodyTabelProduk').html(`
            <tr>
                <td colspan="9" class="text-center py-4">
                    <i class="bx bx-search display-4 text-muted d-block mb-2"></i>
                    <h5 class="text-muted">Tidak ada produk ditemukan</h5>
                    <p class="text-muted">Coba ubah kriteria pencarian atau filter</p>
                    <button type="button" class="btn btn-outline-primary waves-effect" onclick="resetFilter()">
                        <i class="bx bx-reset me-1"></i>Reset Filter
                    </button>
                </td>
            </tr>
        `);
    }
}

/**
 * Reset semua filter
 */
function resetFilter() {
    $('#inputPencarian').val('');
    $('#filterStatus').val('');
    $('#filterKategori').val('');
    $('#filterStok').val('');
    $('#filterDiskon').val('');
    $('.baris-produk').show();
    $('#bodyTabelProduk').html(`@foreach ($product as $key=> $item)
        <tr class="baris-produk"
            data-status="{{ $item->status }}"
            data-kategori="{{ $item->category->category_name ?? '' }}"
            data-stok="{{ $item->qty }}"
            data-diskon="{{ $item->discount_price ? 'ada' : 'tidak' }}">
            <!-- Konten baris tabel -->
        </tr>
        @endforeach`);

    // Re-initialize tooltips dan event handlers
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    $('.tombol-hapus').on('click', function() {
        const idProduk = $(this).data('id');
        const namaProduk = $(this).data('nama');

        $('#namaProdukHapus').text(namaProduk);
        $('#formHapusProduk').attr('action', '/admin/delete/product/' + idProduk);
        $('#modalHapusProduk').modal('show');
    });
}

/**
 * Menampilkan gambar dalam modal besar
 */
function tampilkanGambarBesar(src, judul) {
    $('#gambarBesar').attr('src', src);
    $('#judulGambarBesar').text(judul);
    $('#modalGambarBesar').modal('show');
}

/**
 * Toggle status produk (AJAX)
 */
$(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var product_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeStatus',
            data: {'status': status, 'product_id': product_id},
            success: function(data){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                });

                if ($.isEmptyObject(data.error)) {
                    Toast.fire({
                        icon: 'success',
                        title: data.success,
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.error,
                    });
                }
            },
            error: function(xhr, status, error) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan saat mengubah status',
                });
            }
        });
    });
});
</script>

@endsection
