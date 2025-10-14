@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Halaman Semua Kategori */
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

.gambar-kategori {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.gambar-kategori:hover {
    transform: scale(1.1);
    border-color: #667eea;
}

.status-aktif {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.status-nonaktif {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
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
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- mulai judul halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-category me-2"></i>Manajemen Kategori
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $category->count() }} Kategori</span>
                    </div>

                    <div class="page-title-right">
                        <a href="{{ route('add.category') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="bx bx-plus me-1"></i>Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir judul halaman -->

        <!-- Kartu Statistik -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-3 col-md-6">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Kategori</h5>
                                <h3 class="mb-0">{{ $category->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-category"></i>
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
                                <h3 class="mb-0">{{ $category->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-aktif">
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

        <div class="row animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-list-ul me-2"></i>Semua Kategori
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari kategori...">
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
                                        <th>Nama Kategori</th>
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelKategori">
                                    @foreach ($category as $key => $item)
                                    <tr class="baris-kategori">
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="bx bx-category text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item->category_name }}</h6>
                                                    <small class="text-muted">ID: {{ $item->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->category_name }}"
                                                 class="gambar-kategori"
                                                 data-bs-toggle="tooltip"
                                                 data-bs-title="Lihat gambar {{ $item->category_name }}"
                                                 onclick="tampilkanGambarBesar('{{ asset($item->image) }}', '{{ $item->category_name }}')">
                                        </td>
                                        <td>
                                            <span class="badge bg-success badge-status">
                                                <i class="bx bx-check-circle me-1"></i>Aktif
                                            </span>
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <a href="{{ route('edit.category', $item->id) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect"
                                               data-bs-toggle="tooltip"
                                               data-bs-title="Edit {{ $item->category_name }}">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger waves-effect tombol-hapus"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->category_name }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Hapus {{ $item->category_name }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($category->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-category"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Kategori Ditemukan</h4>
                            <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda.</p>
                            <a href="{{ route('add.category') }}" class="btn btn-primary waves-effect waves-light mt-3">
                                <i class="bx bx-plus me-1"></i>Tambah Kategori Pertama
                            </a>
                        </div>
                        @endif
                    </div>

                    @if($category->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $category->firstItem() }} sampai {{ $category->lastItem() }} dari {{ $category->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $category->links() }}
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

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusKategori" class="modal fade" tabindex="-1" aria-labelledby="modalHapusKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusKategoriLabel">
                    <i class="bx bx-trash me-2"></i>Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bx bx-error-circle display-1 text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus kategori ini?</h5>
                <p class="text-center text-muted">Anda akan menghapus: <strong id="namaKategoriHapus"></strong></p>
                <div class="alert alert-warning mt-3" role="alert">
                    <i class="bx bx-info-circle me-2"></i>
                    <small>Penghapusan kategori dapat mempengaruhi produk yang terkait.</small>
                </div>
                <p class="text-center text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusKategori" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger waves-effect waves-light" id="tombolKonfirmasiHapus">
                        <div class="loading-spinner" id="spinnerHapusKategori"></div>
                        <i class="bx bx-trash me-1"></i>
                        <span id="teksHapusKategori">Ya, Hapus</span>
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
                <h5 class="modal-title" id="modalGambarBesarLabel">Gambar Kategori</h5>
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
 * JavaScript untuk Manajemen Kategori
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian real-time
    $('#inputPencarian').on('keyup', function() {
        const nilai = $(this).val().toLowerCase();
        $('.baris-kategori').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(nilai) > -1);
        });

        // Tampilkan pesan jika tidak ada hasil
        const barisTampil = $('.baris-kategori:visible').length;
        if (barisTampil === 0 && nilai !== '') {
            $('#bodyTabelKategori').html(`
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="bx bx-search display-4 text-muted d-block mb-2"></i>
                        <h5 class="text-muted">Tidak ada hasil ditemukan</h5>
                        <p class="text-muted">Tidak ada kategori yang cocok dengan pencarian "<strong>${nilai}</strong>"</p>
                        <button type="button" class="btn btn-outline-primary waves-effect" onclick="resetPencarian()">
                            <i class="bx bx-reset me-1"></i>Reset Pencarian
                        </button>
                    </td>
                </tr>
            `);
        }
    });

    // Handler tombol hapus
    $('.tombol-hapus').on('click', function() {
        const idKategori = $(this).data('id');
        const namaKategori = $(this).data('nama');

        $('#namaKategoriHapus').text(namaKategori);
        $('#formHapusKategori').attr('action', '/delete/category/' + idKategori);
        $('#modalHapusKategori').modal('show');
    });

    // Handler pengiriman form hapus
    $('#formHapusKategori').on('submit', function() {
        const tombol = $('#tombolKonfirmasiHapus');
        tombol.prop('disabled', true);
        $('#spinnerHapusKategori').show();
        $('#teksHapusKategori').text('Menghapus...');
    });

    // Reset modal ketika ditutup
    $('#modalHapusKategori').on('hidden.bs.modal', function () {
        $('#tombolKonfirmasiHapus').prop('disabled', false);
        $('#spinnerHapusKategori').hide();
        $('#teksHapusKategori').text('Ya, Hapus');
    });
});

