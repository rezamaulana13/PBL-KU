@extends('frontend.dashboard.dashboard')

@section('user')
@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
        <div class="row">
            @include('frontend.dashboard.sidebar')

            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">

                    {{-- Alert Feedback --}}
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

                    <h4 class="font-weight-bold mt-0 mb-4">Detail Pesanan</h4>

                    <div class="row row-cols-1 row-cols-md-2">
                        {{-- Detail Pembeli --}}
                        <div class="col mb-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Detail Pembeli</h5>
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
                                                <td>{{ $order->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Pesanan:</th>
                                                <td>{{ $order->order_date }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Pesanan --}}
                        <div class="col mb-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Detail Pesanan <span class="text-warning ms-2">#{{ $order->invoice_no }}</span></h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Tipe Pembayaran:</th>
                                                <td>{{ $order->payment_method }}</td>
                                            </tr>
                                            <tr>
                                                <th>ID Transaksi:</th>
                                                <td>{{ $order->transaction_id ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td><strong>Rp {{ number_format($order->total_amount ?? $order->amount, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
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
                                        </tbody>
                                    </table>

                                    {{-- Tombol Batalkan Pesanan --}}
                                    @if (in_array(strtolower($order->status), ['pending', 'confirm', 'processing']))
                                        <form action="{{ route('user.order.cancel', $order->id) }}" method="POST" class="mt-3"
                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100">
                                                Batalkan Pesanan
                                            </button>
                                        </form>
                                    @elseif(strtolower($order->status) == 'cancelled')
                                        <button class="btn btn-secondary mt-3 w-100" disabled>Pesanan Telah Dibatalkan</button>
                                    @elseif(strtolower($order->status) == 'delivered')
                                        <button class="btn btn-success mt-3 w-100" disabled>Pesanan Telah Diterima</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Produk dalam Pesanan</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Toko</th>
                                        <th>Kode</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItem as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->product->image) }}" width="60" height="60" class="rounded" alt="produk">
                                            </td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->client_id ? $item->product->client->name : 'Owner' }}</td>
                                            <td>{{ $item->product->code }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>
                                                Rp {{ number_format($item->price, 0, ',', '.') }} <br>
                                                <small>Total = Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end">
                                <h5 class="fw-bold mt-3">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
