@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Dashboard Kota */
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
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- mulai judul halaman -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-buildings me-2"></i>Manajemen Kota
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $city->count() }} Kota</span>
                    </div>

                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalTambahKota">
                            <i class="bx bx-plus me-1"></i>Tambah Kota Baru
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
                                <h5 class="font-size-14 text-muted mb-0">Total Kota</h5>
                                <h3 class="mb-0">{{ $city->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-buildings"></i>
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
                                <h3 class="mb-0">{{ $city->count() }}</h3>
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
                                    <i class="bx bx-list-ul me-2"></i>Semua Kota
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari kota...">
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
                                        <th>Nama Kota</th>
                                        <th>Slug Kota</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelKota">
                                    @foreach ($city as $key=> $item)
                                    <tr class="baris-kota">
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key+1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-building-house text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item->city_name }}</h6>
                                                    <small class="text-muted">ID: {{ $item->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark font-size-12">{{ $item->city_slug }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success badge-status">
                                                <i class="bx bx-check-circle me-1"></i>Aktif
                                            </span>
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <button type="button" class="btn btn-sm btn-outline-primary waves-effect"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditKota"
                                                    id="{{ $item->id }}" onclick="editKota(this.id)"
                                                    title="Edit Kota">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger waves-effect tombol-hapus"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->city_name }}"
                                                    title="Hapus Kota">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($city->isEmpty())
                        <div class="text-center py-5">
                            <i class="bx bx-building-house display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Kota Ditemukan</h4>
                            <p class="text-muted">Mulai dengan menambahkan kota pertama Anda.</p>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalTambahKota">
                                <i class="bx bx-plus me-1"></i>Tambah Kota Pertama
                            </button>
                        </div>
                        @endif
                    </div>

                    @if($city->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $city->firstItem() }} sampai {{ $city->lastItem() }} dari {{ $city->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $city->links() }}
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

<!-- Modal Tambah Kota -->
<div id="modalTambahKota" class="modal fade" tabindex="-1" aria-labelledby="modalTambahKotaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="modalTambahKotaLabel">
                    <i class="bx bx-plus me-2"></i>Tambah Kota Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formTambahKota" action="{{ route('city.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kota" class="form-label">Nama Kota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city_name') is-invalid @enderror"
                               id="nama_kota" name="city_name" placeholder="Masukkan nama kota" required
                               oninput="generateSlug(this.value)">
                        @error('city_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Masukkan nama kota yang ingin ditambahkan.</div>
                    </div>
                    <div class="mb-3">
                        <label for="preview_slug" class="form-label">Pratinjau Slug Kota</label>
                        <input type="text" class="form-control bg-light" id="preview_slug" readonly>
                        <div class="form-text">Slug ini akan digenerate otomatis dari nama kota.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolTambahKota">
                        <div class="loading-spinner" id="spinnerTambahKota"></div>
                        <i class="bx bx-save me-1"></i>
                        <span id="teksTambahKota">Tambah Kota</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kota -->
<div id="modalEditKota" class="modal fade" tabindex="-1" aria-labelledby="modalEditKotaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title" id="modalEditKotaLabel">
                    <i class="bx bx-edit me-2"></i>Edit Kota
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditKota" action="{{ route('city.update') }}" method="post">
                @csrf
                <input type="hidden" name="cat_id" id="id_kota_edit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kota_edit" class="form-label">Nama Kota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city_name') is-invalid @enderror"
                               id="nama_kota_edit" name="city_name" placeholder="Masukkan nama kota" required
                               oninput="generateSlugEdit(this.value)">
                        @error('city_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="preview_slug_edit" class="form-label">Pratinjau Slug Kota</label>
                        <input type="text" class="form-control bg-light" id="preview_slug_edit" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolEditKota">
                        <div class="loading-spinner" id="spinnerEditKota"></div>
                        <i class="bx bx-save me-1"></i>
                        <span id="teksEditKota">Update Kota</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusKota" class="modal fade" tabindex="-1" aria-labelledby="modalHapusKotaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusKotaLabel">
                    <i class="bx bx-trash me-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bx bx-error-circle display-1 text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus kota ini?</h5>
                <p class="text-center text-muted">Anda akan menghapus: <strong id="namaKotaHapus"></strong></p>
                <p class="text-center text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusKota" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger waves-effect waves-light" id="tombolKonfirmasiHapus">
                        <div class="loading-spinner" id="spinnerHapusKota"></div>
                        <i class="bx bx-trash me-1"></i>
                        <span id="teksHapusKota">Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Manajemen Kota
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
        $('.baris-kota').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(nilai) > -1);
        });
    });

    // Handler tombol hapus
    $('.tombol-hapus').on('click', function() {
        const idKota = $(this).data('id');
        const namaKota = $(this).data('nama');

        $('#namaKotaHapus').text(namaKota);
        $('#formHapusKota').attr('action', '/delete/city/' + idKota);
        $('#modalHapusKota').modal('show');
    });

    // Handler pengiriman form
    $('#formTambahKota').on('submit', function() {
        const tombol = $('#tombolTambahKota');
        tombol.prop('disabled', true);
        $('#spinnerTambahKota').show();
        $('#teksTambahKota').text('Menambahkan...');
    });

    $('#formEditKota').on('submit', function() {
        const tombol = $('#tombolEditKota');
        tombol.prop('disabled', true);
        $('#spinnerEditKota').show();
        $('#teksEditKota').text('Memperbarui...');
    });

    $('#formHapusKota').on('submit', function() {
        const tombol = $('#tombolKonfirmasiHapus');
        tombol.prop('disabled', true);
        $('#spinnerHapusKota').show();
        $('#teksHapusKota').text('Menghapus...');
    });
});

