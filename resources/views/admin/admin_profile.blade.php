@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
/* Animasi untuk transisi yang lebih halus */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Efek hover yang lebih menarik */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

/* Loading indicator */
.loading-spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Gradient background untuk header */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

/* Custom alert position */
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
}

/* Upload area styling */
.upload-area {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px dashed #dee2e6 !important;
}

.upload-area:hover {
    border-color: #667eea !important;
    background-color: #f8f9ff !important;
}

/* Improved tab styling */
.nav-pills .nav-link {
    transition: all 0.3s ease;
    border-radius: 12px !important;
    margin: 0 5px;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

/* Status indicator */
.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.status-online {
    background-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.3);
}

/* Password strength indicator */
.password-strength {
    height: 5px;
    border-radius: 5px;
    margin-top: 5px;
    transition: all 0.3s ease;
}

.strength-weak { background-color: #dc3545; width: 25%; }
.strength-fair { background-color: #fd7e14; width: 50%; }
.strength-good { background-color: #ffc107; width: 75%; }
.strength-strong { background-color: #28a745; width: 100%; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18 text-primary">
                        <i class="bx bx-user-circle me-2"></i>Pengaturan Akun Admin Premium ✨
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10 col-lg-12 mx-auto">

                <!-- Header Profil dengan Gradient -->
                <div class="card shadow-lg border-0 bg-gradient-primary text-white overflow-hidden card-hover fade-in">
                    <div class="card-body p-4 position-relative">
                        <!-- Background pattern -->
                        <div class="position-absolute top-0 end-0 opacity-10">
                            <i class="bx bx-user-circle display-1"></i>
                        </div>

                        <div class="d-flex align-items-center flex-wrap position-relative">
                            <div class="flex-shrink-0 me-4 mb-3 mb-sm-0">
                                <div class="avatar-xl position-relative">
                                    <img id="profileImageHeader"
                                         src="{{ !empty($profileData->photo)
                                            ? url('upload/admin_images/'.$profileData->photo)
                                            : url('upload/profile.jpg') }}"
                                         alt="Foto Profil"
                                         class="img-fluid rounded-circle d-block border border-white border-4 shadow-lg"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                        <i class="bx bx-check text-white"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <h4 class="font-size-24 mb-1 text-white">{{ $profileData->name ?? 'Admin' }}</h4>
                                <p class="text-white-50 font-size-15 mb-2">
                                    <i class="bx bx-envelope me-1"></i>{{ $profileData->email ?? 'admin@raracookies.com' }}
                                </p>

                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <span class="badge bg-white text-primary rounded-pill p-2 shadow-sm">
                                        <i class="bx bx-shield-alt-2 me-1"></i>{{ $profileData->role ?? 'Super Admin' }}
                                    </span>

                                    <span class="text-white-50 d-flex align-items-center">
                                        <span class="status-indicator status-online"></span>
                                        Status: Aktif
                                    </span>

                                    <small class="text-white-50">
                                        <i class="bx bx-time align-middle me-1"></i> Terakhir Diperbarui:
                                        {{ $profileData->updated_at ? $profileData->updated_at->diffForHumans() : 'Belum Pernah Diperbarui' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Card -->
                <div class="card shadow-lg border-0 card-hover fade-in" style="animation-delay: 0.1s;">
                    <div class="card-body p-4">

                        <!-- Improved Tab Navigation -->
                        <ul class="nav nav-pills nav-justified bg-light p-2 rounded-4 mb-4 shadow-sm" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#profile_info" role="tab">
                                    <i class="bx bx-file-text font-size-18 me-2"></i>
                                    <span class="d-none d-sm-block">Detail Akun</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#profile_edit" role="tab">
                                    <i class="bx bx-user-circle font-size-18 me-2"></i>
                                    <span class="d-none d-sm-block">Update Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="#password_change" role="tab">
                                    <i class="bx bx-shield-alt-2 font-size-18 me-2"></i>
                                    <span class="d-none d-sm-block">Ganti Password</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-2 fade-in" style="animation-delay: 0.2s;">

                            <!-- Tab 1: Detail Profil -->
                            <div class="tab-pane active show" id="profile_info" role="tabpanel">
                                <h5 class="font-size-18 text-primary mb-4 border-bottom pb-2">
                                    <i class="bx bx-info-circle me-2"></i>Informasi Kontak & Akun
                                </h5>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <p class="text-muted mb-1">
                                            <i class="bx bx-user me-1"></i>Nama Lengkap:
                                        </p>
                                        <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                                            <h6 class="font-size-16 text-dark mb-0">{{ $profileData->name ?? '-' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p class="text-muted mb-1">
                                            <i class="bx bx-envelope me-1"></i>Email:
                                        </p>
                                        <div class="p-3 bg-light rounded-3 border-start border-4 border-info">
                                            <h6 class="font-size-16 text-dark mb-0">{{ $profileData->email ?? '-' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p class="text-muted mb-1">
                                            <i class="bx bx-phone me-1"></i>Nomor Handphone:
                                        </p>
                                        <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                                            <h6 class="font-size-16 text-dark mb-0">{{ $profileData->phone ?? '-' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <p class="text-muted mb-1">
                                            <i class="bx bx-map me-1"></i>Alamat:
                                        </p>
                                        <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                                            <h6 class="font-size-16 text-dark mb-0">{{ $profileData->address ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistik Tambahan -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-muted mb-3">Statistik Akun</h6>
                                        <div class="row text-center">
                                            <div class="col-md-3 mb-3">
                                                <div class="p-3 bg-primary text-white rounded-3">
                                                    <i class="bx bx-calendar display-6 d-block mb-2"></i>
                                                    <h6 class="mb-0">Bergabung</h6>
                                                    <small>{{ $profileData->created_at ? $profileData->created_at->format('d M Y') : '-' }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="p-3 bg-success text-white rounded-3">
                                                    <i class="bx bx-refresh display-6 d-block mb-2"></i>
                                                    <h6 class="mb-0">Terakhir Update</h6>
                                                    <small>{{ $profileData->updated_at ? $profileData->updated_at->format('d M Y') : '-' }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="p-3 bg-info text-white rounded-3">
                                                    <i class="bx bx-shield-alt display-6 d-block mb-2"></i>
                                                    <h6 class="mb-0">Role</h6>
                                                    <small>{{ $profileData->role ?? 'Super Admin' }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="p-3 bg-warning text-white rounded-3">
                                                    <i class="bx bx-check-shield display-6 d-block mb-2"></i>
                                                    <h6 class="mb-0">Status</h6>
                                                    <small>Aktif</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Edit Profil -->
                            <div class="tab-pane" id="profile_edit" role="tabpanel">
                                <h5 class="font-size-18 text-primary mb-4 border-bottom pb-2">
                                    <i class="bx bx-edit me-2"></i>Perbarui Detail Personal
                                </h5>

                                <form action="{{ route('admin.profile.store') }}" method="post" enctype="multipart/form-data" id="profileForm">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-6 border-end pe-lg-4">
                                            <h6 class="text-info mb-3">
                                                <i class="bx bx-user me-2"></i>Data Diri
                                            </h6>
                                            <div class="mb-3">
                                                <label for="nameInput" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                    name="name" value="{{ old('name', $profileData->name) }}" id="nameInput" required
                                                    oninput="validateField(this, 'name')">
                                                <div class="form-text text-muted" id="nameHelp">Minimal 3 karakter</div>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" type="email"
                                                    value="{{ old('email', $profileData->email) }}" id="emailInput" required
                                                    oninput="validateField(this, 'email')">
                                                <div class="form-text text-muted" id="emailHelp">Format email yang valid</div>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Nomor Handphone</label>
                                                <input class="form-control @error('phone') is-invalid @enderror" name="phone" type="text"
                                                    value="{{ old('phone', $profileData->phone) }}" id="phoneInput"
                                                    oninput="validateField(this, 'phone')">
                                                <div class="form-text text-muted" id="phoneHelp">Format: 08xxxxxxxxxx</div>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 ps-lg-4">
                                            <h6 class="text-info mb-3 mt-4 mt-lg-0">
                                                <i class="bx bx-image me-2"></i>Media & Kontak
                                            </h6>
                                            <div class="mb-3">
                                                <label for="addressInput" class="form-label">Alamat Lengkap</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                                                    id="addressInput" rows="3" oninput="validateField(this, 'address')">{{ old('address', $profileData->address) }}</textarea>
                                                <div class="form-text text-muted" id="addressHelp">Alamat lengkap tempat tinggal</div>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="image" class="form-label">Ganti Foto Profil</label>
                                                <div class="border rounded-3 p-3 text-center bg-light position-relative upload-area"
                                                     style="cursor: pointer;"
                                                     onclick="document.getElementById('image').click()">
                                                    <input class="d-none" name="photo" type="file" id="image" accept="image/*">
                                                    <div id="uploadArea" class="py-4">
                                                        <i class="bx bx-cloud-upload display-4 text-muted mb-2"></i>
                                                        <p class="text-muted mb-1">Klik untuk memilih foto</p>
                                                        <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                                                    </div>
                                                    <div id="fileName" class="text-primary fw-bold mt-2" style="display: none;"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Pratinjau Foto Baru</label>
                                                <br>
                                                <div class="text-center">
                                                    <img id="showImage" src="{{ !empty($profileData->photo) ? url('upload/admin_images/'.$profileData->photo) : url('upload/profile.jpg') }}"
                                                        alt="Pratinjau Foto" class="rounded-circle p-1 border border-3 border-success shadow-sm"
                                                        width="130" height="130" style="object-fit: cover;">
                                                    <p class="text-muted mt-2 mb-0">Pratinjau akan muncul di sini</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light w-md" id="submitProfileBtn">
                                                <div class="loading-spinner" id="submitProfileSpinner"></div>
                                                <i class="bx bx-save me-1"></i>
                                                <span id="submitProfileText">Simpan Perubahan Profil</span>
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary waves-effect ms-2">
                                                <i class="bx bx-reset me-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab 3: Ganti Password -->
                            <div class="tab-pane" id="password_change" role="tabpanel">
                                <h5 class="font-size-18 text-danger mb-4 border-bottom pb-2">
                                    <i class="bx bx-shield-alt-2 me-2"></i>Perhatian: Ganti Kata Sandi
                                </h5>

                                <form action="{{ route('admin.password.update') }}" method="post" id="passwordForm">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="old_password" class="form-label">Password Lama <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input class="form-control @error('old_password') is-invalid @enderror" type="password"
                                                        name="old_password" id="old_password" placeholder="Masukkan password lama Anda" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('old_password')">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                                @error('old_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input class="form-control @error('new_password') is-invalid @enderror" type="password"
                                                        name="new_password" id="new_password" placeholder="Masukkan password baru" required
                                                        oninput="checkPasswordStrength(this.value)">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                                <div class="password-strength mt-2" id="passwordStrength"></div>
                                                <div class="form-text" id="passwordHelp">Password harus minimal 8 karakter</div>
                                                @error('new_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input class="form-control" type="password"
                                                        name="new_password_confirmation" id="new_password_confirmation" placeholder="Ulangi password baru" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </div>
                                                <div class="form-text" id="confirmPasswordHelp">Harus sama dengan password baru</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <div class="alert alert-warning p-4 border border-warning rounded-3 shadow-sm" role="alert">
                                                <h4 class="alert-heading text-warning">
                                                    <i class="bx bx-error-alt me-2"></i> PERINGATAN KEAMANAN!
                                                </h4>
                                                <p class="mb-2"><strong>Setelah mengganti password:</strong></p>
                                                <ul class="mb-3">
                                                    <li>Anda akan <strong>logout secara otomatis</strong></li>
                                                    <li>Semua sesi aktif akan berakhir</li>
                                                    <li>Anda harus login kembali dengan password baru</li>
                                                </ul>
                                                <p class="mb-0">Pastikan password baru Anda <strong>kuat dan mudah diingat</strong>.</p>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light w-md" id="submitPasswordBtn">
                                                <div class="loading-spinner" id="submitPasswordSpinner"></div>
                                                <i class="bx bx-key me-1"></i>
                                                <span id="submitPasswordText">Ubah Password Sekarang</span>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary waves-effect ms-2" onclick="resetPasswordForm()">
                                                <i class="bx bx-reset me-1"></i> Batal
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
/**
 * JavaScript untuk Pratinjau Gambar (Image Preview) dan UX
 */
$(document).ready(function(){
    // Memastikan Pratinjau Gambar berfungsi saat input file diubah
    $('#image').change(function(e){
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result)
                    .removeClass('border-secondary')
                    .addClass('border-success');
                $('#profileImageHeader').attr('src', e.target.result);

                // Update upload area UI
                $('#uploadArea').html(`<i class="bx bx-check-circle display-4 text-success mb-2"></i>
                                     <p class="text-success mb-1">File dipilih</p>`);
                $('#fileName').text(file.name).show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Mengatur Pratinjau Foto di Tab 2 agar sesuai dengan foto profil yang ada, saat tab dibuka
    $('#profile_edit').on('show.bs.tab', function (e) {
        let existingPhotoUrl = $('#profileImageHeader').attr('src');
        $('#showImage').attr('src', existingPhotoUrl);
    });
});

/**
 * Validasi Real-time untuk Form Fields
 */
function validateField(input, fieldName) {
    const value = input.value.trim();
    const helpText = document.getElementById(fieldName + 'Help');

    switch(fieldName) {
        case 'name':
            if (value.length < 3) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                helpText.classList.remove('text-muted', 'text-success');
                helpText.classList.add('text-danger');
                helpText.textContent = 'Nama harus minimal 3 karakter';
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                helpText.classList.remove('text-danger');
                helpText.classList.add('text-success');
                helpText.textContent = 'Nama valid ✓';
            }
            break;

        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                helpText.classList.remove('text-muted', 'text-success');
                helpText.classList.add('text-danger');
                helpText.textContent = 'Format email tidak valid';
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                helpText.classList.remove('text-danger');
                helpText.classList.add('text-success');
                helpText.textContent = 'Email valid ✓';
            }
            break;

        case 'phone':
            const phoneRegex = /^08[0-9]{8,11}$/;
            if (value && !phoneRegex.test(value)) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                helpText.classList.remove('text-muted', 'text-success');
                helpText.classList.add('text-danger');
                helpText.textContent = 'Format nomor handphone tidak valid';
            } else if (value) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                helpText.classList.remove('text-danger');
                helpText.classList.add('text-success');
                helpText.textContent = 'Nomor handphone valid ✓';
            } else {
                input.classList.remove('is-invalid', 'is-valid');
                helpText.classList.remove('text-danger', 'text-success');
                helpText.classList.add('text-muted');
                helpText.textContent = 'Format: 08xxxxxxxxxx';
            }
            break;

        case 'address':
            if (value.length > 0 && value.length < 10) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                helpText.classList.remove('text-muted', 'text-success');
                helpText.classList.add('text-danger');
                helpText.textContent = 'Alamat terlalu pendek';
            } else if (value.length >= 10) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                helpText.classList.remove('text-danger');
                helpText.classList.add('text-success');
                helpText.textContent = 'Alamat valid ✓';
            } else {
                input.classList.remove('is-invalid', 'is-valid');
                helpText.classList.remove('text-danger', 'text-success');
                helpText.classList.add('text-muted');
                helpText.textContent = 'Alamat lengkap tempat tinggal';
            }
            break;
    }
}

/**
 * Toggle Visibility Password
 */
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.parentNode.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bx bx-hide';
    } else {
        field.type = 'password';
        icon.className = 'bx bx-show';
    }
}

/**
 * Check Password Strength
 */
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const helpText = document.getElementById('passwordHelp');

    let strength = 0;
    let feedback = '';

    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/\d/)) strength++;
    if (password.match(/[^a-zA-Z\d]/)) strength++;

    // Update strength bar
    strengthBar.className = 'password-strength';
    if (password.length === 0) {
        strengthBar.style.width = '0%';
        helpText.className = 'form-text text-muted';
        helpText.textContent = 'Password harus minimal 8 karakter';
    } else {
        switch(strength) {
            case 1:
                strengthBar.classList.add('strength-weak');
                helpText.className = 'form-text text-danger';
                helpText.textContent = 'Password lemah';
                break;
            case 2:
                strengthBar.classList.add('strength-fair');
                helpText.className = 'form-text text-warning';
                helpText.textContent = 'Password cukup';
                break;
            case 3:
                strengthBar.classList.add('strength-good');
                helpText.className = 'form-text text-info';
                helpText.textContent = 'Password baik';
                break;
            case 4:
                strengthBar.classList.add('strength-strong');
                helpText.className = 'form-text text-success';
                helpText.textContent = 'Password sangat kuat ✓';
                break;
        }
    }
}

/**
 * Reset Password Form
 */
function resetPasswordForm() {
    document.getElementById('passwordForm').reset();
    document.getElementById('passwordStrength').style.width = '0%';
    document.getElementById('passwordHelp').className = 'form-text text-muted';
    document.getElementById('passwordHelp').textContent = 'Password harus minimal 8 karakter';

    // Reset all password fields to hidden
    ['old_password', 'new_password', 'new_password_confirmation'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        const icon = field.parentNode.querySelector('i');
        field.type = 'password';
        if (icon) icon.className = 'bx bx-show';
    });
}

/**
 * Form Submission Handlers dengan Loading Indicators
 */
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitProfileBtn');
    const spinner = document.getElementById('submitProfileSpinner');
    const text = document.getElementById('submitProfileText');

    submitBtn.disabled = true;
    spinner.style.display = 'inline-block';
    text.textContent = 'Menyimpan...';
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;

    // Validasi password match
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        showAlert('error', 'Password baru dan konfirmasi password tidak cocok!');
        return;
    }

    // Validasi password strength
    if (newPassword.length < 8) {
        e.preventDefault();
        showAlert('warning', 'Password harus minimal 8 karakter!');
        return;
    }

    // Konfirmasi perubahan password
    if (!confirm('⚠️ PERINGATAN: Anda yakin ingin mengubah password? Anda akan logout secara otomatis dan harus login kembali dengan password baru.')) {
        e.preventDefault();
        return;
    }

    const submitBtn = document.getElementById('submitPasswordBtn');
    const spinner = document.getElementById('submitPasswordSpinner');
    const text = document.getElementById('submitPasswordText');

    submitBtn.disabled = true;
    spinner.style.display = 'inline-block';
    text.textContent = 'Mengubah Password...';
});

/**
 * Custom Alert System
 */
function showAlert(type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.custom-alert');
    existingAlerts.forEach(alert => alert.remove());

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} custom-alert alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <strong>${type === 'error' ? 'Error!' : type === 'warning' ? 'Peringatan!' : 'Sukses!'}</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

/**
 * Initialize form validations on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    // Validate existing fields
    ['name', 'email', 'phone', 'address'].forEach(field => {
        const input = document.getElementById(field + 'Input');
        if (input && input.value) {
            validateField(input, field);
        }
    });
});
</script>

@endsection
