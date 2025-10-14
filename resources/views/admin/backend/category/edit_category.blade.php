@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Halaman Edit Kategori */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
}

.area-upload {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.area-upload:hover {
    border-color: #667eea;
    background: #f0f2ff;
    transform: translateY(-2px);
}

.area-upload.drag-over {
    border-color: #667eea;
    background: #e6f0ff;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.preview-gambar {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.preview-gambar:hover {
    transform: scale(1.05);
    border-color: #667eea;
}

.loading-spinner {
    display: none;
    width: 18px;
    height: 18px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.ikon-upload {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.area-upload:hover .ikon-upload {
    color: #667eea;
    transform: scale(1.1);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.required-field::after {
    content: " *";
    color: #dc3545;
}

.alert-panduan {
    border-left: 4px solid #17a2b8;
    background: #f8f9fa;
}

.ikon-panduan {
    font-size: 1.5rem;
    color: #17a2b8;
}

.kartu-panduan {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.kartu-panduan:hover {
    border-color: #667eea;
    transform: translateY(-2px);
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

.badge-status {
    font-size: 0.75em;
    padding: 4px 8px;
}

.info-kategori {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
}

.ikon-info {
    font-size: 2rem;
    opacity: 0.8;
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
                            <i class="bx bx-edit me-2"></i>Edit Kategori
                        </h4>
                        <span class="badge bg-warning ms-2">Edit Mode</span>
                    </div>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('all.category') }}">Semua Kategori</a></li>
                            <li class="breadcrumb-item active">Edit Kategori</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir judul halaman -->

        <div class="row animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-8 col-lg-7">
                <!-- Kartu Formulir Utama -->
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-edit me-2"></i>Formulir Edit Kategori
                        </h5>
                        <p class="text-muted mb-0 mt-1">Perbarui informasi kategori di bawah ini</p>
                    </div>

                    <div class="card-body p-4">
                        <form id="formEditKategori" action="{{ route('category.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $category->id }}">

                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Field Nama Kategori -->
                                    <div class="mb-4">
                                        <label for="nama_kategori" class="form-label required-field">
                                            <i class="bx bx-tag me-1"></i>Nama Kategori
                                        </label>
                                        <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                               name="category_name" id="nama_kategori"
                                               placeholder="Masukkan nama kategori"
                                               value="{{ old('category_name', $category->category_name) }}"
                                               oninput="updateSlugPreview(this.value)">
                                        @error('category_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bx bx-info-circle me-1"></i>Nama kategori akan ditampilkan di website
                                        </div>
                                    </div>

                                    <!-- Preview Slug Otomatis -->
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="bx bx-link me-1"></i>Pratinjau Slug
                                        </label>
                                        <input type="text" class="form-control bg-light" id="preview_slug" readonly value="{{ $category->category_slug ?? '' }}">
                                        <div class="form-text">Slug akan digenerate otomatis dari nama kategori</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Gambar Saat Ini -->
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="bx bx-image me-1"></i>Gambar Saat Ini
                                        </label>
                                        <div class="text-center">
                                            <img src="{{ asset($category->image) }}" alt="Gambar Saat Ini"
                                                 class="preview-gambar" id="gambarSaatIni">
                                            <p class="text-muted mt-2 mb-0">{{ $category->category_name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <!-- Field Upload Gambar Baru -->
                                    <div class="mb-4">
                                        <label for="gambar_kategori" class="form-label">
                                            <i class="bx bx-upload me-1"></i>Ganti Gambar Kategori
                                        </label>
                                        <div class="area-upload" onclick="document.getElementById('gambar_kategori').click()"
                                             id="areaUpload" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                                            <input type="file" class="d-none" name="image" id="gambar_kategori" accept="image/*">
                                            <div id="kontenUpload">
                                                <i class="bx bx-cloud-upload ikon-upload"></i>
                                                <p class="text-muted mb-1 fw-semibold">Klik atau seret gambar ke sini</p>
                                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                            </div>
                                            <div id="namaFile" class="text-primary fw-bold mt-2" style="display: none;"></div>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Preview Gambar Baru -->
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="bx bx-show me-1"></i>Pratinjau Gambar Baru
                                        </label>
                                        <div class="text-center">
                                            <img id="pratinjauGambarBaru" src=""
                                                 alt="Pratinjau Gambar Baru" class="preview-gambar" style="display: none;">
                                            <p class="text-muted mt-2 mb-0" id="teksPratinjau">Pratinjau gambar baru akan muncul di sini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Metadata -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="info-kategori p-3 rounded-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="mb-1 text-white">
                                                    <i class="bx bx-info-circle me-2"></i>Informasi Kategori
                                                </h6>
                                                <small class="text-white-50">
                                                    ID: {{ $category->id }} |
                                                    Dibuat: {{ $category->created_at->format('d M Y') }} |
                                                    Diupdate: {{ $category->updated_at->format('d M Y') }}
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <i class="bx bx-category ikon-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('all.category') }}" class="btn btn-light waves-effect">
                                            <i class="bx bx-arrow-back me-1"></i>Kembali
                                        </a>
                                        <button type="button" class="btn btn-outline-danger waves-effect" onclick="resetForm()">
                                            <i class="bx bx-reset me-1"></i>Reset Perubahan
                                        </button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolSubmit">
                                            <div class="loading-spinner" id="spinnerSubmit"></div>
                                            <i class="bx bx-save me-1"></i>
                                            <span id="teksSubmit">Perbarui Kategori</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <!-- Panel Panduan Edit -->
                <div class="card card-hover shadow-sm kartu-panduan">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-info-circle me-2"></i>Panduan Edit
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-panduan mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bx bx-bulb ikon-panduan"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="alert-heading mb-2">Tips Edit Kategori!</h6>
                                    <p class="mb-0">Pastikan perubahan tidak mempengaruhi produk yang terkait.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-check-shield me-1"></i>Yang Perlu Diperhatikan
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Nama kategori harus tetap unik</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Gambar baru akan mengganti yang lama</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Perubahan langsung berlaku</small>
                                </li>
                                <li>
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Backup data secara berkala</small>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-history me-1"></i>Riwayat Perubahan
                            </h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Dibuat</small>
                                <span class="badge bg-light text-dark">{{ $category->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Terakhir Diupdate</small>
                                <span class="badge bg-light text-dark">{{ $category->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Status Upload -->
                <div class="card card-hover shadow-sm mt-4 kartu-panduan">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-cloud-upload me-2"></i>Status Perubahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="statusUpload" class="text-center">
                            <i class="bx bx-edit text-primary display-4 d-block mb-2"></i>
                            <p class="text-muted mb-0">Mode edit aktif</p>
                            <small class="text-muted">Siap untuk melakukan perubahan</small>
                        </div>
                    </div>
                </div>

                <!-- Panel Preview Perubahan -->
                <div class="card card-hover shadow-sm mt-4 kartu-panduan">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-show me-2"></i>Preview Perubahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Nama Saat Ini:</small>
                            <span class="fw-semibold">{{ $category->category_name }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Gambar Saat Ini:</small>
                            <img src="{{ asset($category->image) }}" alt="Current" class="rounded" width="60" height="60">
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Perubahan akan tercermin di sini setelah disimpan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<!-- container-fluid -->
</div>

<script type="text/javascript">
/**
 * JavaScript untuk Halaman Edit Kategori
 */

$(document).ready(function(){
    // Inisialisasi slug preview
    updateSlugPreview($('#nama_kategori').val());

    // Preview gambar baru saat file dipilih
    $('#gambar_kategori').change(function(e){
        tampilkanPratinjauGambarBaru(this);
        updateStatusUpload('success', 'Gambar baru berhasil dipilih');
    });

    // Handler pengiriman form
    $('#formEditKategori').on('submit', function(e) {
        if (!validasiFormEdit()) {
            e.preventDefault();
            return;
        }

        // Tampilkan loading state
        const tombol = $('#tombolSubmit');
        tombol.prop('disabled', true);
        $('#spinnerSubmit').show();
        $('#teksSubmit').text('Memperbarui...');
        updateStatusUpload('loading', 'Memperbarui kategori...');
    });

    // Validasi real-time pada input
    $('#nama_kategori').on('blur', function() {
        validasiFieldNama($(this));
    });

    // Deteksi perubahan form
    $('#formEditKategori').on('input', function() {
        updateStatusUpload('warning', 'Ada perubahan yang belum disimpan');
    });
});

/**
 * Menampilkan pratinjau gambar baru
 */
function tampilkanPratinjauGambarBaru(input) {
    if (input.files && input.files[0]) {
        // Validasi ukuran file (maksimal 2MB)
        if (input.files[0].size > 2 * 1024 * 1024) {
            alert('Ukuran gambar terlalu besar! Maksimal 2MB.');
            input.value = '';
            return;
        }

        // Validasi tipe file
        const tipeFile = input.files[0].type;
        if (!tipeFile.match('image.*')) {
            alert('Hanya file gambar yang diizinkan!');
            input.value = '';
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            $('#pratinjauGambarBaru').attr('src', e.target.result).show();
            $('#teksPratinjau').text('Pratinjau gambar baru');
            $('#namaFile').text(input.files[0].name).show();
            $('#kontenUpload').html(`<i class="bx bx-check-circle ikon-upload text-success"></i>
                                   <p class="text-success mb-1 fw-semibold">File dipilih</p>`);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Generate dan update preview slug
 */
function updateSlugPreview(namaKategori) {
    if (namaKategori) {
        const slug = namaKategori.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '')
            .replace(/--+/g, '-')
            .replace(/^-+|-+$/g, '');
        $('#preview_slug').val(slug);
    } else {
        $('#preview_slug').val('');
    }
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
        $('#gambar_kategori').prop('files', files);
        tampilkanPratinjauGambarBaru($('#gambar_kategori')[0]);
    }
}

/**
 * Validasi form sebelum submit
 */
function validasiFormEdit() {
    let valid = true;

    // Validasi nama kategori
    if (!validasiFieldNama($('#nama_kategori'))) {
        valid = false;
    }

    return valid;
}

/**
 * Validasi field nama
 */
function validasiFieldNama(field) {
    const nilai = field.val().trim();
    if (nilai.length < 2) {
        field.addClass('is-invalid');
        field.next('.invalid-feedback').remove();
        field.after('<div class="invalid-feedback">Nama kategori harus minimal 2 karakter</div>');
        return false;
    } else if (nilai.length > 50) {
        field.addClass('is-invalid');
        field.next('.invalid-feedback').remove();
        field.after('<div class="invalid-feedback">Nama kategori maksimal 50 karakter</div>');
        return false;
    } else {
        field.removeClass('is-invalid');
        field.next('.invalid-feedback').remove();
        return true;
    }
}

/**
 * Update status upload
 */
function updateStatusUpload(status, pesan) {
    const statusElement = $('#statusUpload');
    let iconClass = '';
    let textClass = '';

    switch(status) {
        case 'loading':
            iconClass = 'bx bx-loader-alt text-primary';
            textClass = 'text-primary';
            break;
        case 'success':
            iconClass = 'bx bx-check-circle text-success';
            textClass = 'text-success';
            break;
        case 'error':
            iconClass = 'bx bx-error-circle text-danger';
            textClass = 'text-danger';
            break;
        case 'warning':
            iconClass = 'bx bx-time text-warning';
            textClass = 'text-warning';
            break;
        case 'waiting':
            iconClass = 'bx bx-edit text-primary';
            textClass = 'text-primary';
            break;
    }

    statusElement.html(`<i class="${iconClass} display-4 d-block mb-2"></i>
                       <p class="${textClass} mb-0 fw-semibold">${pesan}</p>`);
}

/**
 * Reset form ke keadaan semula
 */
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua perubahan?')) {
        $('#nama_kategori').val('{{ $category->category_name }}');
        $('#gambar_kategori').val('');
        $('#pratinjauGambarBaru').hide();
        $('#teksPratinjau').text('Pratinjau gambar baru akan muncul di sini');
        $('#namaFile').hide();
        $('#preview_slug').val('{{ $category->category_slug ?? '' }}');
        $('#kontenUpload').html(`<i class="bx bx-cloud-upload ikon-upload"></i>
                               <p class="text-muted mb-1 fw-semibold">Klik atau seret gambar ke sini</p>
                               <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>`);
        $('#areaUpload').removeClass('is-invalid drag-over');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        const tombol = $('#tombolSubmit');
        tombol.prop('disabled', false);
        $('#spinnerSubmit').hide();
        $('#teksSubmit').text('Perbarui Kategori');
        updateStatusUpload('waiting', 'Perubahan telah direset');
    }
}

/**
 * Validasi jQuery (tetap dipertahankan untuk kompatibilitas)
 */
$(document).ready(function (){
    $('#formEditKategori').validate({
        rules: {
            category_name: {
                required: true,
                minlength: 2,
                maxlength: 50
            }
        },
        messages: {
            category_name: {
                required: 'Harap masukkan nama kategori',
                minlength: 'Nama kategori minimal 2 karakter',
                maxlength: 'Nama kategori maksimal 50 karakter'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

// Preview gambar untuk kompatibilitas dengan kode lama
$(document).ready(function(){
    $('#gambar_kategori').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    })
});
</script>

@endsection
