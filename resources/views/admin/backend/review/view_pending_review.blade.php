@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
/* Gaya Kustom untuk Halaman Pending Review */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.badge-status {
    font-size: 0.75em;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.tombol-aksi .btn {
    margin: 2px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tombol-aksi .btn:hover {
    transform: translateY(-2px);
}

.tabel-rapat td, .tabel-rapat th {
    vertical-align: middle;
}

.avatar-kecil {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.loading-spinner {
    display: none;
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.kotak-pencarian {
    position: relative;
}

.kotak-pencarian .form-control {
    padding-left: 40px;
    border-radius: 25px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.kotak-pencarian .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.25);
}

.kotak-pencarian i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}

.kartu-stats {
    border-left: 4px solid;
    transition: all 0.3s ease;
}

.kartu-stats:hover {
    transform: translateY(-3px);
}

.kartu-stats.warning { border-color: #ffc107; }
.kartu-stats.danger { border-color: #dc3545; }
.kartu-stats.success { border-color: #28a745; }
.kartu-stats.info { border-color: #17a2b8; }
.kartu-stats.primary { border-color: #667eea; }

.rating-stars {
    color: #ffc107;
    font-size: 16px;
}

.media-preview {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.media-preview:hover {
    transform: scale(1.1);
    border-color: #667eea;
}

.video-preview {
    width: 120px;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.status-pending {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.status-rejected {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.animasi-muncul {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-state {
    padding: 3rem 1rem;
    text-align: center;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.toggle-switch {
    transform: scale(0.8);
    transform-origin: left center;
}

.filter-group {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #e9ecef;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

.status-pending-ind { background-color: #ffc107; }
.status-rejected-ind { background-color: #dc3545; }
.status-approved-ind { background-color: #28a745; }

.comment-text {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e9ecef;
}

.media-badge {
    font-size: 0.7em;
    padding: 3px 8px;
}

.bulk-actions {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 2px dashed #dee2e6;
}

.pending-highlight {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
    border-left: 4px solid #ffc107;
    transition: all 0.3s ease;
}

.pending-highlight:hover {
    background: linear-gradient(135deg, #ffeaa7 0%, #ffdf7e 100%) !important;
}

.urgent-badge {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    animation: blink 2s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}

.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.review-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

.priority-high {
    border-left: 4px solid #dc3545 !important;
}

.priority-medium {
    border-left: 4px solid #ffc107 !important;
}

.priority-low {
    border-left: 4px solid #28a745 !important;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-warning">
                            <i class="bx bx-time me-2"></i>Review Menunggu Persetujuan
                        </h4>
                        <span class="badge bg-warning ms-2">{{ $pendingReview->where('status', 0)->count() }} Pending</span>
                    </div>

                    <div class="page-title-right">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Perlu moderasi segera</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Judul -->

        <!-- Kartu Statistik Pending Review -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats warning card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Pending</h5>
                                <h3 class="mb-0">{{ $pendingReview->where('status', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-pending">
                                <i class="bx bx-time"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats danger card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Menunggu >3 Hari</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil status-rejected">
                                <i class="bx bx-alarm"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Baru Hari Ini</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats info card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Dengan Media</h5>
                                <h3 class="mb-0">{{ $pendingReview->where('status', 0)->whereNotNull('media')->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-image"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats success card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Rating Rendah (<3)</h5>
                                <h3 class="mb-0">{{ $pendingReview->where('status', 0)->where('rating', '<', 3)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                <i class="bx bx-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats danger card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Perlu Perhatian</h5>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div class="avatar-kecil status-rejected">
                                <i class="bx bx-error"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Massal -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-12">
                <div class="bulk-actions">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="selectAllPending" class="form-check-input">
                                <label class="form-check-label fw-semibold" for="selectAllPending">
                                    Pilih Semua Review Pending
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-success waves-effect waves-light" onclick="approveSelected()">
                                    <i class="bx bx-check-circle me-1"></i>Setujui yang Dipilih
                                </button>
                                <button class="btn btn-danger waves-effect waves-light" onclick="rejectSelected()">
                                    <i class="bx bx-x-circle me-1"></i>Tolak yang Dipilih
                                </button>
                                <button class="btn btn-outline-primary waves-effect" onclick="exportPendingData()">
                                    <i class="bx bx-download me-1"></i>Ekspor Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.3s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="bx bx-filter me-2"></i>Filter Review Pending
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari review pending...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Durasi Pending</label>
                                <select class="form-select" id="filterDurasi">
                                    <option value="">Semua Durasi</option>
                                    <option value="hari-ini">Baru Hari Ini</option>
                                    <option value="1-3-hari">1-3 Hari</option>
                                    <option value="lebih-3">> 3 Hari</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Rating</label>
                                <select class="form-select" id="filterRating">
                                    <option value="">Semua Rating</option>
                                    <option value="1">1 Bintang</option>
                                    <option value="2">2 Bintang</option>
                                    <option value="3">3 Bintang</option>
                                    <option value="4">4 Bintang</option>
                                    <option value="5">5 Bintang</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Tipe Media</label>
                                <select class="form-select" id="filterMedia">
                                    <option value="">Semua Media</option>
                                    <option value="foto">Hanya Foto</option>
                                    <option value="video">Hanya Video</option>
                                    <option value="tanpa">Tanpa Media</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Prioritas</label>
                                <select class="form-select" id="filterPrioritas">
                                    <option value="">Semua Prioritas</option>
                                    <option value="tinggi">Prioritas Tinggi</option>
                                    <option value="sedang">Prioritas Sedang</option>
                                    <option value="rendah">Prioritas Rendah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Review Pending -->
        <div class="row animasi-muncul" style="animation-delay: 0.4s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="bx bx-list-ul me-2"></i>Daftar Review Menunggu Persetujuan
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-warning btn-sm" onclick="resetFilter()">
                                    <i class="bx bx-reset me-1"></i>Reset Filter
                                </button>
                                <span class="badge bg-warning ms-2" id="countPending">
                                    {{ $pendingReview->where('status', 0)->count() }} review pending
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-warning">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th>User</th>
                                        <th>Restoran</th>
                                        <th>Komentar</th>
                                        <th class="text-center" style="width: 100px;">Rating</th>
                                        <th class="text-center" style="width: 100px;">Media</th>
                                        <th class="text-center" style="width: 120px;">Status</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelPending">
                                    @foreach ($pendingReview->where('status', 0) as $key=> $item)
                                    @php
                                        $priority = 'sedang';
                                        if ($item->rating < 2) $priority = 'tinggi';
                                        if ($item->created_at->diffInDays(now()) > 3) $priority = 'tinggi';
                                        if ($item->rating >= 4) $priority = 'rendah';
                                    @endphp
                                    <tr class="baris-pending pending-highlight priority-{{ $priority }}"
                                        data-durasi="1-3-hari"
                                        data-rating="{{ $item->rating }}"
                                        data-media="{{ $item->media ? (Str::endsWith($item->media, ['.mp4', '.mov', '.avi']) ? 'video' : 'foto') : 'tanpa' }}"
                                        data-prioritas="{{ $priority }}"
                                        data-user="{{ strtolower($item['user']['name']) }}"
                                        data-restoran="{{ strtolower($item['client']['name']) }}"
                                        data-komentar="{{ strtolower($item->comment) }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input pilih-pending" data-id="{{ $item->id }}">
                                        </td>
                                        <td class="text-center">
                                            <div class="avatar-kecil mx-auto">
                                                {{ $key+1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ url('backend/assets/images/logo.jpeg') }}"
                                                         alt="{{ $item['user']['name'] }}"
                                                         class="user-avatar me-2">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item['user']['name'] }}</h6>
                                                    <small class="text-muted">User ID: {{ $item->user_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="bx bx-restaurant text-primary me-2"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $item['client']['name'] }}</h6>
                                                    <small class="text-muted">Restoran ID: {{ $item->client_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="comment-text" data-bs-toggle="tooltip" data-bs-title="{{ $item->comment }}">
                                                {{ Str::limit($item->comment, 50, '...') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $item->created_at->diffForHumans() }}
                                                @if($item->created_at->diffInDays(now()) < 1)
                                                <span class="badge bg-danger urgent-badge ms-1">Baru!</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bx bxs-star {{ $i <= $item->rating ? 'text-warning' : 'text-light' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">{{ $item->rating }}/5</small>
                                            @if($item->rating < 3)
                                            <div>
                                                <small class="text-danger">
                                                    <i class="bx bx-error-circle me-1"></i>Rating rendah
                                                </small>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->media)
                                                @if(Str::endsWith($item->media, ['.mp4', '.mov', '.avi']))
                                                    <video class="video-preview" controls onclick="tampilkanMedia('{{ asset('storage/'.$item->media) }}', 'video')">
                                                        <source src="{{ asset('storage/'.$item->media) }}">
                                                    </video>
                                                    <div>
                                                        <span class="badge bg-info media-badge">Video</span>
                                                    </div>
                                                @else
                                                    <img src="{{ asset('storage/'.$item->media) }}"
                                                         class="media-preview"
                                                         onclick="tampilkanMedia('{{ asset('storage/'.$item->media) }}', 'foto')"
                                                         alt="Review Image">
                                                    <div>
                                                        <span class="badge bg-success media-badge">Foto</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning badge-status">
                                                <span class="status-indicator status-pending-ind"></span>
                                                Menunggu Review
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="review-actions">
                                                <button type="button"
                                                        class="btn btn-sm btn-success waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Setujui Review"
                                                        onclick="approveReview({{ $item->id }}, '{{ $item['user']['name'] }}')">
                                                    <i class="bx bx-check"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-sm btn-danger waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Tolak Review"
                                                        onclick="rejectReview({{ $item->id }}, '{{ $item['user']['name'] }}')">
                                                    <i class="bx bx-x"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-sm btn-info waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Detail Review"
                                                        onclick="lihatDetailPending({{ $item->id }})">
                                                    <i class="bx bx-show"></i>
                                                </button>

                                                <input data-id="{{$item->id}}" class="toggle-class toggle-switch" type="checkbox"
                                                       data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                       data-on="Aktif" data-off="Nonaktif" {{ $item->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($pendingReview->where('status', 0)->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-party display-1 text-success"></i>
                            <h4 class="text-success mt-3">Tidak Ada Review Pending!</h4>
                            <p class="text-muted">Semua review telah diproses. Kerja bagus! 🎉</p>
                            <div class="mt-3">
                                <span class="badge bg-success badge-status">
                                    <i class="bx bx-check-circle me-1"></i>Semua terselesaikan
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($pendingReview->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $pendingReview->where('status', 0)->firstItem() }} sampai {{ $pendingReview->where('status', 0)->lastItem() }} dari {{ $pendingReview->where('status', 0)->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $pendingReview->where('status', 0)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>

<!-- Modal Tampilan Media -->
<div id="modalMedia" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMediaLabel">Media Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <div id="mediaContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pending Review -->
<div id="modalDetailPending" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title text-warning">
                    <i class="bx bx-detail me-2"></i>Detail Review Pending
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="kontenDetailPending">
                <!-- Konten detail akan diisi via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Halaman Pending Review
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian real-time
    $('#inputPencarian').on('keyup', function() {
        filterTabelPending();
    });

    // Filter perubahan
    $('#filterDurasi, #filterRating, #filterMedia, #filterPrioritas').on('change', function() {
        filterTabelPending();
    });

    // Select all checkbox
    $('#selectAll, #selectAllPending').on('change', function() {
        $('.pilih-pending').prop('checked', this.checked);
    });

    // Update counter
    updatePendingCounter();
});

/**
 * Filter tabel pending
 */
function filterTabelPending() {
    const pencarian = $('#inputPencarian').val().toLowerCase();
    const durasi = $('#filterDurasi').val();
    const rating = $('#filterRating').val();
    const media = $('#filterMedia').val();
    const prioritas = $('#filterPrioritas').val();

    let tampilCount = 0;

    $('.baris-pending').each(function() {
        const teksBaris = $(this).text().toLowerCase();
        const dataDurasi = $(this).data('durasi');
        const dataRating = $(this).data('rating').toString();
        const dataMedia = $(this).data('media');
        const dataPrioritas = $(this).data('prioritas');
        const dataUser = $(this).data('user');
        const dataRestoran = $(this).data('restoran');
        const dataKomentar = $(this).data('komentar');

        let tampilkan = true;

        // Filter pencarian
        if (pencarian && !teksBaris.includes(pencarian) &&
            !dataUser.includes(pencarian) &&
            !dataRestoran.includes(pencarian) &&
            !dataKomentar.includes(pencarian)) {
            tampilkan = false;
        }

        // Filter durasi
        if (durasi && dataDurasi !== durasi) {
            tampilkan = false;
        }

        // Filter rating
        if (rating && dataRating !== rating) {
            tampilkan = false;
        }

        // Filter media
        if (media && dataMedia !== media) {
            tampilkan = false;
        }

        // Filter prioritas
        if (prioritas && dataPrioritas !== prioritas) {
            tampilkan = false;
        }

        $(this).toggle(tampilkan);
        if (tampilkan) tampilCount++;
    });

    updatePendingCounter(tampilCount);
}

/**
 * Update counter pending
 */
function updatePendingCounter(count = null) {
    const total = count !== null ? count : $('.baris-pending:visible').length;
    $('#countPending').text(`${total} review pending`);
}

/**
 * Reset semua filter
 */
function resetFilter() {
    $('#inputPencarian').val('');
    $('#filterDurasi').val('');
    $('#filterRating').val('');
    $('#filterMedia').val('');
    $('#filterPrioritas').val('');
    $('#selectAll').prop('checked', false);
    $('#selectAllPending').prop('checked', false);
    $('.pilih-pending').prop('checked', false);
    $('.baris-pending').show();
    updatePendingCounter();
}

/**
 * Menampilkan media dalam modal
 */
function tampilkanMedia(src, tipe) {
    const container = $('#mediaContainer');
    container.empty();

    if (tipe === 'video') {
        container.html(`
            <video controls autoplay class="img-fluid" style="max-height: 70vh;">
                <source src="${src}">
                Browser Anda tidak mendukung pemutar video.
            </video>
        `);
    } else {
        container.html(`<img src="${src}" class="img-fluid" style="max-height: 70vh;">`);
    }

    $('#modalMedia').modal('show');
}

/**
 * Lihat detail review pending
 */
function lihatDetailPending(id) {
    $('#kontenDetailPending').html(`
        <div class="text-center py-4">
            <div class="loading-spinner mx-auto"></div>
            <p>Memuat detail review...</p>
        </div>
    `);
    $('#modalDetailPending').modal('show');

    // Simulasi AJAX call
    setTimeout(() => {
        $('#kontenDetailPending').html(`
            <div class="row">
                <div class="col-md-8">
                    <h6>Informasi Review</h6>
                    <table class="table table-sm">
                        <tr><td><strong>User:</strong></td><td>Nama User</td></tr>
                        <tr><td><strong>Restoran:</strong></td><td>Nama Restoran</td></tr>
                        <tr><td><strong>Rating:</strong></td><td>
                            <div class="rating-stars">
                                ${Array(5).fill().map((_, i) =>
                                    `<i class="bx bxs-star ${i < 4 ? 'text-warning' : 'text-light'}"></i>`
                                ).join('')}
                            </div>
                            4/5
                        </td></tr>
                        <tr><td><strong>Tanggal:</strong></td><td>1 Jan 2024</td></tr>
                        <tr><td><strong>Status:</strong></td><td><span class="badge bg-warning">Menunggu Review</span></td></tr>
                    </table>

                    <h6 class="mt-3">Komentar Lengkap</h6>
                    <div class="border rounded p-3 bg-light">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <h6>Media</h6>
                    <img src="{{ url('backend/assets/images/logo.jpeg') }}" alt="Media" class="img-fluid rounded mb-3" style="max-height: 200px;">
                    <div class="mt-3">
                        <button class="btn btn-success w-100 mb-2" onclick="approveReview(${id}, 'Nama User')">
                            <i class="bx bx-check-circle me-1"></i>Setujui Review
                        </button>
                        <button class="btn btn-danger w-100" onclick="rejectReview(${id}, 'Nama User')">
                            <i class="bx bx-x-circle me-1"></i>Tolak Review
                        </button>
                    </div>
                </div>
            </div>
        `);
    }, 1000);
}

/**
 * Setujui review individual
 */
function approveReview(id, userName) {
    Swal.fire({
        title: 'Setujui Review?',
        html: `Anda akan menyetujui review dari <strong>${userName}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi approval
            $.ajax({
                type: "POST",
                url: '/admin/approve-review/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 1
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `Review dari ${userName} telah disetujui`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui review', 'error');
                }
            });
        }
    });
}

/**
 * Tolak review individual
 */
function rejectReview(id, userName) {
    Swal.fire({
        title: 'Tolak Review?',
        html: `Anda akan menolak review dari <strong>${userName}</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Masukkan alasan penolakan review...',
        inputAttributes: {
            'aria-label': 'Masukkan alasan penolakan'
        },
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            const alasan = result.value;
            if (!alasan) {
                Swal.fire('Peringatan', 'Harap masukkan alasan penolakan', 'warning');
                return;
            }

            // Implementasi rejection dengan alasan
            $.ajax({
                type: "POST",
                url: '/admin/reject-review/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 0,
                    rejection_reason: alasan
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `Review dari ${userName} telah ditolak`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menolak review', 'error');
                }
            });
        }
    });
}

/**
 * Setujui review yang dipilih
 */
function approveSelected() {
    const terpilih = $('.pilih-pending:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu review!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Setujui Review?',
        html: `Anda akan menyetujui <strong>${terpilih.length} review</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui Semua!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi approval massal
            const ids = terpilih.map(function() {
                return $(this).data('id');
            }).get();

            $.ajax({
                type: "POST",
                url: '/admin/approve-reviews-bulk',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `${terpilih.length} review telah disetujui`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui review', 'error');
                }
            });
        }
    });
}

/**
 * Tolak review yang dipilih
 */
function rejectSelected() {
    const terpilih = $('.pilih-pending:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu review!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Tolak Review?',
        html: `Anda akan menolak <strong>${terpilih.length} review</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak Semua!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi rejection massal
            const ids = terpilih.map(function() {
                return $(this).data('id');
            }).get();

            $.ajax({
                type: "POST",
                url: '/admin/reject-reviews-bulk',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids
                },
                success: function(response) {
                    Swal.fire('Berhasil!', `${terpilih.length} review telah ditolak`, 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menolak review', 'error');
                }
            });
        }
    });
}

/**
 * Ekspor data pending
 */
function exportPendingData() {
    Swal.fire({
        title: 'Ekspor Data Pending',
        text: 'Pilih format ekspor:',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        showDenyButton: true,
        denyButtonText: 'CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/export-pending-reviews/excel';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = '/admin/export-pending-reviews/pdf';
        } else if (result.isDenied) {
            window.location.href = '/admin/export-pending-reviews/csv';
        }
    });
}

/**
 * Toggle status review (AJAX) - untuk kompatibilitas
 */
$(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var review_id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/reviewchangeStatus',
            data: {'status': status, 'review_id': review_id},
            success: function(data){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
                });

                if ($.isEmptyObject(data.error)) {
                    Toast.fire({
                        icon: 'success',
                        title: data.success,
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.error,
                    });
                }
            },
            error: function(xhr, status, error) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan saat mengubah status',
                });
            }
        });
    });
});
</script>

@endsection
