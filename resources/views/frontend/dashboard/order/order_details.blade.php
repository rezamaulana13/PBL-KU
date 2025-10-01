@extends('frontend.dashboard.dashboard')
@section('dashboard')

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
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <h4 class="font-weight-bold mt-0 mb-4">Detail Pesanan</h4>

            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
                <div class="col">
                    <div class="card">
                     <div class="card-header">
                        <h4>Detail Pembeli</h4>
                     </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="50%">Nama Pelanggan: </th>
                                            <td>{{ $order->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telp Pelanggan: </th>
                                            <td>{{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email Pelanggan: </th>
                                            <td>{{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Pelanggan: </th>
                                            <td>{{ $order->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pesanan: </th>
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
                        <span class="text-danger">Inv: {{ $order->invoice_no }}</span></h4>
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
                                            <th> Phone: </th>
                                            <td>{{ $order->user->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th> Email: </th>
                                            <td>{{ $order->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tipe Pembayaran: </th>
                                            <td>{{ $order->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Id Transaksi: </th>
                                            <td>{{ $order->transaction_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice: </th>
                                            <td class="text-danger">{{ $order->invoice_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Pesanan: </th>
                                            <td>Rp{{ number_format($order->amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pesanan: </th>
                                            <td>
                                                <span class="badge bg-success">{{ $order->status }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tombol Batalkan Pesanan --}}
                            @if ($order->status == 'Pending')
                                <form action="{{ route('user.order.cancel', $order->id) }}" method="POST">>
                                 @csrf
                                 @method('POST')
                                 <button type="submit" class="btn btn-danger mt-3"> Batalkan Pesanan </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1 mt-3">
                <div class="col">
                    <div class="card">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><label>Gambar</label></td>
                                    <td><label>Nama Produk</label></td>
                                    <td><label>Nama Toko</label></td>
                                    <td><label>Kode Produk</label></td>
                                    <td><label>Jumlah</label></td>
                                    <td><label>Harga</label></td>
                                </tr>
                                @foreach ($orderItem as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset($item->product->image) }}" style="width:50px; height:50px">
                                    </td>
                                    <td>{{ $item->product->name }}</td>
                                    @if ($item->client_id == NULL)
                                        <td>Owner</td>
                                    @else
                                        <td>{{ $item->product->client->name }}</td>
                                    @endif
                                    <td>{{ $item->product->code }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }} <br>
                                        Total = Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
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

        </div>
    </div>
    </div>
</div>
       </div>
    </div>
 </section>
@endsection
