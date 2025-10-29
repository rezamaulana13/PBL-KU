@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        {{-- Judul Halaman --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Detail Pesanan</h4>
                </div>
            </div>
        </div>

        {{-- Detail Pengiriman dan Pesanan --}}
        <div class="row row-cols-1 row-cols-lg-2 mb-3">
            {{-- Detail Pengiriman --}}
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pengiriman</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered border-primary mb-0">
                                <tbody>
                                    <tr>
                                        <th width="50%">Nama Pengirim:</th>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Pengirim:</th>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Pengirim:</th>
                                        <td>{{ $order->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pengiriman:</th>
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
            </div>

            {{-- Detail Pesanan --}}
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pesanan
                            <span class="text-danger">Invoice: {{ $order->invoice_no }}</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered border-primary mb-0">
                                <tbody>
                                    <tr>
                                        <th>Nama:</th>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon:</th>
                                        <td>{{ $order->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Pembayaran:</th>
                                        <td>{{ $order->payment_method }}</td>
                                    </tr>
                                    <tr>
                                        <th>ID Transaksi:</th>
                                        <td>{{ $order->transaction_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice:</th>
                                        <td class="text-danger">{{ $order->invoice_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Pesanan:</th>
                                        <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Pesanan:</th>
                                        <td>
                                            <span class="badge
                                                @if($order->status == 'Pending') bg-warning
                                                @elseif($order->status == 'confirm') bg-info
                                                @elseif($order->status == 'processing') bg-primary
                                                @elseif($order->status == 'delivered') bg-success
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>

                                    {{-- Tombol Ubah Status Pesanan --}}
                                    <tr>
                                        <th>Aksi:</th>
                                        <td>
                                            @if ($order->status == 'Pending')
                                                <a href="{{ route('pending_to_confirm', $order->id) }}" class="btn btn-success w-100" id="confirmOrder">
                                                    Konfirmasi Pesanan
                                                </a>
                                            @elseif ($order->status == 'Confirm')
                                                <a href="{{ route('confirm_to_processing', $order->id) }}" class="btn btn-primary w-100" id="processingOrder">
                                                    Pesanan Diproses
                                                </a>
                                            @elseif ($order->status == 'Processing')
                                                <a href="{{ route('processing_to_delivered', $order->id) }}" class="btn btn-success w-100" id="deliveredOrder">
                                                    Pesanan Dikirim
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Produk dalam Pesanan --}}
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Produk dalam Pesanan</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Nama Toko</th>
                                    <th>Kode Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @foreach ($orderItem as $item)
                                    @php $totalPrice += $item->price * $item->qty; @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ asset($item->product->image) }}" alt="Produk" style="width: 50px; height: 50px;">
                                        </td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->client_id ? $item->product->client->name : 'Pemilik' }}</td>
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
                        <div class="text-end mt-3">
                            <h4 class="fw-bold">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> {{-- container-fluid --}}
</div>
@endsection
