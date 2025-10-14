@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
/* Gaya Kustom untuk Halaman Approve Review */
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

.kartu-stats.primary { border-color: #667eea; }
.kartu-stats.success { border-color: #28a745; }
.kartu-stats.warning { border-color: #ffc107; }
.kartu-stats.danger { border-color: #dc3545; }
.kartu-stats.info { border-color: #17a2b8; }

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

.status-aktif {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.status-nonaktif {
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

.status-active { background-color: #28a745; }
.status-inactive { background-color: #dc3545; }

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

.review-highlight {
    transition: all 0.3s ease;
}

.review-highlight:hover {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row animasi-muncul">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-sm-0 font-size-18 text-primary">
                            <i class="bx bx-message-square-check me-2"></i>Manajemen Review & Rating
                        </h4>
                        <span class="badge bg-primary ms-2">{{ $approveReview->count() }} Review</span>
                    </div>

                    <div class="page-title-right">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Moderasi konten review</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Judul -->

        <!-- Kartu Statistik Review -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.1s;">
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats primary card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Total Review</h5>
                                <h3 class="mb-0">{{ $approveReview->count() }}</h3>
                            </div>
                            <div class="avatar-kecil">
                                <i class="bx bx-message-square"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Review Aktif</h5>
                                <h3 class="mb-0">{{ $approveReview->where('status', 1)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-aktif">
                                <i class="bx bx-check"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Review Nonaktif</h5>
                                <h3 class="mb-0">{{ $approveReview->where('status', 0)->count() }}</h3>
                            </div>
                            <div class="avatar-kecil status-nonaktif">
                                <i class="bx bx-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="card kartu-stats warning card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="font-size-14 text-muted mb-0">Dengan Media</h5>
                                <h3 class="mb-0">{{ $approveReview->whereNotNull('media')->count() }}</h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                                <i class="bx bx-image"></i>
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
                                <h5 class="font-size-14 text-muted mb-0">Rating Rata-rata</h5>
                                <h3 class="mb-0">
                                    @if($approveReview->count() > 0)
                                        {{ number_format($approveReview->avg('rating'), 1) }}/5
                                    @else
                                        0
                                    @endif
                                </h3>
                            </div>
                            <div class="avatar-kecil" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
                                <i class="bx bx-star"></i>
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
        </div>

        <!-- Aksi Massal -->
        <div class="row mb-4 animasi-muncul" style="animation-delay: 0.2s;">
            <div class="col-12">
                <div class="bulk-actions">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="selectAllReviews" class="form-check-input">
                                <label class="form-check-label fw-semibold" for="selectAllReviews">
                                    Pilih Semua Review
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn btn-success waves-effect waves-light" onclick="activateSelected()">
                                    <i class="bx bx-check-circle me-1"></i>Aktifkan yang Dipilih
                                </button>
                                <button class="btn btn-danger waves-effect waves-light" onclick="deactivateSelected()">
                                    <i class="bx bx-x-circle me-1"></i>Nonaktifkan yang Dipilih
                                </button>
                                <button class="btn btn-outline-primary waves-effect" onclick="exportReviewData()">
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
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-filter me-2"></i>Filter & Pencarian Review
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="kotak-pencarian">
                                    <i class="bx bx-search"></i>
                                    <input type="text" class="form-control" id="inputPencarian" placeholder="Cari user, restoran, atau komentar...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Status Review</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Rating</label>
                                <select class="form-select" id="filterRating">
                                    <option value="">Semua Rating</option>
                                    <option value="5">5 Bintang</option>
                                    <option value="4">4 Bintang</option>
                                    <option value="3">3 Bintang</option>
                                    <option value="2">2 Bintang</option>
                                    <option value="1">1 Bintang</option>
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
                                <label class="form-label">Urut Berdasarkan</label>
                                <select class="form-select" id="filterUrutan">
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terlama">Terlama</option>
                                    <option value="rating-tinggi">Rating Tertinggi</option>
                                    <option value="rating-rendah">Rating Terendah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Review -->
        <div class="row animasi-muncul" style="animation-delay: 0.4s;">
            <div class="col-12">
                <div class="card card-hover shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="bx bx-list-ul me-2"></i>Daftar Semua Review
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-primary btn-sm" onclick="resetFilter()">
                                    <i class="bx bx-reset me-1"></i>Reset Filter
                                </button>
                                <span class="badge bg-primary ms-2" id="countReviews">
                                    {{ $approveReview->count() }} review
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover tabel-rapat align-middle mb-0">
                                <thead class="table-light">
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
                                        <th class="text-center" style="width: 100px;">Status</th>
                                        <th class="text-center" style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabelReview">
                                    @foreach ($approveReview as $key=> $item)
                                    <tr class="baris-review review-highlight"
                                        data-status="{{ $item->status }}"
                                        data-rating="{{ $item->rating }}"
                                        data-media="{{ $item->media ? (Str::endsWith($item->media, ['.mp4', '.mov', '.avi']) ? 'video' : 'foto') : 'tanpa' }}"
                                        data-user="{{ strtolower($item['user']['name']) }}"
                                        data-restoran="{{ strtolower($item['client']['name']) }}"
                                        data-komentar="{{ strtolower($item->comment) }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input pilih-review" data-id="{{ $item->id }}">
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
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bx bxs-star {{ $i <= $item->rating ? 'text-warning' : 'text-light' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">{{ $item->rating }}/5</small>
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
                                            @if ($item->status == 1)
                                                <span class="badge bg-success badge-status">
                                                    <span class="status-indicator status-active"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger badge-status">
                                                    <span class="status-indicator status-inactive"></span>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center tombol-aksi">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button"
                                                        class="btn btn-sm btn-info waves-effect"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Detail Review"
                                                        onclick="lihatDetailReview({{ $item->id }})">
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

                        @if($approveReview->isEmpty())
                        <div class="empty-state">
                            <i class="bx bx-message-square-x"></i>
                            <h4 class="text-muted mt-3">Tidak Ada Review Ditemukan</h4>
                            <p class="text-muted">Belum ada review yang perlu dimoderasi.</p>
                        </div>
                        @endif
                    </div>

                    @if($approveReview->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    Menampilkan {{ $approveReview->firstItem() }} sampai {{ $approveReview->lastItem() }} dari {{ $approveReview->total() }} entri
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $approveReview->links() }}
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

<!-- Modal Detail Review -->
<div id="modalDetailReview" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Review Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="kontenDetailReview">
                <!-- Konten detail akan diisi via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
/**
 * JavaScript untuk Manajemen Review
 */

$(document).ready(function(){
    // Inisialisasi tooltips
    var daftarTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = daftarTooltip.map(function (tooltipEl) {
        return new bootstrap.Tooltip(tooltipEl)
    });

    // Fungsi pencarian real-time
    $('#inputPencarian').on('keyup', function() {
        filterTabelReview();
    });

    // Filter perubahan
    $('#filterStatus, #filterRating, #filterMedia, #filterUrutan').on('change', function() {
        filterTabelReview();
    });

    // Select all checkbox
    $('#selectAll, #selectAllReviews').on('change', function() {
        $('.pilih-review').prop('checked', this.checked);
    });

    // Update counter
    updateReviewCounter();
});

/**
 * Filter tabel review
 */
function filterTabelReview() {
    const pencarian = $('#inputPencarian').val().toLowerCase();
    const status = $('#filterStatus').val();
    const rating = $('#filterRating').val();
    const media = $('#filterMedia').val();
    const urutan = $('#filterUrutan').val();

    let tampilCount = 0;

    $('.baris-review').each(function() {
        const teksBaris = $(this).text().toLowerCase();
        const dataStatus = $(this).data('status').toString();
        const dataRating = $(this).data('rating').toString();
        const dataMedia = $(this).data('media');
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

        // Filter status
        if (status && dataStatus !== status) {
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

        $(this).toggle(tampilkan);
        if (tampilkan) tampilCount++;
    });

    updateReviewCounter(tampilCount);
    urutkanReview(urutan);
}

/**
 * Update counter review
 */
function updateReviewCounter(count = null) {
    const total = count !== null ? count : $('.baris-review:visible').length;
    $('#countReviews').text(`${total} review`);
}

/**
 * Urutkan review
 */
function urutkanReview(kriteria) {
    const tbody = $('#bodyTabelReview');
    const baris = tbody.find('.baris-review:visible').get();

    baris.sort(function(a, b) {
        const aRating = $(a).data('rating');
        const bRating = $(b).data('rating');

        switch(kriteria) {
            case 'rating-tinggi':
                return bRating - aRating;
            case 'rating-rendah':
                return aRating - bRating;
            case 'terlama':
                return 1;
            case 'terbaru':
            default:
                return -1;
        }
    });

    $.each(baris, function(index, row) {
        tbody.append(row);
    });
}

/**
 * Reset semua filter
 */
function resetFilter() {
    $('#inputPencarian').val('');
    $('#filterStatus').val('');
    $('#filterRating').val('');
    $('#filterMedia').val('');
    $('#filterUrutan').val('terbaru');
    $('#selectAll').prop('checked', false);
    $('#selectAllReviews').prop('checked', false);
    $('.pilih-review').prop('checked', false);
    $('.baris-review').show();
    urutkanReview('terbaru');
    updateReviewCounter();
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
 * Lihat detail review
 */
function lihatDetailReview(id) {
    $('#kontenDetailReview').html(`
        <div class="text-center py-4">
            <div class="loading-spinner mx-auto"></div>
            <p>Memuat detail review...</p>
        </div>
    `);
    $('#modalDetailReview').modal('show');

    // Simulasi AJAX call
    setTimeout(() => {
        $('#kontenDetailReview').html(`
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
                        <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Aktif</span></td></tr>
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
                        <button class="btn btn-success w-100 mb-2" onclick="activateReview(${id})">
                            <i class="bx bx-check-circle me-1"></i>Aktifkan Review
                        </button>
                        <button class="btn btn-danger w-100" onclick="deactivateReview(${id})">
                            <i class="bx bx-x-circle me-1"></i>Nonaktifkan Review
                        </button>
                    </div>
                </div>
            </div>
        `);
    }, 1000);
}

/**
 * Aktifkan review yang dipilih
 */
function activateSelected() {
    const terpilih = $('.pilih-review:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu review!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Aktifkan Review?',
        html: `Anda akan mengaktifkan <strong>${terpilih.length} review</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Aktifkan!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi aktivasi massal
            terpilih.each(function() {
                const id = $(this).data('id');
                // Panggil API untuk aktivasi
            });

            Swal.fire('Berhasil!', `${terpilih.length} review telah diaktifkan`, 'success')
                .then(() => location.reload());
        }
    });
}

/**
 * Nonaktifkan review yang dipilih
 */
function deactivateSelected() {
    const terpilih = $('.pilih-review:checked');
    if (terpilih.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu review!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Nonaktifkan Review?',
        html: `Anda akan menonaktifkan <strong>${terpilih.length} review</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Nonaktifkan!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementasi nonaktivasi massal
            terpilih.each(function() {
                const id = $(this).data('id');
                // Panggil API untuk nonaktivasi
            });

            Swal.fire('Berhasil!', `${terpilih.length} review telah dinonaktifkan`, 'success')
                .then(() => location.reload());
        }
    });
}

/**
 * Ekspor data review
 */
function exportReviewData() {
    Swal.fire({
        title: 'Ekspor Data Review',
        text: 'Pilih format ekspor:',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Excel',
        cancelButtonText: 'PDF',
        showDenyButton: true,
        denyButtonText: 'CSV'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/export-reviews/excel';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = '/admin/export-reviews/pdf';
        } else if (result.isDenied) {
            window.location.href = '/admin/export-reviews/csv';
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
