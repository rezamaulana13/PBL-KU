@extends('frontend.dashboard.dashboard')
{{-- PERBAIKAN: Ganti 'dashboard' menjadi 'user' (atau sesuaikan dengan master layout Anda) --}}
@section('user')

@php
    // PERBAIKAN: Lebih efisien, langsung ambil data dari Auth::user()
    $profileData = Auth::user();
@endphp

{{-- PERBAIKAN: Hapus <section><div class="container"><div class="row"> --}}
{{-- Karena row dan container seharusnya sudah ada di master atau di-include dari luar --}}


{{-- Sertakan Sidebar di kolom 3 --}}
@include('frontend.dashboard.sidebar')


<div class="col-md-9">
    <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
    {{-- PERBAIKAN: Hapus tab-content/tab-pane, karena ini adalah halaman tunggal --}}

        <h4 class="font-weight-bold mt-0 mb-4 border-bottom pb-2">Edit Profil Pengguna </h4>


    <div class="bg-white card mb-4 order-list shadow-sm">
        <div class="gold-members p-4">

            <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
            @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input class="form-control" type="text" name="name" value="{{ $profileData->name }}" id="nameInput">
                        </div>

                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input class="form-control" name="email" type="email" value="{{ $profileData->email }}" id="emailInput">
                        </div>

                        <div class="mb-3">
                            <label for="phoneInput" class="form-label">Phone</label>
                            <input class="form-control" name="phone" type="text" value="{{ $profileData->phone }}" id="phoneInput">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="addressInput" class="form-label">Address</label>
                            <input class="form-control" name="address" type="text" value="{{ $profileData->address }}" id="addressInput">
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input class="form-control" name="photo" type="file" id="image">
                        </div>

                        <div class="mb-3">
                            {{-- PERBAIKAN: Gunakan url('upload/profile.jpg') sebagai fallback yang lebih baik --}}
                            <img id="showImage"
                                src="{{ (!empty($profileData->photo))
                                    ? url('upload/user_images/'.$profileData->photo)
                                    : url('upload/profile.jpg') }}"
                                alt="Profile Image"
                                class="rounded-circle p-1 bg-primary"
                                width="110"
                                style="object-fit: cover; height: 110px;">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    </div>
</div>
{{-- Penutup Row Utama di Master Layout --}}

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })

</script>

@endsection
