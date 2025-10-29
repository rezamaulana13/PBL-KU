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

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="bg-white card mb-4 order-list shadow-sm">
                    <div class="gold-members p-4">
                        <div class="table-responsive">
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
                                    @forelse ($allUserOrder as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</td>
                                        <td><strong>{{ $item->invoice_no }}</strong></td>
                                        <td><strong>Rp {{ number_format($item->amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            @if($item->payment_method == 'stripe')
                                                <span class="badge bg-primary">Stripe</span>
                                            @elseif($item->payment_method == 'cash')
                                                <span class="badge bg-success">Cash</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->payment_method }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $status = strtolower(trim($item->status));
                                            @endphp
                                            @if ($status == 'pending')
                                                <span class="badge bg-info">Menunggu</span>
                                            @elseif ($status == 'confirm')
                                                <span class="badge bg-primary">Dikonfirmasi</span>
                                            @elseif ($status == 'processing')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            @elseif ($status == 'delivered')
                                                <span class="badge bg-success">Terkirim</span>
                                            @elseif ($status == 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
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
                                                    @php
                                                        $status = strtolower(trim($item->status));
                                                        // LOGIKA DIREVISI: Pesanan HANYA bisa dibatalkan jika statusnya: pending
                                                        $canCancel = in_array($status, ['pending']);
                                                    @endphp
                                                    @if($canCancel)
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('user.order.cancel', $item->id) }}" method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan yang belum diproses ini? Tindakan ini tidak dapat dibatalkan.')">
                                                                @csrf
                                                                @method('POST')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times-circle"></i> Batalkan Pesanan
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                                                <p>Belum ada pesanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
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

{{-- Sweet Alert untuk konfirmasi --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Jika ada session success
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    // Jika ada session error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    @endif
</script>
@endpush

@endsection