/**
 * Generate slug dari nama kota untuk form tambah
 */
function generateSlug(namaKota) {
    if (namaKota) {
        const slug = namaKota.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
        $('#preview_slug').val(slug);
    } else {
        $('#preview_slug').val('');
    }
}

/**
 * Generate slug dari nama kota untuk form edit
 */
function generateSlugEdit(namaKota) {
    if (namaKota) {
        const slug = namaKota.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
        $('#preview_slug_edit').val(slug);
    } else {
        $('#preview_slug_edit').val('');
    }
}

/**
 * Fungsi edit kota
 */
function editKota(id) {
    $.ajax({
        type: 'GET',
        url: '/edit/city/' + id,
        dataType: 'json',
        beforeSend: function() {
            // Tampilkan status loading
            $('#tombolEditKota').prop('disabled', true);
            $('#teksEditKota').text('Memuat...');
        },
        success: function(data) {
            $('#nama_kota_edit').val(data.city_name);
            $('#id_kota_edit').val(data.id);

            // Generate preview slug
            generateSlugEdit(data.city_name);

            // Reset status tombol
            $('#tombolEditKota').prop('disabled', false);
            $('#teksEditKota').text('Update Kota');
        },
        error: function(xhr, status, error) {
            console.error('Error mengambil data kota:', error);
            alert('Error memuat data kota. Silakan coba lagi.');
            $('#modalEditKota').modal('hide');
        }
    });
}

/**
 * Reset form ketika modal ditutup
 */
$('#modalTambahKota').on('hidden.bs.modal', function () {
    $('#formTambahKota')[0].reset();
    $('#preview_slug').val('');
    $('#tombolTambahKota').prop('disabled', false);
    $('#spinnerTambahKota').hide();
    $('#teksTambahKota').text('Tambah Kota');
});

$('#modalEditKota').on('hidden.bs.modal', function () {
    $('#tombolEditKota').prop('disabled', false);
    $('#spinnerEditKota').hide();
    $('#teksEditKota').text('Update Kota');
});

$('#modalHapusKota').on('hidden.bs.modal', function () {
    $('#tombolKonfirmasiHapus').prop('disabled', false);
    $('#spinnerHapusKota').hide();
    $('#teksHapusKota').text('Ya, Hapus');
});

/**
 * Auto-focus pada input nama kota ketika modal terbuka
 */
$('#modalTambahKota').on('shown.bs.modal', function () {
    $('#nama_kota').focus();
});

$('#modalEditKota').on('shown.bs.modal', function () {
    $('#nama_kota_edit').focus();
});
</script>

@endsection
