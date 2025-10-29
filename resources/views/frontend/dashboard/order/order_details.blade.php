@extends('frontend.dashboard.dashboard')

@section('user')

{{-- Hapus logika $profileData yang tidak terpakai dari view --}}
@php
    // Hitung subtotal produk dari semua item (untuk display)
    $totalPrice = $orderItem->sum(function ($item) {
        return $item->price * $item->qty;
    });
@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
        <div class="row">
            {{-- SIDEBAR: Asumsi file sidebar sudah benar --}}
            @include('frontend.dashboard.sidebar')

            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">

                    {{-- Alert Feedback (Biarkan seperti aslinya) --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h4 class="font-weight-bold mt-0 mb-4">Detail Pesanan #{{ $order->invoice_no }}</h4>

                    <div class="row row-cols-1 row-cols-md-2">

                        {{-- KOLOM KIRI: Detail Pembeli --}}
                        <div class="col mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Detail Pembeli & Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Nama:</th>
                                                <td>{{ $order->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>No. Telp:</th>
                                                <td>{{ $order->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td>{{ $order->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat:</th>
                                                <td>{{ $order->address }}, {{ $order->district }}, {{ $order->city }}, {{ $order->province }}, {{ $order->post_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Pesanan:</th>
                                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: Status, Pembayaran, dan Aksi --}}
                        <div class="col mb-3">

                            {{-- KARTU 1: RINGKASAN PEMBAYARAN --}}
                            <div class="card border-info mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="w-50">Subtotal Produk:</th>
                                                <td class="text-end">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Diskon Voucher:</th>
                                                <td class="text-end text-danger">- Rp {{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Kirim:</th>
                                                <td class="text-end">Rp {{ number_format($order->shipping_charge ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="table-primary fw-bold">
                                                <th>Total Akhir (Bayar):</th>
                                                <td class="text-end">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- KARTU 2: INFO PESANAN & STATUS --}}
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Info Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered mb-3">
                                        <tbody>
                                            <tr>
                                                <th class="w-50">Status:</th>
                                                <td>
                                                    <span class="badge
                                                        @if($order->status == 'Pending') bg-warning
                                                        @elseif($order->status == 'Cancelled') bg-danger
                                                        @elseif($order->status == 'Delivered') bg-success
                                                        @else bg-info @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tipe Pembayaran:</th>
                                                <td>{{ $order->payment_method }}</td>
                                            </tr>
                                            <tr>
                                                <th>ID Transaksi:</th>
                                                <td>{{ $order->transaction_id ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    {{-- Tombol Aksi (Batalkan/Download) --}}
                                    @if (in_array(strtolower($order->status), ['pending', 'confirm', 'processing']))
                                        <form action="{{ route('user.order.cancel', $order->id) }}" method="POST" class="mt-3"
                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat diulang.')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-times me-1"></i> Batalkan Pesanan
                                            </button>
                                        </form>
                                    @elseif(strtolower($order->status) == 'delivered')
                                        <a href="{{ route('user.invoice.download', $order->id) }}" class="btn btn-success w-100 mt-3">
                                            <i class="fas fa-download me-1"></i> Download Invoice
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Produk dalam Pesanan</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Penjual</th>
                                        <th>Qty</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItem as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->product->image ?? 'upload/no_image.jpg') }}" width="60" height="60" class="rounded" alt="produk">
                                            </td>
                                            <td>
                                                <strong>{{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</strong>
                                                {{-- Tampilkan Varian/Warna/Size jika ada --}}
                                                @if($item->size || $item->color)
                                                    <br><small class="text-muted">
                                                        @if($item->size) Varian: {{ $item->size }} @endif
                                                        @if($item->color) Rasa: {{ $item->color }} @endif
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $item->product->client->name ?? 'Owner' }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-end"><strong>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- Footer untuk konfirmasi Subtotal Produk --}}
                                <tfoot>
                                    <tr class="table-light">
                                        <th colspan="5" class="text-end">Subtotal Semua Produk:</th>
                                        <th class="text-end h5 mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
