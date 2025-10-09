@extends('frontend.dashboard.dashboard')

{{-- Menggunakan section 'user' (Asumsi ini nama yang benar di Master Layout) --}}
@section('user')

@php
    $profileData = Auth::user();
    use Illuminate\Support\Str;
@endphp

{{-- HAPUS: <div class="row"> --}}

    {{-- SIDEBAR: col-md-3 --}}
    @include('frontend.dashboard.sidebar')

    {{-- KONTEN UTAMA: col-md-9 --}}
    <div class="col-md-9">
        <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">

            {{-- Breadcrumb/Judul --}}
            <h4 class="font-weight-bold mt-0 mb-4 border-bottom pb-2">Pengaturan Akun</h4>

            <div> {{-- Menggantikan space-y-6 Tailwind dengan div biasa --}}

                {{-- 1. UPDATE PROFILE INFORMATION FORM --}}
                <div class="bg-white card mb-4 order-list shadow-sm">
                    <div class="gold-members p-4">
                        <h5 class="mb-3 font-weight-bold text-dark">Informasi Profil</h5>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- 2. UPDATE PASSWORD FORM --}}
                <div class="bg-white card mb-4 order-list shadow-sm">
                    <div class="gold-members p-4">
                        <h5 class="mb-3 font-weight-bold text-dark">Ubah Kata Sandi</h5>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- 3. DELETE USER FORM --}}
                <div class="bg-white card mb-4 order-list shadow-sm">
                    <div class="gold-members p-4">
                        <h5 class="mb-3 font-weight-bold text-danger">Hapus Akun</h5>
                        <p class="text-muted">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

{{-- HAPUS: </div> {{-- Tutup Row Utama --}}

@endsection
