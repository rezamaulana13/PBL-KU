@extends('frontend.dashboard.dashboard')

{{-- Pastikan ini sama dengan @yield di Master Layout Anda --}}
@section('user')

@php
    // Cukup gunakan Auth::user() untuk efisiensi
    $profileData = Auth::user();
@endphp

{{-- HILANGKAN: <section class="section pt-4 pb-4 osahan-account-page"> --}}
{{-- HILANGKAN: <div class="container"> --}}
{{-- HILANGKAN: <div class="row"> (Jika sudah ada di Master Layout) --}}

@include('frontend.dashboard.sidebar')

<div class="col-md-9">
    <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">

        <h4 class="font-weight-bold mt-0 mb-4 border-bottom pb-2">Ubah Kata Sandi</h4>

        <div class="bg-white card order-list shadow-sm">
            <div class="gold-members p-4">

                <form action="{{ route('user.password.update') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <input class="form-control @error('old_password') is-invalid @enderror"
                                       type="password" name="old_password" id="old_password">
                                @error('old_password')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input class="form-control @error('new_password') is-invalid @enderror"
                                       type="password" name="new_password" id="new_password">
                                @error('new_password')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input class="form-control"
                                       type="password" name="new_password_confirmation" id="new_password_confirmation">
                            </div>

                            {{-- PERBAIKAN TOMBOL DI SINI --}}
                            <div class="mt-4 pt-2">
    <button type="submit" class="btn btn-primary btn-lg shadow-lg fw-bold">
        <i class="fas fa-save me-2"></i> Simpan
    </button>
</div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Skrip JavaScript --}}
<script type="text/javascript">
    // Hapus skrip image jika tidak relevan untuk ganti password.
</script>

@endsection
