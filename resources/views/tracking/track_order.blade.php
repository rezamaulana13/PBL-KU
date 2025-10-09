@extends('frontend.dashboard.dashboard')

@section('user')

{{-- 1. Mulai BARIS (ROW) utama untuk menampung SIDEBAR dan KONTEN --}}
<div class="row">

    {{-- 2. SIDEBAR --}}
    @include('frontend.dashboard.sidebar')

    {{-- 3. KONTEN UTAMA --}}
    <div class="col-md-9">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Breadcrumb dan Judul Halaman --}}
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Lacak Pesanan</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Lacak Pesanan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Pencarian Resi/Invoice --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-4 border-bottom pb-2 text-dark">
                                    <i class="fas fa-search me-2 text-primary"></i> Lacak dengan Nomor Resi/Invoice
                                </h5>

                                {{-- PEMBERITAHUAN ERROR JIKA RESI TIDAK DITEMUKAN --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-circle-xmark me-2"></i> **Gagal Melacak!** {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- ⭐ FORMULIR PENCARIAN (PASTIKAN METHOD="POST") ⭐ --}}
                                <form method="POST" action="{{ route('user.track.by.number') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                {{-- Nama input harus 'tracking_number' sesuai ManageOrderController@TrackByNumber --}}
                                                <input type="text"
                                                       name="tracking_number"
                                                       class="form-control"
                                                       placeholder="Masukkan Nomor Resi (TRK...) atau Invoice (INV...)"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-search me-1"></i> Lacak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Riwayat Semua Pesanan (Tabel) --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light rounded-top">
                                    <h5 class="card-title mb-0 text-dark">
                                        <i class="fas fa-history me-2 text-info"></i> Riwayat Semua Pesanan
                                    </h5>
                                    {{-- Filter --}}
                                    <div class="d-flex align-items-center">
                                        <label for="statusFilter" class="form-label me-2 mb-0 d-none d-sm-block text-muted">Filter:</label>
                                        <select class="form-select w-auto form-select-sm" id="statusFilter" onchange="filterOrders()">
                                            <option value="all">Semua Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Confirm">Dikonfirmasi</option>
                                            <option value="Processing">Diproses/Dikirim</option>
                                            <option value="Delivered">Terkirim</option>
                                            <option value="Cancelled">Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive p-3">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-white">No. Invoice</th>
                                                <th class="text-white">Tanggal</th>
                                                <th class="text-white">Total</th>
                                                <th class="text-white">No. Tracking</th>
                                                <th class="text-white">Status</th>
                                                <th class="text-center text-white" style="width: 120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $item)
                                            <tr data-status="{{ $item->status }}">
                                                <td>
                                                    <strong class="text-primary">#{{ $item->invoice_no }}</strong>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}</td>
                                                <td>
                                                    <strong class="text-success">Rp {{ number_format($item->amount, 0, ',', '.') }}</strong>
                                                </td>
                                                <td>
                                                    @if($item->tracking_no)
                                                        <span class="badge bg-primary text-uppercase px-2 py-1">
                                                            {{ $item->tracking_no }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary text-uppercase px-2 py-1">
                                                            Persiapan
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Asumsi getStatusBadgeClass() ada di Model Order --}}
                                                    <span class="{{ $item->getStatusBadgeClass() }} text-uppercase fw-bold px-2 py-1">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                                            <i class="fas fa-bars me-1"></i> Aksi
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                                                            {{-- Tombol Detail/Track --}}
                                                            <li>
                                                                <a class="dropdown-item text-primary fw-bold" href="{{ route('user.order.details', $item->id) }}">
                                                                    <i class="fas fa-magnifying-glass fa-fw me-2"></i> Lihat Detail
                                                                </a>
                                                            </li>

                                                            {{-- ⭐ TOMBOL LACAK STATUS (WAJIB POST VIA FORM TERSEMBUNYI) ⭐ --}}
                                                            @if($item->tracking_no)
                                                            <li>
                                                                {{-- Form tersembunyi POST --}}
                                                                <form action="{{ route('user.track.by.number') }}" method="POST" style="display: none;" id="track-form-{{ $item->id }}">
                                                                    @csrf
                                                                    {{-- Input hidden harus 'tracking_number' --}}
                                                                    <input type="hidden" name="tracking_number" value="{{ $item->tracking_no }}">
                                                                </form>

                                                                <a class="dropdown-item text-info fw-bold"
                                                                   href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('track-form-{{ $item->id }}').submit();">
                                                                    <i class="fas fa-route fa-fw me-2"></i> Lacak Status
                                                                </a>
                                                            </li>
                                                            @endif

                                                            {{-- Pemisah --}}
                                                            <li><hr class="dropdown-divider"></li>

                                                            {{-- Tombol Batal --}}
                                                            @if($item->status == 'Pending' || $item->status == 'Confirm' || $item->status == 'Processing')
                                                            <li>
                                                                <form action="{{ route('user.order.cancel', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-xmark fa-fw me-2"></i> Batalkan Pesanan
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @endif

                                                            {{-- Tombol Invoice --}}
                                                            @if($item->status == 'Delivered')
                                                            <li>
                                                                <a class="dropdown-item text-success" href="{{ route('user.invoice.download', $item->id) }}">
                                                                    <i class="fas fa-file-pdf fa-fw me-2"></i> Download Invoice
                                                                </a>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 bg-light">
                                                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                                    <p class="text-muted fs-5">Anda belum memiliki riwayat pesanan.</p>
                                                    <a href="{{ route('index') }}" class="btn btn-primary mt-2">Mulai Belanja Sekarang</a>
                                                </td>
                                            </tr>
                                            @endforelse
                                            {{-- Baris untuk "Tidak ada hasil filter" akan ditambahkan oleh JS di bawah --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> {{-- Penutup col-md-9 --}}
</div> {{-- Penutup row --}}

@push('scripts')
<script>
    function filterOrders() {
        const filterValue = document.getElementById('statusFilter').value;
        const rows = document.querySelectorAll('tbody tr[data-status]');

        // Cari baris yang menunjukkan "Anda belum memiliki riwayat pesanan"
        let noInitialOrders = document.querySelector('tbody tr td[colspan="6"]');
        let found = false;

        // Sembunyikan pesan awal jika ada data
        if (noInitialOrders && rows.length === 1) {
            noInitialOrders.parentNode.style.display = (filterValue === 'all') ? '' : 'none';
            return;
        }

        rows.forEach(row => {
            // Abaikan baris "Tidak ditemukan" saat filtering
            if (row.id === 'no-results-row') return;

            if (filterValue === 'all' || row.dataset.status === filterValue) {
                row.style.display = ''; // Tampilkan baris
                found = true;
            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });

        // Logika untuk menampilkan pesan "Tidak ditemukan" saat memfilter
        const tableBody = document.querySelector('tbody');
        let noResultsRow = document.getElementById('no-results-row');

        if (!noResultsRow) {
            // Buat baris "Tidak ditemukan" jika belum ada
            noResultsRow = document.createElement('tr');
            noResultsRow.id = 'no-results-row';
            noResultsRow.innerHTML = `<td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada pesanan dengan status yang dipilih.
                                    </td>`;
            tableBody.appendChild(noResultsRow);
        }

        // Atur tampilan baris "Tidak ditemukan"
        noResultsRow.style.display = found ? 'none' : '';
    }

    // Panggil filterOrders saat halaman dimuat
    document.addEventListener('DOMContentLoaded', filterOrders);
</script>
@endpush

@endsection
