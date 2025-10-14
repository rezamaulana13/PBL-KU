@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Dashboard Banner */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.badge-status {
    font-size: 0.75em;
    padding: 4px 8px;
}

.tombol-aksi .btn {
    margin: 2px;
    border-radius: 6px;
    font-weight: 500;
}

.tabel-rapat td, .tabel-rapat th {
    white-space: nowrap;
}

.header-modal {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.header-modal .btn-close {
    filter: invert(1);
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

.area-upload {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.area-upload:hover {
    border-color: #667eea;
    background: #f0f2ff;
}

.area-upload.drag-over {
    border-color: #667eea;
    background: #e6f0ff;
}

.preview-gambar {
    max-width: 100%;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.gambar-banner {
    width: 80px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid #e9ecef;
}

.gambar-banner-besar {
    width: 150px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- mulai judul halaman -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-image me-2"></i>Manajemen Banner
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $banner->count() }} Banner</span>
                    </div>

                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalTambahBanner">
                            <i class="bx bx-plus me-1"></i>Tambah Banner Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir judul halaman -->

        <!-- Kartu Statistik -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Banner</h5>
                                <h3 class="mb-0">{{ $banner->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-image"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card kartu-stats success card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Aktif</h5>
                                <h3 class="mb-0">{{ $banner->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                <i class="bx bx-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card kartu-stats warning card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Bulan Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                <i class="bx bx-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card kartu-stats info card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Terakhir Diupdate</h5>
                                <h6 class="mb-0">Baru saja</h6>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-time"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-list-ul me-2"></i>Semua Banner
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari banner...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th>Gambar Banner</th>
                                        <th>URL Banner</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelBanner">
                                    @foreach ($banner as $key=> $item)
                                    <tr class="baris-banner">
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key+1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="{{ asset($item->image) }}" alt="Banner {{ $key+1 }}" class="gambar-banner">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Banner {{ $key+1 }}</h6>
                                                    <small class="text-muted">ID: {{ $item->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->url)
                                                <a href="{{ $item->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $item->url }}">
                                                    {{ $item->url }}
                                                </a>
                                            @else
                                                <span class="text-muted">- Tidak ada URL -</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success badge-status">
                                                <i class="bx bx-check-circle me-1"></i>Aktif
                                            </span>
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <button type="button" class="btn btn-sm btn-outline-primary waves-effect"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditBanner"
                                                    id="{{ $item->id }}" onclick="editBanner(this.id)"
                                                    title="Edit Banner">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger waves-effect tombol-hapus"
                                                    data-id="{{ $item->id }}" data-nama="Banner {{ $key+1 }}"
                                                    title="Hapus Banner">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($banner->isEmpty())
                        <div class="text-center py-5">
                            <i class="bx bx-image display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Banner Ditemukan</h4>
                            <p class="text-muted">Mulai dengan menambahkan banner pertama Anda.</p>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalTambahBanner">
                                <i class="bx bx-plus me-1"></i>Tambah Banner Pertama
                            </button>
                        </div>
                        @endif
                    </div>

                    @if($banner->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $banner->firstItem() }} sampai {{ $banner->lastItem() }} dari {{ $banner->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $banner->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div> <!-- akhir kolom -->
        </div> <!-- akhir baris -->

    </div> <!-- container-fluid -->
</div>

<!-- Modal Tambah Banner -->
<div id="modalTambahBanner" class="modal fade" tabindex="-1" aria-labelledby="modalTambahBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="modalTambahBannerLabel">
                    <i class="bx bx-plus me-2"></i>Tambah Banner Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahBanner" action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="url_banner" class="form-label">URL Banner</label>
                                <input type="url" class="form-control @error('url') is-invalid @enderror"
                                       id="url_banner" name="url" placeholder="https://example.com"
                                       value="{{ old('url') }}">
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Masukkan URL ketika banner diklik.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="urutan_banner" class="form-label">Urutan Tampil</label>
                                <input type="number" class="form-control"
                                       id="urutan_banner" name="urutan" placeholder="1"
                                       value="{{ old('urutan', 1) }}" min="1" max="10">
                                <div class="form-text">Urutan penampilan banner (1-10).</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Banner <span class="text-danger">*</span></label>
                        <div class="area-upload" onclick="document.getElementById('gambar_banner').click()"
                             id="areaUpload" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                            <input type="file" class="d-none" name="image" id="gambar_banner" accept="image/*" required>
                            <div id="kontenUpload">
                                <i class="bx bx-cloud-upload display-4 text-muted mb-2"></i>
                                <p class="text-muted mb-1">Klik atau seret gambar ke sini</p>
                                <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                            </div>
                            <div id="namaFile" class="text-primary fw-bold mt-2" style="display: none;"></div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pratinjau Gambar</label>
                        <div class="text-center">
                            <img id="pratinjauGambar" src="{{ url('upload/profile.jpg') }}"
                                 alt="Pratinjau Banner" class="preview-gambar gambar-banner-besar">
                            <p class="text-muted mt-2 mb-0">Pratinjau akan muncul di sini</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolTambahBanner">
                        <div class="loading-spinner" id="spinnerTambahBanner"></div>
                        <i class="bx bx-save me-1"></i>
                        <span id="teksTambahBanner">Tambah Banner</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Banner -->
<div id="modalEditBanner" class="modal fade" tabindex="-1" aria-labelledby="modalEditBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="modalEditBannerLabel">
                    <i class="bx bx-edit me-2"></i>Edit Banner
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditBanner" action="{{ route('banner.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="banner_id" id="id_banner_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="url_banner_edit" class="form-label">URL Banner</label>
                                <input type="url" class="form-control @error('url') is-invalid @enderror"
                                       id="url_banner_edit" name="url" placeholder="https://example.com">
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="text-center">
                                    <img id="gambarBannerEdit" src="" alt="Banner Saat Ini" class="gambar-banner-besar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambar_banner_edit" class="form-label">Ganti Gambar Banner</label>
                        <input type="file" class="form-control" name="image" id="gambar_banner_edit" accept="image/*">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pratinjau Gambar Baru</label>
                        <div class="text-center">
                            <img id="pratinjauGambarEdit" src="" alt="Pratinjau Baru"
                                 class="preview-gambar gambar-banner-besar" style="display: none;">
                            <p class="text-muted mt-2 mb-0" id="teksPratinjauEdit">Pratinjau gambar baru akan muncul di sini</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolEditBanner">
                        <div class="loading-spinner" id="spinnerEditBanner"></div>
                        <i class="bx bx-save me-1"></i>
                        <span id="teksEditBanner">Update Banner</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusBanner" class="modal fade" tabindex="-1" aria-labelledby="modalHapusBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusBannerLabel">
                    <i class="bx bx-trash me-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bx bx-error-circle display-1 text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus banner ini?</h5>
                <p class="text-center text-muted">Anda akan menghapus: <strong id="namaBannerHapus"></strong></p>
                <p class="text-center text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusBanner" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger waves-effect waves-light" id="tombolKonfirmasiHapus">
                        <div class="loading-spinner" id="spinnerHapusBanner"></div>
                        <i class="bx bx-trash me-1"></i>
                        <span id="teksHapusBanner">Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Manajemen Banner
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian
    $('#inputPencarian').on('keyup', function() {
        const nilai = $(this).val().toLowerCase();
        $('.baris-banner').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(nilai) > -1);
        });
    });

    // Handler tombol hapus
    $('.tombol-hapus').on('click', function() {
        const idBanner = $(this).data('id');
        const namaBanner = $(this).data('nama');

        $('#namaBannerHapus').text(namaBanner);
        $('#formHapusBanner').attr('action', '/delete/banner/' + idBanner);
        $('#modalHapusBanner').modal('show');
    });

    // Handler pengiriman form
    $('#formTambahBanner').on('submit', function() {
        const tombol = $('#tombolTambahBanner');
        tombol.prop('disabled', true);
        $('#spinnerTambahBanner').show();
        $('#teksTambahBanner').text('Menambahkan...');
    });

    $('#formEditBanner').on('submit', function() {
        const tombol = $('#tombolEditBanner');
        tombol.prop('disabled', true);
        $('#spinnerEditBanner').show();
        $('#teksEditBanner').text('Memperbarui...');
    });

    $('#formHapusBanner').on('submit', function() {
        const tombol = $('#tombolKonfirmasiHapus');
        tombol.prop('disabled', true);
        $('#spinnerHapusBanner').show();
        $('#teksHapusBanner').text('Menghapus...');
    });

    // Preview gambar untuk form tambah
    $('#gambar_banner').change(function(e){
        tampilkanPratinjauGambar(this, '#pratinjauGambar');
        $('#namaFile').text(this.files[0]?.name).show();
        $('#kontenUpload').html(`<i class="bx bx-check-circle display-4 text-success mb-2"></i>
                               <p class="text-success mb-1">File dipilih</p>`);
    });

    // Preview gambar untuk form edit
    $('#gambar_banner_edit').change(function(e){
        tampilkanPratinjauGambar(this, '#pratinjauGambarEdit');
        $('#pratinjauGambarEdit').show();
        $('#teksPratinjauEdit').text('Pratinjau gambar baru');
    });
});

/**
 * Fungsi untuk menampilkan pratinjau gambar
 */
function tampilkanPratinjauGambar(input, selectorPratinjau) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(selectorPratinjau).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Fungsi edit banner
 */
function editBanner(id) {
    $.ajax({
        type: 'GET',
        url: '/edit/banner/' + id,
        dataType: 'json',
        beforeSend: function() {
            // Tampilkan status loading
            $('#tombolEditBanner').prop('disabled', true);
            $('#teksEditBanner').text('Memuat...');
        },
        success: function(data) {
            $('#url_banner_edit').val(data.url);
            $('#gambarBannerEdit').attr('src', data.image);
            $('#id_banner_edit').val(data.id);

            // Reset pratinjau gambar baru
            $('#pratinjauGambarEdit').hide();
            $('#teksPratinjauEdit').text('Pratinjau gambar baru akan muncul di sini');

            // Reset status tombol
            $('#tombolEditBanner').prop('disabled', false);
            $('#teksEditBanner').text('Update Banner');
        },
        error: function(xhr, status, error) {
            console.error('Error mengambil data banner:', error);
            alert('Error memuat data banner. Silakan coba lagi.');
            $('#modalEditBanner').modal('hide');
        }
    });
}

/**
 * Fungsi drag and drop
 */
function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    $('#areaUpload').addClass('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    $('#areaUpload').removeClass('drag-over');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        $('#gambar_banner').prop('files', files);
        tampilkanPratinjauGambar($('#gambar_banner')[0], '#pratinjauGambar');
        $('#namaFile').text(files[0].name).show();
        $('#kontenUpload').html(`<i class="bx bx-check-circle display-4 text-success mb-2"></i>
                               <p class="text-success mb-1">File dipilih</p>`);
    }
}

/**
 * Reset form ketika modal ditutup
 */
$('#modalTambahBanner').on('hidden.bs.modal', function () {
    $('#formTambahBanner')[0].reset();
    $('#pratinjauGambar').attr('src', '{{ url('upload/profile.jpg') }}');
    $('#namaFile').hide();
    $('#kontenUpload').html(`<i class="bx bx-cloud-upload display-4 text-muted mb-2"></i>
                           <p class="text-muted mb-1">Klik atau seret gambar ke sini</p>
                           <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>`);
    $('#tombolTambahBanner').prop('disabled', false);
    $('#spinnerTambahBanner').hide();
    $('#teksTambahBanner').text('Tambah Banner');
});

$('#modalEditBanner').on('hidden.bs.modal', function () {
    $('#tombolEditBanner').prop('disabled', false);
    $('#spinnerEditBanner').hide();
    $('#teksEditBanner').text('Update Banner');
});

$('#modalHapusBanner').on('hidden.bs.modal', function () {
    $('#tombolKonfirmasiHapus').prop('disabled', false);
    $('#spinnerHapusBanner').hide();
    $('#teksHapusBanner').text('Ya, Hapus');
});

/**
 * Auto-focus pada input URL ketika modal terbuka
 */
$('#modalTambahBanner').on('shown.bs.modal', function () {
    $('#url_banner').focus();
});

$('#modalEditBanner').on('shown.bs.modal', function () {
    $('#url_banner_edit').focus();
});
</script>

@endsection
