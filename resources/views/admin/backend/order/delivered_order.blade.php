@extends('admin.admin_dashboard')

@section('admin')

<style>
    /* Styling Kustom untuk Daftar Pesanan Terkirim */
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .card-header-custom {
        background-color: #f8f9fa; /* Latar belakang header lebih terang */
        border-bottom: 3px solid #28a745; /* Garis bawah hijau/success untuk Delivered */
        padding: 1rem 1.25rem;
    }
    .table thead th {
        background-color: #007bff; /* Header tabel biru */
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }
    .badge-status {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
    }
    .dataTables_wrapper .row:first-child {
        padding-top: 15px;
    }
    /* Mengubah warna tombol Detail menjadi info (biru) */
    .btn-info {
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-sm-0 font-size-18 fw-bold text-dark">
                        <i class="ri-check-double-line me-2 text-success"></i> Daftar Pesanan Terkirim
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{-- Breadcrumb bisa diisi jika ada --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header card-header-custom">
                        <h5 class="mb-0 text-dark">Total **{{ count($allData) }}** Pesanan Telah Selesai</h5>
                    </div>

                    <div class="card-body">

                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="15%">Tanggal</th>
                                <th width="15%">Invoice</th>
                                <th class="text-end" width="15%">Harga Total</th>
                                <th width="15%">Pembayaran</th>
                                <th class="text-center" width="10%">Status</th>
                                <th class="text-center" width="15%">Aksi</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach ($allData as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}</td>
                                <td class="fw-bold text-primary">{{ $item->invoice_no }}</td>
                                <td class="text-end fw-bold text-danger">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td class="text-center">
                                    {{-- Menggunakan badge success untuk Delivered --}}
                                    <span class="badge badge-status bg-success">{{ $item->status }}</span>
                                </td>

                                <td class="text-center">
                                    {{-- ROUTE DIJAGA AMAN --}}
                                    <a href="{{ route('admin.order.details',$item->id) }}" class="btn btn-info btn-sm waves-effect waves-light" title="Lihat Detail">
                                        <i class="ri-eye-line"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> </div> </div> </div>

@endsection
