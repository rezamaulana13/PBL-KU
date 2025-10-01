@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Detail Pesanan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">

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
                <th width="50%">Nama Pengirim: </th>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <th width="50%">Telepon Pengirim: </th>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <th width="50%">Email Pengirim: </th>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <th width="50%">Alamat Pengiriman: </th>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <th width="50%">Tanggal Pesanan: </th>
                <td>{{ $order->order_date }}</td>
            </tr>

        </tbody>
    </table>
</div>
            </div>
        </div>
    </div> <!-- end col -->


    <div class="col">
        <div class="card">
         <div class="card-header">
            <h4>Detail Pesanan
            <span class="text-danger">Invoice: {{ $order->invoice_no }}</span></h4>
         </div>

            <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered border-primary mb-0">

        <tbody>
            <tr>
                <th width="50%"> Nama: </th>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <th width="50%"> Telepon: </th>
                <td>{{ $order->user->phone }}</td>
            </tr>
            <tr>
                <th width="50%"> Email: </th>
                <td>{{ $order->user->email }}</td>
            </tr>
            <tr>
                <th width="50%">Jenis Pembayaran: </th>
                <td>{{ $order->payment_method }}</td>
            </tr>
            <tr>
                <th width="50%">ID Transaksi: </th>
                <td>{{ $order->transaction_id }}</td>
            </tr>
            <tr>
                <th width="50%">Invoice: </th>
                <td class="text-danger">{{ $order->invoice_no }}</td>
            </tr>
            <tr>
                <th width="50%">Jumlah Pesanan: </th>
                <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th width="50%">Status Pesanan: </th>
                <td><span class="badge bg-success">{{ $order->status }}</span></td>
            </tr>

<tr>
    <th width="50%"> </th>
    <td>
        @if($order->status == 'Pending')
        <a href="{{ route('pending_to_confirm',$order->id) }}" class="btn btn-block btn-success" id="confirmOrder">Konfirmasi Pesanan</a>
        @elseif ($order->status == 'confirm')
        <a href="{{ route('confirm_to_processing',$order->id) }}" class="btn btn-block btn-success" id="processingOrder">Pesanan Diproses</a>
        @elseif ($order->status == 'processing')
        <a href="{{ route('processing_to_deliverd',$order->id) }}" class="btn btn-block btn-success" id="deliverdOrder">Pesanan Dikirim</a>
        @endif
    </td>
</tr>

        </tbody>
    </table>
</div>
            </div>
        </div>
    </div> <!-- end col -->


</div> <!-- end row -->



<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1">
    <div class="col">
        <div class="card">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="col-md-1">
                            <label>Gambar</label>
                        </td>
                        <td class="col-md-1">
                            <label>Nama Produk</label>
                        </td>
                        <td class="col-md-1">
                            <label>Nama Restoran</label>
                        </td>
                        <td class="col-md-1">
                            <label>Kode Produk</label>
                        </td>
                        <td class="col-md-1">
                            <label>Jumlah</label>
                        </td>
                        <td class="col-md-1">
                            <label>Harga</label>
                        </td>
                    </tr>
    @foreach ($orderItem as $item)
    <tr>
        <td class="col-md-1">
            <label>
                <img src="{{ asset($item->product->image) }}" style="width:50px; height:50px">
            </label>
        </td>
        <td class="col-md-2">
            <label>
                {{ $item->product->name }}
            </label>
        </td>
        @if ($item->client_id == NULL)
        <td class="col-md-2">
            <label>
               Pemilik
            </label>
        </td>
        @else
        <td class="col-md-2">
            <label>
                {{ $item->product->client->name }}
            </label>
        </td>
        @endif
        <td class="col-md-2">
            <label>
                {{ $item->product->code }}
            </label>
        </td>
        <td class="col-md-2">
            <label>
                {{ $item->qty }}
            </label>
        </td>
        <td class="col-md-2">
            <label>
                 Rp {{ number_format($item->price, 0, ',', '.') }} <br> Total = Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
            </label>
        </td>
    </tr>
    @endforeach
                </tbody>
            </table>
    <div>
        <h4>Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
    </div>

        </div>

        </div>
    </div>
</div>

    </div> <!-- container-fluid -->
</div>

@endsection
