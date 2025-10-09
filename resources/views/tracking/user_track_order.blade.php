@extends('frontend.dashboard.dashboard')

@section('user')

<div class="row g-4">

    {{-- 1. SIDEBAR --}}
    @include('frontend.dashboard.sidebar')

    {{-- 2. KONTEN UTAMA --}}
    <div class="col-md-9">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Header Halaman: Breadcrumb & Judul --}}
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Lacak Pesanan Anda</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Lacak Pesanan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{--- A. BAGIAN PENCARIAN RESI/INVOICE ---}}
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-lg border-0 rounded-3">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4 border-bottom pb-2 text-dark fw-bold">
                                    <i class="fas fa-truck-fast me-2 text-primary"></i> Cari Pesanan Berdasarkan Nomor
                                </h5>

                                {{-- Pemberitahuan Error/Sukses --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert">
                                        <i class="fas fa-triangle-exclamation me-2"></i> <strong>Gagal!</strong> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                                        <i class="fas fa-check-circle me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- ⭐ FORMULIR PENCARIAN ⭐ --}}
                                <form method="POST" action="{{ route('user.track.by.number') }}">
                                    @csrf
                                    <div class="row g-2 align-items-center">
                                        <div class="col-lg-10 col-9">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light d-none d-sm-flex"><i class="fas fa-hashtag"></i></span>
                                                <input type="text"
                                                    name="tracking_number"
                                                    class="form-control form-control-lg"
                                                    placeholder="Masukkan No. Resi (TRK...) atau No. Invoice (INV...)"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-3">
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="fas fa-search me-1"></i> Lacak
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                {{-- B. BAGIAN HASIL PELACAKAN (TAMPIL JIKA DATA DITEMUKAN) --}}
                @if(isset($trackedOrder))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-lg border-0 rounded-3 mb-5">
                            <div class="card-header bg-success text-white p-3 rounded-top-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-check-circle me-2"></i> Hasil Pelacakan Pesanan #{{ $trackedOrder->invoice_no }}
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                {{-- Detail singkat --}}
                                <div class="row mb-4 bg-light p-3 rounded-3">
                                    <div class="col-md-4">
                                        <p class="mb-0 text-muted small">Invoice:</p>
                                        <h6 class="text-primary">{{ $trackedOrder->invoice_no }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0 text-muted small">Status Saat Ini:</p>
                                        <span class="{{ $trackedOrder->getStatusBadgeClass() }} text-uppercase fw-bold px-2 py-1">{{ $trackedOrder->status }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0 text-muted small">Total Bayar:</p>
                                        <h6 class="text-success">Rp {{ number_format($trackedOrder->amount, 0, ',', '.') }}</h6>
                                    </div>
                                </div>

                                {{-- Timeline Status Pesanan (Placeholder) --}}
                                <h6 class="border-bottom pb-2 mb-4 text-dark fw-bold"><i class="fas fa-list-check me-2"></i> Perkembangan Status Pesanan</h6>

                                {{-- ⭐ TEMPAT LOGIKA TIMELINE/STEPPER PESANAN NYATA BERADA ⭐ --}}
                                <div class="alert alert-info border-0">
                                    <i class="fas fa-info-circle me-2"></i> **Placeholder:** Di sini akan tampil detail log pergerakan pesanan/resi secara visual (misalnya, dalam bentuk timeline).
                                    <br> Status saat ini: **{{ $trackedOrder->status }}**
                                </div>

                                <div class="text-end mt-4">
                                    <a href="{{ route('user.order.details', $trackedOrder->id) }}" class="btn btn-outline-primary">
                                        Lihat Detail Lengkap Pesanan <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END HASIL PELACAKAN --}}
                @endif

                {{-- Judul Riwayat Pesanan Agar Terpisah --}}
                <h4 class="mt-4 mb-3 fw-bold text-dark border-bottom pb-2">Riwayat Semua Pesanan Anda</h4>


                {{--- C. RIWAYAT SEMUA PESANAN (Tabel) ---}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center rounded-top-3">
                                <h5 class="card-title mb-0 fw-bold text-dark">
                                    <i class="fas fa-box-archive me-2"></i> Daftar Riwayat
                                </h5>
                                {{-- Filter Status --}}
                                <div class="d-flex align-items-center">
                                    <label for="statusFilter" class="form-label me-2 mb-0 text-muted d-none d-sm-block small">Filter:</label>
                                    <select class="form-select w-auto form-select-sm" id="statusFilter" onchange="filterOrders()">
                                        <option value="all" selected>Semua Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Confirm">Dikonfirmasi</option>
                                        <option value="Processing">Diproses/Dikirim</option>
                                        <option value="Delivered">Terkirim</option>
                                        <option value="Cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No. Invoice</th>
                                                <th>Tanggal</th>
                                                <th>Total Pembayaran</th>
                                                <th>No. Tracking</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 120px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $item)
                                                <tr data-status="{{ $item->status }}">
                                                    <td><strong class="text-primary">#{{ $item->invoice_no }}</strong></td>
                                                    <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}</td>
                                                    <td><strong class="text-success">Rp {{ number_format($item->amount, 0, ',', '.') }}</strong></td>
                                                    <td>
                                                        @if($item->tracking_no)
                                                            <span class="badge bg-info text-dark text-uppercase px-2 py-1 fw-bold">{{ $item->tracking_no }}</span>
                                                        @else
                                                            <span class="badge bg-secondary text-uppercase px-2 py-1">Belum Dikirim</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="{{ $item->getStatusBadgeClass() }} text-uppercase fw-bold px-2 py-1">{{ $item->status }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                                                <i class="fas fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                                <li><a class="dropdown-item text-primary fw-bold" href="{{ route('user.order.details', $item->id) }}"><i class="fas fa-file-lines fa-fw me-2"></i> Lihat Detail</a></li>

                                                                @if($item->tracking_no)
                                                                    <li>
                                                                        <form action="{{ route('user.track.by.number') }}" method="POST" id="track-form-{{ $item->id }}" style="display: none;">
                                                                            @csrf
                                                                            <input type="hidden" name="tracking_number" value="{{ $item->tracking_no }}">
                                                                        </form>
                                                                        <a class="dropdown-item text-info" href="#" onclick="event.preventDefault(); document.getElementById('track-form-{{ $item->id }}').submit();">
                                                                            <i class="fas fa-route fa-fw me-2"></i> Lacak Status
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if($item->tracking_no || $item->status != 'Delivered' && $item->status != 'Cancelled')
                                                                    <li><hr class="dropdown-divider"></li>
                                                                @endif

                                                                @if($item->status == 'Pending' || $item->status == 'Confirm')
                                                                    <li>
                                                                        <form action="{{ route('user.order.cancel', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan #{{ $item->invoice_no }}?')">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-ban fa-fw me-2"></i> Batalkan Pesanan</button>
                                                                        </form>
                                                                    </li>
                                                                @endif

                                                                @if($item->status == 'Delivered')
                                                                    <li><a class="dropdown-item text-success fw-bold" href="{{ route('user.invoice.download', $item->id) }}"><i class="fas fa-file-pdf fa-fw me-2"></i> Download Invoice</a></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr id="no-initial-orders-row">
                                                    <td colspan="6" class="text-center py-5 bg-white">
                                                        <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                                                        <p class="text-muted fs-5 mb-3">Anda belum memiliki riwayat pesanan.</p>
                                                        <a href="{{ route('index') }}" class="btn btn-primary btn-lg">Mulai Belanja Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
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
                {{--- END RIWAYAT SEMUA PESANAN ---}}

            </div>
        </div>
    </div> {{-- Penutup col-md-9 --}}
</div> {{-- Penutup row --}}

@push('scripts')
<script>
    /**
     * Fungsi untuk memfilter baris tabel pesanan berdasarkan status yang dipilih.
     */
    function filterOrders() {
        const filterValue = document.getElementById('statusFilter').value;
        const tableBody = document.querySelector('tbody');
        const orderRows = tableBody.querySelectorAll('tr[data-status]');
        const noInitialOrdersRow = document.getElementById('no-initial-orders-row');
        let noResultsRow = document.getElementById('no-results-row');
        let visibleCount = 0;

        // 1. Tangani pesan default
        if (noInitialOrdersRow) {
            noInitialOrdersRow.style.display = (orderRows.length === 0 && filterValue === 'all') ? '' : 'none';
        }

        // 2. Logika Pemfilteran
        orderRows.forEach(row => {
            const isVisible = filterValue === 'all' || row.dataset.status === filterValue;
            row.style.display = isVisible ? '' : 'none';

            if (isVisible) {
                visibleCount++;
            }
        });

        // 3. Logika Pesan "Tidak Ditemukan"
        if (!noResultsRow) {
            noResultsRow = document.createElement('tr');
            noResultsRow.id = 'no-results-row';
            noResultsRow.innerHTML = `<td colspan="6" class="text-center py-4 text-muted bg-light">
                <i class="fas fa-circle-exclamation me-2"></i>
                <span class="no-results-text">Tidak ada pesanan dengan status yang dipilih.</span>
            </td>`;
            tableBody.appendChild(noResultsRow);
        }

        // Perbarui teks dan tampilkan/sembunyikan pesan "Tidak Ditemukan"
        const statusText = filterValue === 'all' ? 'yang sesuai dengan kriteria' : `"${filterValue}"`;
        noResultsRow.querySelector('.no-results-text').textContent = `Tidak ada pesanan dengan status ${statusText} di riwayat Anda.`;
        noResultsRow.style.display = (visibleCount === 0 && !noInitialOrdersRow) ? '' : 'none';
    }

    // Jalankan filter saat halaman dimuat
    document.addEventListener('DOMContentLoaded', filterOrders);
</script>
@endpush

@endsection