/**
 * Menampilkan gambar dalam modal besar
 */
function tampilkanGambarBesar(src, judul) {
    $('#gambarBesar').attr('src', src);
    $('#judulGambarBesar').text(judul);
    $('#modalGambarBesar').modal('show');
}

/**
 * Reset pencarian
 */
function resetPencarian() {
    $('#inputPencarian').val('');
    $('.baris-kategori').show();
    $('#bodyTabelKategori').html(`@foreach ($category as $key => $item)
        <tr class="baris-kategori">
            <td class="text-center">
                <div class="avatar-kecil mx-auto">
                    {{ $key + 1 }}
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <i class="bx bx-category text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $item->category_name }}</h6>
                        <small class="text-muted">ID: {{ $item->id }}</small>
                    </div>
                </div>
            </td>
            <td>
                <img src="{{ asset($item->image) }}" alt="{{ $item->category_name }}"
                     class="gambar-kategori"
                     data-bs-toggle="tooltip"
                     data-bs-title="Lihat gambar {{ $item->category_name }}"
                     onclick="tampilkanGambarBesar('{{ asset($item->image) }}', '{{ $item->category_name }}')">
            </td>
            <td>
                <span class="badge bg-success badge-status">
                    <i class="bx bx-check-circle me-1"></i>Aktif
                </span>
            </td>
            <td class="text-center tombol-aksi">
                <a href="{{ route('edit.category', $item->id) }}"
                   class="btn btn-sm btn-outline-primary waves-effect"
                   data-bs-toggle="tooltip"
                   data-bs-title="Edit {{ $item->category_name }}">
                    <i class="bx bx-edit"></i>
                </a>
                <button type="button"
                        class="btn btn-sm btn-outline-danger waves-effect tombol-hapus"
                        data-id="{{ $item->id }}"
                        data-nama="{{ $item->category_name }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="Hapus {{ $item->category_name }}">
                    <i class="bx bx-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach`);

    // Re-initialize tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Re-attach delete handlers
    $('.tombol-hapus').on('click', function() {
        const idKategori = $(this).data('id');
        const namaKategori = $(this).data('nama');

        $('#namaKategoriHapus').text(namaKategori);
        $('#formHapusKategori').attr('action', '/delete/category/' + idKategori);
        $('#modalHapusKategori').modal('show');
    });
}

/**
 * Ekspor data kategori (placeholder untuk fitur future)
 */
function eksporDataKategori(format) {
    // Implementasi ekspor data bisa ditambahkan di sini
    alert(`Fitur ekspor ${format} akan segera hadir!`);
}
</script>

@endsection
