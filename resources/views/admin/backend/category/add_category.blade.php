@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Halaman Tambah Kategori */
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
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- mulai judul halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-category me-2"></i>Tambah Kategori Baru
                        </h4>
                        <span class="badge bg-primary ms-2">Formulir</span>
                    </div>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('all.category') }}">Semua Kategori</a></li>
                            <li class="breadcrumb-item active">Tambah Kategori</li>
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
                            <i class="bx bx-edit me-2"></i>Formulir Tambah Kategori
                        </h5>
                        <p class="text-muted mb-0 mt-1">Isi informasi kategori di bawah ini</p>
                    </div>

                    <div class="card-body p-4">
                        <form id="formTambahKategori" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

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
                                               value="{{ old('category_name') }}"
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
                                        <input type="text" class="form-control bg-light" id="preview_slug" readonly>
                                        <div class="form-text">Slug akan digenerate otomatis dari nama kategori</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Field Upload Gambar -->
                                    <div class="mb-4">
                                        <label class="form-label required-field">
                                            <i class="bx bx-image me-1"></i>Gambar Kategori
                                        </label>
                                        <div class="area-upload" onclick="document.getElementById('gambar_kategori').click()"
                                             id="areaUpload" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                                            <input type="file" class="d-none" name="image" id="gambar_kategori" accept="image/*">
                                            <div id="kontenUpload">
                                                <i class="bx bx-cloud-upload ikon-upload"></i>
                                                <p class="text-muted mb-1 fw-semibold">Klik atau seret gambar ke sini</p>
                                                <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                                            </div>
                                            <div id="namaFile" class="text-primary fw-bold mt-2" style="display: none;"></div>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <!-- Preview Gambar -->
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="bx bx-show me-1"></i>Pratinjau Gambar
                                        </label>
                                        <div class="text-center">
                                            <img id="pratinjauGambar" src="{{ url('upload/profile.jpg') }}"
                                                 alt="Pratinjau Gambar Kategori" class="preview-gambar">
                                            <p class="text-muted mt-2 mb-0">Pratinjau akan muncul di sini</p>
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
                                        <button type="reset" class="btn btn-outline-secondary waves-effect">
                                            <i class="bx bx-reset me-1"></i>Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolSubmit">
                                            <div class="loading-spinner" id="spinnerSubmit"></div>
                                            <i class="bx bx-save me-1"></i>
                                            <span id="teksSubmit">Simpan Kategori</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <!-- Panel Panduan -->
                <div class="card card-hover shadow-sm kartu-panduan">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-info-circle me-2"></i>Panduan Pengisian
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-panduan mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bx bx-bulb ikon-panduan"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="alert-heading mb-2">Tips Terbaik!</h6>
                                    <p class="mb-0">Pastikan informasi yang dimasukkan akurat dan gambar berkualitas tinggi.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-check-shield me-1"></i>Persyaratan
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Nama kategori harus unik</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Gambar format JPG, PNG, atau WEBP</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Ukuran gambar maksimal 2MB</small>
                                </li>
                                <li>
                                    <i class="bx bx-check text-success me-2"></i>
                                    <small>Rasio gambar disarankan 1:1</small>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-stats me-1"></i>Statistik Kategori
                            </h6>
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-primary bg-opacity-10 rounded-3">
                                        <h5 class="text-primary mb-0">0</h5>
                                        <small class="text-muted">Total</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-success bg-opacity-10 rounded-3">
                                        <h5 class="text-success mb-0">0</h5>
                                        <small class="text-muted">Aktif</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Status Upload -->
                <div class="card card-hover shadow-sm mt-4 kartu-panduan">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-cloud-upload me-2"></i>Status Upload
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="statusUpload" class="text-center">
                            <i class="bx bx-time text-warning display-4 d-block mb-2"></i>
                            <p class="text-muted mb-0">Menunggu input data</p>
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
 * JavaScript untuk Halaman Tambah Kategori
 */

$(document).ready(function(){
    // Preview gambar saat file dipilih
    $('#gambar_kategori').change(function(e){
        tampilkanPratinjauGambar(this);
        updateStatusUpload('success', 'Gambar berhasil dipilih');
    });

    // Handler pengiriman form
    $('#formTambahKategori').on('submit', function(e) {
        if (!validasiForm()) {
            e.preventDefault();
            return;
        }

        // Tampilkan loading state
        const tombol = $('#tombolSubmit');
        tombol.prop('disabled', true);
        $('#spinnerSubmit').show();
        $('#teksSubmit').text('Menyimpan...');
        updateStatusUpload('loading', 'Menyimpan kategori...');
    });

    // Validasi real-time pada input
    $('#nama_kategori').on('blur', function() {
        validasiFieldNama($(this));
    });

    // Reset form handler
    $('button[type="reset"]').on('click', function() {
        setTimeout(function() {
            resetForm();
            updateStatusUpload('waiting', 'Menunggu input data');
        }, 100);
    });
});

/**
 * Menampilkan pratinjau gambar
 */
function tampilkanPratinjauGambar(input) {
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
            $('#pratinjauGambar').attr('src', e.target.result);
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
        tampilkanPratinjauGambar($('#gambar_kategori')[0]);
    }
}

/**
 * Validasi form sebelum submit
 */
function validasiForm() {
    let valid = true;

    // Validasi nama kategori
    if (!validasiFieldNama($('#nama_kategori'))) {
        valid = false;
    }

    // Validasi gambar
    if (!$('#gambar_kategori')[0].files.length) {
        $('#areaUpload').addClass('is-invalid');
        valid = false;
    } else {
        $('#areaUpload').removeClass('is-invalid');
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
        case 'waiting':
            iconClass = 'bx bx-time text-warning';
            textClass = 'text-warning';
            break;
    }

    statusElement.html(`<i class="${iconClass} display-4 d-block mb-2"></i>
                       <p class="${textClass} mb-0 fw-semibold">${pesan}</p>`);
}

/**
 * Reset form ke keadaan semula
 */
function resetForm() {
    $('#pratinjauGambar').attr('src', '{{ url('upload/profile.jpg') }}');
    $('#namaFile').hide();
    $('#preview_slug').val('');
    $('#kontenUpload').html(`<i class="bx bx-cloud-upload ikon-upload"></i>
                           <p class="text-muted mb-1 fw-semibold">Klik atau seret gambar ke sini</p>
                           <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>`);
    $('#areaUpload').removeClass('is-invalid drag-over');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    const tombol = $('#tombolSubmit');
    tombol.prop('disabled', false);
    $('#spinnerSubmit').hide();
    $('#teksSubmit').text('Simpan Kategori');
}

/**
 * Validasi jQuery (tetap dipertahankan untuk kompatibilitas)
 */
$(document).ready(function (){
    $('#formTambahKategori').validate({
        rules: {
            category_name: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            image: {
                required: true
            }
        },
        messages: {
            category_name: {
                required: 'Harap masukkan nama kategori',
                minlength: 'Nama kategori minimal 2 karakter',
                maxlength: 'Nama kategori maksimal 50 karakter'
            },
            image: {
                required: 'Harap pilih gambar kategori'
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
</script>

@endsection
