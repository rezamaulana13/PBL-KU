@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
/* Gaya Kustom untuk Halaman Approve Restaurant */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.badge-status {
    font-size: 0.75em;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
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
.kartu-stats.danger { border-color: #dc3545; }
.kartu-stats.info { border-color: #17a2b8; }

.gambar-restoran {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.gambar-restoran:hover {
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

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

.status-online { background-color: #28a745; }
.status-offline { background-color: #dc3545; }
.status-pending { background-color: #ffc107; }

.badge-new {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.contact-info {
    font-size: 0.875em;
    color: #6c757d;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-restaurant me-2"></i>Manajemen Restoran
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $restaurants->count() }} Restoran</span>
                    </div>

                    <div class="page-title-right">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Terakhir diupdate: Baru saja</span>
                        </div>
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
                                <h5 class="font-size-14 text-muted mb-0">Total Restoran</h5>
                                <h3 class="mb-0">{{ $restaurants->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-restaurant"></i>
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
                                <h3 class="mb-0">{{ $restaurants->where('status', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-aktif">
                                <i class="bx bx-check"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Tidak Aktif</h5>
                                <h3 class="mb-0">{{ $restaurants->where('status', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-nonaktif">
                                <i class="bx bx-x"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Baru Hari Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                <i class="bx bx-calendar"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Terverifikasi</h5>
                                <h3 class="mb-0">{{ $restaurants->where('status', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-badge-check"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Menunggu</h5>
                                <h3 class="mb-0">{{ $restaurants->where('status', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-time"></i>
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
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari nama restoran, email, atau telepon...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Status Restoran</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Tipe Verifikasi</label>
                                <select class="form-select" id="filterVerifikasi">
                                    <option value="">Semua</option>
                                    <option value="terverifikasi">Terverifikasi</option>
                                    <option value="belum">Belum Diverifikasi</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Urut Berdasarkan</label>
                                <select class="form-select" id="filterUrutan">
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terlama">Terlama</option>
                                    <option value="nama">Nama A-Z</option>
                                    <option value="status">Status</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Aksi Massal</label>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-success btn-sm w-50" onclick="aktifkanMassal()">
                                        <i class="bx bx-check me-1"></i>Aktifkan
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm w-50" onclick="nonaktifkanMassal()">
                                        <i class="bx bx-x me-1"></i>Nonaktifkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Restoran -->
        <div class="row animasi-muncul" style="animation-delay: 0.3s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-list-ul me-2"></i>Daftar Semua Restoran
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-primary btn-sm" onclick="resetFilter()">
                                    <i class="bx bx-reset me-1"></i>Reset Filter
                                </button>
                                <button class="btn btn-outline-success btn-sm ms-2" onclick="eksporData()">
                                    <i class="bx bx-download me-1"></i>Ekspor
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th style="width: 80px;">Gambar</th>
                                        <th>Informasi Restoran</th>
                                        <th>Kontak</th>
                                        <th class="text-center" style="width: 100px;">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelRestoran">
                                    @foreach ($restaurants as $key=> $item)
                                    <tr class="baris-restoran"
                                        data-status="{{ $item->status }}"
                                        data-verifikasi="{{ $item->status ? 'terverifikasi' : 'belum' }}"
                                        data-nama="{{ strtolower($item->name) }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input pilih-restoran" data-id="{{ $item->id }}">
                                        </td>
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key+1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ (!empty($item->photo)) ? url('upload/client_images/'.$item->photo) : url('upload/no_image.jpg') }}"
                                                 alt="{{ $item->name }}"
                                                 class="gambar-restoran"
                                                 data-bs-toggle="tooltip"
                                                 data-bs-title="Lihat gambar {{ $item->name }}"
                                                 onclick="tampilkanGambarBesar('{{ (!empty($item->photo)) ? url('upload/client_images/'.$item->photo) : url('upload/no_image.jpg') }}', '{{ $item->name }}')">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    <div class="contact-info">
                                                        <i class="bx bx-id-card me-1"></i>ID: {{ $item->id }}
                                                    </div>
                                                    @if($item->created_at->diffInDays(now()) < 7)
                                                    <span class="badge bg-warning badge-new badge-status mt-1">
                                                        <i class="bx bx-star me-1"></i>Baru
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="contact-info">
                                                <div class="mb-1">
                                                    <i class="bx bx-envelope me-1"></i>
                                                    <a href="mailto:{{ $item->email }}" class="text-muted">{{ $item->email }}</a>
                                                </div>
                                                <div>
                                                    <i class="bx bx-phone me-1"></i>
                                                    <a href="tel:{{ $item->phone }}" class="text-muted">{{ $item->phone ?? 'Tidak ada telepon' }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status == 1)
                                                <span class="badge bg-success badge-status">
                                                    <span class="status-indicator status-online"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger badge-status">
                                                    <span class="status-indicator status-offline"></span>
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <input data-id="{{$item->id}}" class="toggle-class toggle-switch" type="checkbox"
                                                   data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                   data-on="Aktif" data-off="Nonaktif" {{ $item->status ? 'checked' : '' }}>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-info waves-effect"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Detail {{ $item->name }}"
                                                    onclick="lihatDetail({{ $item->id }})">
                                                <i class="bx bx-show"></i>
                                            </button>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-warning waves-effect"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Edit {{ $item->name }}"
                                                    onclick="editRestoran({{ $item->id }})">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($restaurants->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-restaurant"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Restoran Ditemukan</h4>
                            <p class="text-muted">Belum ada restoran yang terdaftar dalam sistem.</p>
                        </div>
                        @endif
                    </div>

                    @if ($restaurants->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $restaurants->firstItem() }} sampai {{ $restaurants->lastItem() }} dari {{ $restaurants->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $restaurants->links() }}
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

<!-- Modal Tampilan Gambar Besar -->
<div id="modalGambarBesar" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambarBesarLabel">Gambar Restoran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img id="gambarBesar" src="" alt="" class="img-fluid rounded" style="max-height: 500px;">
                <h6 class="mt-3" id="judulGambarBesar"></h6>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Restoran -->
<div id="modalDetailRestoran" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Restoran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="kontenDetailRestoran">
                <!-- Konten detail akan diisi via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Manajemen Restoran
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
    $('#filterStatus, #filterVerifikasi, #filterUrutan').on('change', function() {
        filterTabel();
    });

    // Select all checkbox
    $('#selectAll').on('change', function() {
        $('.pilih-restoran').prop('checked', this.checked);
    });
});

/**
 * Filter tabel berdasarkan pencarian dan filter
 */
function filterTabel() {
    const pencarian = $('#inputPencarian').val().toLowerCase();
    const status = $('#filterStatus').val();
    const verifikasi = $('#filterVerifikasi').val();
    const urutan = $('#filterUrutan').val();

    $('.baris-restoran').each(function() {
        const teksBaris = $(this).text().toLowerCase();
        const dataStatus = $(this).data('status').toString();
        const dataVerifikasi = $(this).data('verifikasi');
        const dataNama = $(this).data('nama');

        let tampilkan = true;

        // Filter pencarian
        if (pencarian && !teksBaris.includes(pencarian)) {
            tampilkan = false;
        }

        // Filter status
        if (status && dataStatus !== status) {
            tampilkan = false;
        }

        // Filter verifikasi
        if (verifikasi && dataVerifikasi !== verifikasi) {
            tampilkan = false;
        }

        $(this).toggle(tampilkan);
    });

    // Urutkan tabel berdasarkan pilihan
    urutkanTabel(urutan);

    // Tampilkan pesan jika tidak ada hasil
    const barisTampil = $('.baris-restoran:visible').length;
    if (barisTampil === 0) {
        $('#bodyTabelRestoran').html(`
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="bx bx-search display-4 text-muted d-block mb-2"></i>
                    <h5 class="text-muted">Tidak ada restoran ditemukan</h5>
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
 * Urutkan tabel berdasarkan kriteria
 */
function urutkanTabel(kriteria) {
    const tbody = $('#bodyTabelRestoran');
    const baris = tbody.find('.baris-restoran:visible').get();

    baris.sort(function(a, b) {
        const aData = $(a).data('nama');
        const bData = $(b).data('nama');
        const aStatus = $(a).data('status');
        const bStatus = $(b).data('status');

        switch(kriteria) {
            case 'nama':
                return aData.localeCompare(bData);
            case 'status':
                return bStatus - aStatus; // Aktif di atas
            case 'terlama':
                return 1; // Default order
            case 'terbaru':
            default:
                return -1; // Reverse order
        }
    });

    $.each(baris, function(index, row) {
        tbody.append(row);
    });
}

/**
 * Reset semua filter
 */
function resetFilter() {
    $('#inputPencarian').val('');
    $('#filterStatus').val('');
    $('#filterVerifikasi').val('');
    $('#filterUrutan').val('terbaru');
    $('#selectAll').prop('checked', false);
    $('.pilih-restoran').prop('checked', false);
    $('.baris-restoran').show();
    urutkanTabel('terbaru');
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
 * Lihat detail restoran
 */
function lihatDetail(id) {
    // Implementasi AJAX untuk mengambil detail restoran
    $('#kontenDetailRestoran').html(`
        <div class="text-center py-4">
            <div class="loading-spinner mx-auto"></div>
            <p>Memuat detail restoran...</p>
        </div>
    `);
    $('#modalDetailRestoran').modal('show');

    // Simulasi AJAX call
    setTimeout(() => {
        $('#kontenDetailRestoran').html(`
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ url('upload/no_image.jpg') }}" alt="Restoran" class="img-fluid rounded mb-3" style="max-height: 200px;">
                    <h5>Nama Restoran</h5>
                    <p class="text-muted">ID: ${id}</p>
                </div>
                <div class="col-md-8">
                    <h6>Informasi Kontak</h6>
                    <table class="table table-sm">
                        <tr><td><i class="bx bx-envelope me-2"></i>Email</td><td>restoran@example.com</td></tr>
                        <tr><td><i class="bx bx-phone me-2"></i>Telepon</td><td>08123456789</td></tr>
                        <tr><td><i class="bx bx-map me-2"></i>Alamat</td><td>Alamat restoran</td></tr>
                        <tr><td><i class="bx bx-calendar me-2"></i>Bergabung</td><td>1 Jan 2024</td></tr>
                    </table>
                </div>
            </div>
        `);
    }, 1000);
}

/**
 * Edit restoran
 */
function editRestoran(id) {
    // Redirect ke halaman edit
    window.location.href = '/admin/edit-client/' + id;
}

/**
 * Aktifkan restoran secara massal
 */
function aktifkanMassal() {
    const terpilih = $('.pilih-restoran:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu restoran!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Aktifkan Restoran?',
        text: `Anda akan mengaktifkan ${terpilih.length} restoran`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Aktifkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi aktivasi massal
            terpilih.each(function() {
                const id = $(this).data('id');
                // Panggil API untuk aktivasi
            });

            Swal.fire('Berhasil!', `${terpilih.length} restoran telah diaktifkan`, 'success');
        }
    });
}

/**
 * Nonaktifkan restoran secara massal
 */
function nonaktifkanMassal() {
    const terpilih = $('.pilih-restoran:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu restoran!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Nonaktifkan Restoran?',
        text: `Anda akan menonaktifkan ${terpilih.length} restoran`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Nonaktifkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi nonaktivasi massal
            terpilih.each(function() {
                const id = $(this).data('id');
                // Panggil API untuk nonaktivasi
            });

            Swal.fire('Berhasil!', `${terpilih.length} restoran telah dinonaktifkan`, 'success');
        }
    });
}

/**
 * Ekspor data restoran
 */
function eksporData() {
    Swal.fire({
        title: 'Ekspor Data',
        text: 'Pilih format ekspor:',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        showDenyButton: true,
        denyButtonText: 'CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            // Ekspor Excel
            window.location.href = '/admin/export-clients/excel';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Ekspor PDF
            window.location.href = '/admin/export-clients/pdf';
        } else if (result.isDenied) {
            // Ekspor CSV
            window.location.href = '/admin/export-clients/csv';
        }
    });
}

/**
 * Toggle status restoran (AJAX)
 */
$(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var client_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/clientchangeStatus',
            data: {'status': status, 'client_id': client_id},
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

                    // Refresh statistik
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
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
