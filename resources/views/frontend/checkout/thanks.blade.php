@extends('frontend.dashboard.dashboard')
@section('user')

<section class="order-success-section d-flex align-items-center justify-content-center"
         style="height: 100vh; width: 100%; background-color: #f8f9fa; overflow: hidden;">

    {{-- Gambar background full kanan-kiri --}}
    <img src="{{ asset('frontend/img/order-success.png') }}"
         alt="Order Success"
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; opacity: 0.2;">

    <div class="text-center position-relative" style="z-index: 2;">

        <h1 class="text-success fw-bold mb-3 display-4">Order Sukses! Terima Kasih 😊</h1>

        @if(session('order'))
            <div class="order-summary bg-white shadow rounded p-4 d-inline-block">
                <p><strong>Invoice No:</strong> {{ session('order')->invoice_no }}</p>
                <p><strong>Total Pembayaran:</strong> Rp {{ number_format(session('order')->total_amount, 0, ',', '.') }}</p>
                <p><strong>Status Pesanan:</strong>
                    <span class="badge bg-success">{{ session('order')->status }}</span>
                </p>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-5">Kembali ke Beranda</a>
        </div>
    </div>

</section>

@endsection
