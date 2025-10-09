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
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h4 class="font-weight-bold mt-0 mb-4">Daftar Pesanan</h4>

                <div class="bg-white card mb-4 order-list shadow-sm">
                    <div class="gold-members p-4">
                        <div class="table-responsive">
                            {{-- Ubah kelas tabel untuk tampilan yang lebih bersih --}}
                            <table class="table table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Invoice</th>
                                        <th>Harga</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allUserOrder as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->order_date }}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            @if (strtolower(trim($item->status)) == 'pending')
                                                <span class="badge bg-info">Menunggu</span>
                                            @elseif (strtolower(trim($item->status)) == 'confirm')
                                                <span class="badge bg-primary">Dikonfirmasi</span>
                                            @elseif (strtolower(trim($item->status)) == 'processing')
                                                <span class="badge bg-warning">Diproses</span>
                                            @elseif (strtolower(trim($item->status)) == 'delivered')
                                                <span class="badge bg-success">Dikirim</span>
                                            @elseif (strtolower(trim($item->status)) == 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{-- Menu Aksi Dropdown yang Rapi --}}
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('user.order.details',$item->id) }}">
                                                            <i class="fas fa-eye"></i> Lihat Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('user.invoice.download',$item->id) }}">
                                                            <i class="fa fa-download"></i> Unduh Invoice
                                                        </a>
                                                    </li>
                                                    @if(in_array(strtolower(trim($item->status)), ['pending', 'processing', 'confirm']))
                                                        <li>
                                                            <form action="{{ route('user.order.cancel', $item->id) }}" method="POST"
                                                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                                @csrf
                                                                @method('POST')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
