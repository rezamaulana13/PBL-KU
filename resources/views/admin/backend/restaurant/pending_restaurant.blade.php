@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
/* Gaya Kustom untuk Halaman Pending Restaurant */
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
.kartu-stats.warning { border-color: #ffc107; }
.kartu-stats.danger { border-color: #dc3545; }
.kartu-stats.success { border-color: #28a745; }
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

.status-pending {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.status-rejected {
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

.status-pending-ind { background-color: #ffc107; }
.status-rejected-ind { background-color: #dc3545; }
.status-approved-ind { background-color: #28a745; }

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

.pending-highlight {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
    border-left: 4px solid #ffc107;
}

.urgent-badge {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    animation: blink 2s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}

.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.bulk-actions {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 2px dashed #dee2e6;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-warning">
                            <i class="bx bx-time me-2"></i>Restoran Menunggu Persetujuan
                        </h4>
                        <span class="badge bg-warning ms-2">{{ $restaurants->where('status', 0)->count() }} Pending</span>
                    </div>

                    <div class="page-title-right">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Perlu verifikasi segera</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Judul -->

        <!-- Kartu Statistik Pending -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats warning card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Pending</h5>
                                <h3 class="mb-0">{{ $restaurants->where('status', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-pending">
                                <i class="bx bx-time"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Menunggu >7 Hari</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil status-rejected">
                                <i class="bx bx-alarm"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Baru Hari Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil">
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
                                <h5 class="font-size-14 text-muted mb-0">Butuh Dokumen</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-file"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Disetujui Bulan Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                <i class="bx bx-check-circle"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Ditolak Bulan Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil status-rejected">
                                <i class="bx bx-x-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Massal -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-12">
                <div class="bulk-actions">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="selectAllPending" class="form-check-input">
                                <label class="form-check-label fw-semibold" for="selectAllPending">
                                    Pilih Semua Restoran Pending
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-success waves-effect waves-light" onclick="approveSelected()">
                                    <i class="bx bx-check-circle me-1"></i>Setujui yang Dipilih
                                </button>
                                <button class="btn btn-danger waves-effect waves-light" onclick="rejectSelected()">
                                    <i class="bx bx-x-circle me-1"></i>Tolak yang Dipilih
                                </button>
                                <button class="btn btn-outline-primary waves-effect" onclick="exportPendingData()">
                                    <i class="bx bx-download me-1"></i>Ekspor Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.3s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="bx bx-filter me-2"></i>Filter Restoran Pending
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari restoran pending...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Durasi Pending</label>
                                <select class="form-select" id="filterDurasi">
                                    <option value="">Semua Durasi</option>
                                    <option value="hari-ini">Baru Hari Ini</option>
                                    <option value="3-hari">1-3 Hari</option>
                                    <option value="7-hari">4-7 Hari</option>
                                    <option value="lebih-7">> 7 Hari</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Tipe Restoran</label>
                                <select class="form-select" id="filterTipe">
                                    <option value="">Semua Tipe</option>
                                    <option value="restoran">Restoran</option>
                                    <option value="kafe">Kafe</option>
                                    <option value="warung">Warung</option>
                                    <option value="foodcourt">Food Court</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Status Dokumen</label>
                                <select class="form-select" id="filterDokumen">
                                    <option value="">Semua Status</option>
                                    <option value="lengkap">Dokumen Lengkap</option>
                                    <option value="kurang">Dokumen Kurang</option>
                                    <option value="belum-upload">Belum Upload</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Prioritas</label>
                                <select class="form-select" id="filterPrioritas">
                                    <option value="">Semua Prioritas</option>
                                    <option value="tinggi">Prioritas Tinggi</option>
                                    <option value="sedang">Prioritas Sedang</option>
                                    <option value="rendah">Prioritas Rendah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Restoran Pending -->
        <div class="row animasi-muncul" style="animation-delay: 0.4s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="bx bx-list-ul me-2"></i>Daftar Restoran Menunggu Persetujuan
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-warning btn-sm" onclick="resetFilter()">
                                    <i class="bx bx-reset me-1"></i>Reset Filter
                                </button>
                                <span class="badge bg-warning ms-2" id="countPending">
                                    {{ $restaurants->where('status', 0)->count() }} restoran pending
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-warning">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th style="width: 80px;">Gambar</th>
                                        <th>Informasi Restoran</th>
                                        <th>Kontak & Detail</th>
                                        <th class="text-center" style="width: 120px;">Status Pendaftaran</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelPending">
                                    @foreach ($restaurants->where('status', 0) as $key=> $item)
                                    <tr class="baris-pending pending-highlight"
                                        data-durasi="3-hari"
                                        data-tipe="restoran"
                                        data-dokumen="lengkap"
                                        data-prioritas="sedang"
                                        data-nama="{{ strtolower($item->name) }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input pilih-pending" data-id="{{ $item->id }}">
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
                                                        <span class="ms-2">
                                                            <i class="bx bx-calendar me-1"></i>
                                                            {{ $item->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    @if($item->created_at->diffInDays(now()) < 2)
                                                    <span class="badge bg-danger urgent-badge badge-status mt-1">
                                                        <i class="bx bx-alarm me-1"></i>Baru!
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
                                                <div class="mb-1">
                                                    <i class="bx bx-phone me-1"></i>
                                                    <a href="tel:{{ $item->phone }}" class="text-muted">{{ $item->phone ?? 'Tidak ada telepon' }}</a>
                                                </div>
                                                <div>
                                                    <i class="bx bx-file me-1"></i>
                                                    <small class="text-success">Dokumen lengkap</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning badge-status">
                                                <span class="status-indicator status-pending-ind"></span>
                                                Menunggu Review
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    {{ $item->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button type="button"
                                                        class="btn btn-sm btn-success waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Setujui {{ $item->name }}"
                                                        onclick="approveRestoran({{ $item->id }}, '{{ $item->name }}')">
                                                    <i class="bx bx-check"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-sm btn-danger waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Tolak {{ $item->name }}"
                                                        onclick="rejectRestoran({{ $item->id }}, '{{ $item->name }}')">
                                                    <i class="bx bx-x"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-sm btn-info waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Detail {{ $item->name }}"
                                                        onclick="lihatDetailPending({{ $item->id }})">
                                                    <i class="bx bx-show"></i>
                                                </button>

                                                <input data-id="{{$item->id}}" class="toggle-class toggle-switch" type="checkbox"
                                                       data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                       data-on="Aktif" data-off="Nonaktif" {{ $item->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($restaurants->where('status', 0)->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-party display-1 text-success"></i>
                            <h4 class="text-success mt-3">Tidak Ada Restoran Pending!</h4>
                            <p class="text-muted">Semua restoran telah diproses. Kerja bagus! 🎉</p>
                            <div class="mt-3">
                                <span class="badge bg-success badge-status">
                                    <i class="bx bx-check-circle me-1"></i>Semua terselesaikan
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($restaurants->hasPages())
    <div class="card-footer bg-light border-top-0">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="text-muted">
                    {{-- Ganti $client menjadi $restaurants (Jika Anda sudah fix error Undefined Variable) --}}
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

<!-- Modal Detail Pending -->
<div id="modalDetailPending" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title text-warning">
                    <i class="bx bx-detail me-2"></i>Detail Restoran Pending
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="kontenDetailPending">
                <!-- Konten detail akan diisi via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Halaman Pending Restaurant
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian real-time
    $('#inputPencarian').on('keyup', function() {
        filterTabelPending();
    });

    // Filter perubahan
    $('#filterDurasi, #filterTipe, #filterDokumen, #filterPrioritas').on('change', function() {
        filterTabelPending();
    });

    // Select all checkbox
    $('#selectAll, #selectAllPending').on('change', function() {
        $('.pilih-pending').prop('checked', this.checked);
    });

    // Update counter
    updatePendingCounter();
});

/**
 * Filter tabel pending
 */
function filterTabelPending() {
    const pencarian = $('#inputPencarian').val().toLowerCase();
    const durasi = $('#filterDurasi').val();
    const tipe = $('#filterTipe').val();
    const dokumen = $('#filterDokumen').val();
    const prioritas = $('#filterPrioritas').val();

    let tampilCount = 0;

    $('.baris-pending').each(function() {
        const teksBaris = $(this).text().toLowerCase();
        const dataDurasi = $(this).data('durasi');
        const dataTipe = $(this).data('tipe');
        const dataDokumen = $(this).data('dokumen');
        const dataPrioritas = $(this).data('prioritas');
        const dataNama = $(this).data('nama');

        let tampilkan = true;

        // Filter pencarian
        if (pencarian && !teksBaris.includes(pencarian)) {
            tampilkan = false;
        }

        // Filter durasi
        if (durasi && dataDurasi !== durasi) {
            tampilkan = false;
        }

        // Filter tipe
        if (tipe && dataTipe !== tipe) {
            tampilkan = false;
        }

        // Filter dokumen
        if (dokumen && dataDokumen !== dokumen) {
            tampilkan = false;
        }

        // Filter prioritas
        if (prioritas && dataPrioritas !== prioritas) {
            tampilkan = false;
        }

        $(this).toggle(tampilkan);
        if (tampilkan) tampilCount++;
    });

    updatePendingCounter(tampilCount);
}

/**
 * Update counter pending
 */
function updatePendingCounter(count = null) {
    const total = count !== null ? count : $('.baris-pending:visible').length;
    $('#countPending').text(`${total} restoran pending`);
}

/**
 * Reset semua filter
 */
function resetFilter() {
    $('#inputPencarian').val('');
    $('#filterDurasi').val('');
    $('#filterTipe').val('');
    $('#filterDokumen').val('');
    $('#filterPrioritas').val('');
    $('#selectAll').prop('checked', false);
    $('#selectAllPending').prop('checked', false);
    $('.pilih-pending').prop('checked', false);
    $('.baris-pending').show();
    updatePendingCounter();
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
 * Lihat detail restoran pending
 */
function lihatDetailPending(id) {
    $('#kontenDetailPending').html(`
        <div class="text-center py-4">
            <div class="loading-spinner mx-auto"></div>
            <p>Memuat detail restoran...</p>
        </div>
    `);
    $('#modalDetailPending').modal('show');

    // Simulasi AJAX call
    setTimeout(() => {
        $('#kontenDetailPending').html(`
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ url('upload/no_image.jpg') }}" alt="Restoran" class="img-fluid rounded mb-3" style="max-height: 200px;">
                    <h5>Nama Restoran</h5>
                    <p class="text-muted">ID: ${id}</p>
                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                </div>
                <div class="col-md-8">
                    <h6>Informasi Pendaftaran</h6>
                    <table class="table table-sm">
                        <tr><td><i class="bx bx-envelope me-2"></i>Email</td><td>restoran@example.com</td></tr>
                        <tr><td><i class="bx bx-phone me-2"></i>Telepon</td><td>08123456789</td></tr>
                        <tr><td><i class="bx bx-calendar me-2"></i>Tanggal Daftar</td><td>1 nov 2025</td></tr>
                        <tr><td><i class="bx bx-time me-2"></i>Durasi Pending</td><td>3 hari</td></tr>
                        <tr><td><i class="bx bx-file me-2"></i>Status Dokumen</td><td><span class="text-success">Lengkap</span></td></tr>
                    </table>

                    <div class="mt-3">
                        <button class="btn btn-success w-100 mb-2" onclick="approveRestoran(${id}, 'Nama Restoran')">
                            <i class="bx bx-check-circle me-1"></i>Setujui Restoran
                        </button>
                        <button class="btn btn-danger w-100" onclick="rejectRestoran(${id}, 'Nama Restoran')">
                            <i class="bx bx-x-circle me-1"></i>Tolak Restoran
                        </button>
                    </div>
                </div>
            </div>
        `);
    }, 1000);
}

/**
 * Setujui restoran individual
 */
function approveRestoran(id, nama) {
    Swal.fire({
        title: 'Setujui Restoran?',
        html: `Anda akan menyetujui <strong>${nama}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi approval
            $.ajax({
                type: "POST",
                url: '/admin/approve-restaurant/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 1
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `Restoran ${nama} telah disetujui`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui restoran', 'error');
                }
            });
        }
    });
}

/**
 * Tolak restoran individual
 */
function rejectRestoran(id, nama) {
    Swal.fire({
        title: 'Tolak Restoran?',
        html: `Anda akan menolak <strong>${nama}</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Masukkan alasan penolakan...',
        inputAttributes: {
            'aria-label': 'Masukkan alasan penolakan'
        },
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            const alasan = result.value;
            // Implementasi rejection dengan alasan
            $.ajax({
                type: "POST",
                url: '/admin/reject-restaurant/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 0,
                    rejection_reason: alasan
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `Restoran ${nama} telah ditolak`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menolak restoran', 'error');
                }
            });
        }
    });
}

/**
 * Setujui restoran yang dipilih
 */
function approveSelected() {
    const terpilih = $('.pilih-pending:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu restoran!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Setujui Restoran?',
        html: `Anda akan menyetujui <strong>${terpilih.length} restoran</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui Semua!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi approval massal
            const ids = terpilih.map(function() {
                return $(this).data('id');
            }).get();

            $.ajax({
                type: "POST",
                url: '/admin/approve-restaurants-bulk',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `${terpilih.length} restoran telah disetujui`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui restoran', 'error');
                }
            });
        }
    });
}

/**
 * Tolak restoran yang dipilih
 */
function rejectSelected() {
    const terpilih = $('.pilih-pending:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu restoran!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Tolak Restoran?',
        html: `Anda akan menolak <strong>${terpilih.length} restoran</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak Semua!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi rejection massal
            const ids = terpilih.map(function() {
                return $(this).data('id');
            }).get();

            $.ajax({
                type: "POST",
                url: '/admin/reject-restaurants-bulk',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `${terpilih.length} restoran telah ditolak`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menolak restoran', 'error');
                }
            });
        }
    });
}

/**
 * Ekspor data pending
 */
function exportPendingData() {
    Swal.fire({
        title: 'Ekspor Data Pending',
        text: 'Pilih format ekspor:',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        showDenyButton: true,
        denyButtonText: 'CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/export-pending/excel';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = '/admin/export-pending/pdf';
        } else if (result.isDenied) {
            window.location.href = '/admin/export-pending/csv';
        }
    });
}

/**
 * Toggle status restoran (AJAX) - untuk kompatibilitas
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
