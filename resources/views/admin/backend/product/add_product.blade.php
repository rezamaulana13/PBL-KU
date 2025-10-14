@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Gaya Kustom untuk Halaman Tambah Produk */
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
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
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

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.required-field::after {
    content: " *";
    color: #dc3545;
}

.ikon-input {
    color: #6c757d;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.25);
}

.checkbox-group {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #e9ecef;
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

.badge-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.harga-container {
    position: relative;
}

.harga-container .form-control {
    padding-left: 40px;
}

.harga-container::before {
    content: "Rp";
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-weight: 500;
    z-index: 10;
}

.stats-card {
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
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
                            <i class="bx bx-package me-2"></i>Tambah Produk Baru
                        </h4>
                        <span class="badge bg-primary ms-2">Formulir</span>
                    </div>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.all.product') }}">Semua Produk</a></li>
                            <li class="breadcrumb-item active">Tambah Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir judul halaman -->

        <!-- Kartu Statistik Cepat -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Kategori</h5>
                                <h4 class="mb-0">{{ $category->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bx bx-category text-primary display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Menu</h5>
                                <h4 class="mb-0">{{ $menu->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bx bx-food-menu text-success display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Kota</h5>
                                <h4 class="mb-0">{{ $city->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bx bx-buildings text-warning display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Client</h5>
                                <h4 class="mb-0">{{ $client->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bx bx-user-circle text-info display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-xl-12 col-lg-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="bx bx-edit me-2"></i>Formulir Tambah Produk
                        </h5>
                        <p class="text-muted mb-0 mt-1">Isi informasi produk di bawah ini</p>
                    </div>

                    <div class="card-body p-4">
                        <form id="formTambahProduk" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- Baris 1: Kategori, Menu, Kota, Client -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-category me-2"></i>Klasifikasi Produk
                                    </h6>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label required-field">
                                            <i class="bx bx-category ikon-input me-1"></i>Nama Kategori
                                        </label>
                                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($category as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label required-field">
                                            <i class="bx bx-food-menu ikon-input me-1"></i>Nama Menu
                                        </label>
                                        <select name="menu_id" class="form-select @error('menu_id') is-invalid @enderror">
                                            <option value="">Pilih Menu</option>
                                            @foreach ($menu as $men)
                                            <option value="{{ $men->id }}" {{ old('menu_id') == $men->id ? 'selected' : '' }}>
                                                {{ $men->menu_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('menu_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-buildings ikon-input me-1"></i>Nama Kota
                                        </label>
                                        <select name="city_id" class="form-select @error('city_id') is-invalid @enderror">
                                            <option value="">Pilih Kota</option>
                                            @foreach ($city as $cit)
                                            <option value="{{ $cit->id }}" {{ old('city_id') == $cit->id ? 'selected' : '' }}>
                                                {{ $cit->city_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-user-circle ikon-input me-1"></i>Nama Client
                                        </label>
                                        <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
                                            <option value="">Pilih Client</option>
                                            @foreach ($client as $clie)
                                            <option value="{{ $clie->id }}" {{ old('client_id') == $clie->id ? 'selected' : '' }}>
                                                {{ $clie->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 2: Informasi Dasar Produk -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-info-circle me-2"></i>Informasi Dasar Produk
                                    </h6>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label required-field">
                                            <i class="bx bx-package ikon-input me-1"></i>Nama Produk
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name" placeholder="Masukkan nama produk"
                                               value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-dollar-circle ikon-input me-1"></i>Harga Normal (Rp)
                                        </label>
                                        <div class="harga-container">
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                   name="price" placeholder="0"
                                                   value="{{ old('price') }}" min="0">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-discount ikon-input me-1"></i>Harga Diskon (Rp)
                                        </label>
                                        <div class="harga-container">
                                            <input type="number" class="form-control @error('discount_price') is-invalid @enderror"
                                                   name="discount_price" placeholder="0"
                                                   value="{{ old('discount_price') }}" min="0">
                                        </div>
                                        @error('discount_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Kosongkan jika tidak ada diskon</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 3: Detail Tambahan -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-detail me-2"></i>Detail Tambahan
                                    </h6>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-ruler ikon-input me-1"></i>Ukuran
                                        </label>
                                        <input type="text" class="form-control @error('size') is-invalid @enderror"
                                               name="size" placeholder="Contoh: 250gr, 500ml, M, L, XL"
                                               value="{{ old('size') }}">
                                        @error('size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-package ikon-input me-1"></i>Jumlah Stok
                                        </label>
                                        <input type="number" class="form-control @error('qty') is-invalid @enderror"
                                               name="qty" placeholder="0"
                                               value="{{ old('qty', 0) }}" min="0">
                                        @error('qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 4: Gambar Produk -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-image me-2"></i>Gambar Produk
                                    </h6>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label required-field">
                                            <i class="bx bx-upload ikon-input me-1"></i>Upload Gambar Produk
                                        </label>
                                        <div class="area-upload" onclick="document.getElementById('image').click()"
                                             ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
                                            <input type="file" class="d-none" name="image" id="image" accept="image/*">
                                            <div id="kontenUpload">
                                                <i class="bx bx-cloud-upload display-4 text-muted mb-2"></i>
                                                <p class="text-muted mb-1">Klik atau seret gambar ke sini</p>
                                                <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                                            </div>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bx bx-show ikon-input me-1"></i>Pratinjau Gambar
                                        </label>
                                        <div class="text-center">
                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}"
                                                 alt="Pratinjau Gambar" class="preview-gambar">
                                            <p class="text-muted mt-2 mb-0">Pratinjau akan muncul di sini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 5: Opsi Khusus -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bx bx-star me-2"></i>Opsi Khusus
                                    </h6>
                                </div>

                                <div class="col-12">
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="best_seller" value="1" id="best_seller"
                                                           {{ old('best_seller') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="best_seller">
                                                        <i class="bx bx-trophy me-1"></i>Best Seller
                                                    </label>
                                                    <div class="form-text">Tandai produk sebagai best seller</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="most_populer" value="1" id="most_populer"
                                                           {{ old('most_populer') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="most_populer">
                                                        <i class="bx bx-trending-up me-1"></i>Paling Populer
                                                    </label>
                                                    <div class="form-text">Tandai produk sebagai paling populer</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.all.product') }}" class="btn btn-light waves-effect">
                                            <i class="bx bx-arrow-back me-1"></i>Kembali
                                        </a>
                                        <button type="reset" class="btn btn-outline-secondary waves-effect">
                                            <i class="bx bx-reset me-1"></i>Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="tombolSubmit">
                                            <div class="loading-spinner" id="spinnerSubmit"></div>
                                            <i class="bx bx-save me-1"></i>
                                            <span id="teksSubmit">Simpan Produk</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
/**
 * JavaScript untuk Halaman Tambah Produk
 */

$(document).ready(function(){
    // Preview gambar saat file dipilih
    $('#image').change(function(e){
        tampilkanPratinjauGambar(this);
    });

    // Handler pengiriman form
    $('#formTambahProduk').on('submit', function(e) {
        if (!validasiForm()) {
            e.preventDefault();
            return;
        }

        // Tampilkan loading state
        const tombol = $('#tombolSubmit');
        tombol.prop('disabled', true);
        $('#spinnerSubmit').show();
        $('#teksSubmit').text('Menyimpan...');
    });

    // Validasi harga diskon
    $('input[name="discount_price"]').on('blur', function() {
        validasiHargaDiskon();
    });

    // Auto-format harga
    $('input[type="number"]').on('input', function() {
        formatAngka($(this));
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
            $('#showImage').attr('src', e.target.result);
            $('#kontenUpload').html(`<i class="bx bx-check-circle display-4 text-success mb-2"></i>
                                   <p class="text-success mb-1">File dipilih</p>`);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Fungsi drag and drop
 */
function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    e.currentTarget.classList.add('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    e.currentTarget.classList.remove('drag-over');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        $('#image').prop('files', files);
        tampilkanPratinjauGambar($('#image')[0]);
    }
}

/**
 * Validasi form sebelum submit
 */
function validasiForm() {
    let valid = true;

    // Validasi field required
    const requiredFields = [
        { field: 'select[name="category_id"]', message: 'Pilih kategori' },
        { field: 'select[name="menu_id"]', message: 'Pilih menu' },
        { field: 'input[name="name"]', message: 'Masukkan nama produk' },
        { field: '#image', message: 'Pilih gambar produk' }
    ];

    requiredFields.forEach(item => {
        const field = $(item.field);
        if (!field.val().trim()) {
            field.addClass('is-invalid');
            if (!field.next('.invalid-feedback').length) {
                field.after(`<div class="invalid-feedback">${item.message}</div>`);
            }
            valid = false;
        } else {
            field.removeClass('is-invalid');
            field.next('.invalid-feedback').remove();
        }
    });

    // Validasi harga diskon
    if (!validasiHargaDiskon()) {
        valid = false;
    }

    return valid;
}

/**
 * Validasi harga diskon
 */
function validasiHargaDiskon() {
    const hargaNormal = parseFloat($('input[name="price"]').val()) || 0;
    const hargaDiskon = parseFloat($('input[name="discount_price"]').val()) || 0;
    const fieldDiskon = $('input[name="discount_price"]');

    if (hargaDiskon > 0 && hargaDiskon >= hargaNormal) {
        fieldDiskon.addClass('is-invalid');
        if (!fieldDiskon.next('.invalid-feedback').length) {
            fieldDiskon.after('<div class="invalid-feedback">Harga diskon harus lebih kecil dari harga normal</div>');
        }
        return false;
    } else {
        fieldDiskon.removeClass('is-invalid');
        fieldDiskon.next('.invalid-feedback').remove();
        return true;
    }
}

/**
 * Format angka dengan pemisah ribuan
 */
function formatAngka(input) {
    let value = input.val().replace(/\D/g, '');
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        input.val(value);
    }
}

/**
 * Validasi jQuery (untuk kompatibilitas)
 */
$(document).ready(function (){
    $('#formTambahProduk').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            image: {
                required: true
            },
            menu_id: {
                required: true
            },
            category_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Harap masukkan nama produk',
                minlength: 'Nama produk minimal 2 karakter'
            },
            image: {
                required: 'Harap pilih gambar produk'
            },
            menu_id: {
                required: 'Harap pilih menu'
            },
            category_id: {
                required: 'Harap pilih kategori'
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

// Preview gambar untuk kompatibilitas
$(document).ready(function(){
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    })
});
</script>

@endsection
