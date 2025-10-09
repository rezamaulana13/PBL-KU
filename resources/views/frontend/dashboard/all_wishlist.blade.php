@extends('frontend.dashboard.dashboard')

@section('user')

{{-- Skrip JQuery dan Toastr: Gunakan @push('scripts') di Master Layout untuk performa yang lebih baik! --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

{{-- SIDEBAR dan KONTEN di dalam ROW yang sudah ada di Master Layout --}}
@include('frontend.dashboard.sidebar')

<div class="col-md-9">
    <div class="osahan-account-page-right rounded shadow-lg bg-white p-4 h-100">

        <h4 class="font-weight-bold mt-0 mb-4 pb-2 border-bottom text-primary">
            <i class="fas fa-heart me-2"></i> Daftar Favorit Anda
        </h4>

        <div class="row">

            {{-- Mulai Loop Item Wishlist --}}
            @forelse ($wishlist as $wish)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 rounded-3 shadow-sm wishlist-card">

                        {{-- GAMBAR PRODUK/KLIEN --}}
                        <div class="list-card-image position-relative overflow-hidden" style="height: 180px;">
                            {{-- Tombol Hapus: Posisikan di sudut kanan atas --}}
                            <a href="{{ route('remove.wishlist',$wish->id) }}"
                               class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-lg"
                               data-toggle="tooltip" data-placement="top" title="Hapus dari Favorit">
                                <i class="fas fa-trash-alt"></i>
                            </a>

                            <a href="{{ route('res.details',$wish->client_id) }}">
                                <img src="{{ asset('upload/client_images/' . $wish['client']['photo']) }}"
                                     class="card-img-top w-100 h-100"
                                     alt="{{ $wish['client']['name'] ?? 'Client Photo' }}"
                                     style="object-fit: cover;">
                            </a>
                        </div>

                        {{-- DETAIL KONTEN --}}
                        <div class="card-body p-3">
                            <h5 class="mb-1 text-truncate">
                                <a href="{{ route('res.details',$wish->client_id) }}" class="text-dark fw-bold hover-primary">
                                    {{$wish['client']['name']}}
                                </a>
                            </h5>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $wish['client']['address'] ?? 'Alamat Tidak Tersedia' }}
                            </p>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Tampilan Jika Wishlist Kosong (Lebih Besar) --}}
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-6x text-muted mb-4"></i>
                    <h5 class="text-dark fw-bold mb-2">Daftar Favorit Anda Kosong!</h5>
                    <p class="text-muted fs-6 mb-4">Sepertinya Anda belum menyukai apa pun. Tambahkan item favorit Anda sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-search me-2"></i> Mulai Jelajahi Produk Terbaik
                    </a>
                </div>
            @endforelse

        </div> {{-- Penutup row untuk item wishlist --}}

    </div>
</div>

{{-- Tambahkan Style CSS Khusus untuk Efek Visual Maksimal --}}
@push('styles')
<style>
    /* Menggunakan transisi untuk efek hover yang halus */
    .wishlist-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    /* Efek hover: sedikit terangkat dan bayangan lebih kuat */
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important; /* Bayangan lebih kuat */
    }
    .hover-primary:hover {
        color: var(--bs-primary) !important; /* Mengubah warna teks saat hover ke primary */
    }
</style>
@endpush

@endsection
