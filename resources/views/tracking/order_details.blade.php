@extends('frontend.dashboard.dashboard')

@section('user')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Detail & Tracking Pesanan #{{ $order->invoice_no }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('user.track.order') }}">Pesanan</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">

            {{-- KOLOM KIRI (Tracking, Map, & Produk) --}}
            <div class="col-lg-8">

                {{-- KARTU PETA/MAP (New Section) 🗺️ --}}
                <div class="card shadow-lg mb-4 border-0 border-top border-primary border-4">
                    <div class="card-body p-0">
                        <h5 class="card-header bg-white border-0 py-3">
                            <i class="fas fa-map-marked-alt text-primary me-2"></i> Posisi Paket Terkini
                        </h5>
                        <div class="p-4">
                            {{--
                                INTEGRASI PETA:
                                Untuk implementasi nyata, ganti div ini dengan library peta (misal: Google Maps JS API, Leaflet/OpenStreetMap).
                                Placeholder di bawah menggunakan iframe dari Google Maps yang harus disesuaikan.
                                Anda perlu mendapatkan koordinat paket secara real-time dari sistem logistik Anda.
                            --}}
                            <div style="height: 350px; width: 100%; border-radius: 8px; overflow: hidden; border: 1px solid #e9ecef;">
                                <iframe
                                    width="100%"
                                    height="100%"
                                    frameborder="0" style="border:0"
                                    src="https://maps.google.com/maps?q={{ urlencode($order->city . ', ' . $order->province) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                            <p class="text-muted mt-3 mb-0"><i class="fas fa-info-circle me-1"></i> Peta menunjukkan lokasi umum paket (berdasarkan kota/provinsi) atau pusat sortir terdekat. Detail akurat berada di Riwayat Pengiriman.</p>
                        </div>
                    </div>
                </div>

                {{-- KARTU STATUS SAAT INI DAN RESI --}}
                <div class="card shadow-lg mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4 border-bottom pb-2">
                            <i class="fas fa-truck-fast text-success me-2"></i> Status & Resi Pengiriman
                        </h5>

                        {{-- BLOK STATUS DAN LOKASI TERBARU --}}
                        <div class="alert alert-{{ $order->status == 'Delivered' ? 'success' : ($order->status == 'Cancelled' ? 'danger' : ($order->tracking_no ? 'info' : 'warning')) }} d-flex flex-column p-4 mb-4 rounded-3 border-0">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-box-open fa-2x me-3"></i>
                                <div>
                                    <small class="d-block text-uppercase">Status Global Saat Ini:</small>
                                    <strong class="h3 mb-0 text-uppercase">{{ $order->status }}</strong>
                                </div>
                            </div>

                            <hr class="my-2">

                            {{-- LOGIKA LOKASI SAAT INI --}}
                            @php
                                $current_status = $order->status;
                                $location_detail = 'Menunggu update dari sistem logistik.';
                                $latest_step = collect($timeline)->filter(fn($step) => $step['completed'])->last();

                                if ($latest_step) {
                                    if ($current_status == 'Delivered') {
                                        $location_detail = 'Telah diterima oleh **' . ($order->name ?? 'Penerima') . '** pada ' . \Carbon\Carbon::parse($order->delivered_date ?? $latest_step['time'])->format('d M Y H:i');
                                    } elseif ($current_status == 'Processing' || $current_status == 'Shipped') {
                                        $location_detail = 'Paket sedang dalam perjalanan / Transit';
                                    } elseif ($current_status == 'Confirm') {
                                        $location_detail = 'Paket siap dijemput kurir';
                                    }
                                }
                                if ($current_status == 'Cancelled') {
                                    $location_detail = 'Pesanan ini telah dibatalkan.';
                                }
                            @endphp

                            <p class="mb-0 mt-2">
                                <i class="fas fa-location-arrow me-2"></i> **Lokasi/Keterangan Terakhir:** {!! $location_detail !!}
                            </p>
                        </div>

                        {{-- Nomor Resi --}}
                        @if($order->tracking_no)
                        <div class="alert alert-light border d-flex align-items-center mb-0 p-3 bg-light">
                            <i class="fas fa-barcode fa-2x text-info me-3"></i>
                            <div>
                                <small class="d-block text-muted">Nomor Resi Tracking:</small>
                                <strong class="h5 mb-0">{{ $order->tracking_no }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning p-3 mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i> Nomor resi belum tersedia, pesanan masih dalam proses persiapan.
                        </div>
                        @endif
                    </div>
                </div>

                {{-- KARTU RIWAYAT PENGIRIMAN (TIMELINE) --}}
                <div class="card shadow-lg mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4 border-bottom pb-2">
                            <i class="fas fa-clock-rotate-left text-secondary me-2"></i> Riwayat Pengiriman (Timeline)
                        </h5>

                        <div class="timeline-tracking">
                            @foreach($timeline as $step)
                            <div class="timeline-item {{ $step['completed'] ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    @if($step['completed'])
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-circle"></i>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ $step['label'] }}</h6>
                                    @if($step['time'])
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($step['time'])->format('d M Y, H:i') }} WIB
                                        </small>
                                    @else
                                        <small class="text-muted">Menunggu...</small>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($order->status != 'Delivered' && $order->status != 'Cancelled')
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-hourglass-half me-2"></i>
                            <strong>Estimasi:</strong> Status akan diperbarui secara berkala oleh pihak logistik.
                        </div>
                        @endif
                    </div>
                </div>

                {{-- KARTU DETAIL PRODUK --}}
                <div class="card shadow-lg mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4 border-bottom pb-2"><i class="fas fa-box me-2"></i> Detail Produk</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderItem as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($item->product->image ?? 'upload/no_image.jpg') }}"
                                                     alt="{{ $item->product->name ?? 'Produk' }}"
                                                     class="rounded me-3"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <span>
                                                    <strong>{{ $item->product->name ?? 'Nama Produk Tidak Ditemukan' }}</strong>
                                                    @if($item->size || $item->color)
                                                        <br><small class="text-muted">
                                                            @if($item->size) Size: {{ $item->size }} @endif
                                                            @if($item->color) Color: {{ $item->color }} @endif
                                                        </small>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">{{ $item->qty }}</td>
                                        <td class="text-end align-middle"><strong>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Ringkasan Pesanan & Penerima) --}}
            <div class="col-lg-4">
                <div class="card shadow-lg mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3 border-bottom pb-2"><i class="fas fa-file-invoice-dollar me-2"></i> Ringkasan Pembayaran</h5>

                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Diskon Voucher:</span>
                                <span class="text-danger">- Rp {{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Biaya Kirim:</span>
                                <span>Rp {{ number_format($order->shipping_charge ?? 0, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <strong>Total Akhir:</strong>
                                <strong class="text-primary h4 mb-0">Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-lg mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3 border-bottom pb-2"><i class="fas fa-user-check me-2"></i> Informasi Penerima & Pembayaran</h5>

                        <div class="d-flex flex-column mb-3">
                            <small class="text-muted">Nama Penerima:</small>
                            <div><strong>{{ $order->name }}</strong></div>
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <small class="text-muted">Telepon:</small>
                            <div>{{ $order->phone }}</div>
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <small class="text-muted">Email:</small>
                            <div>{{ $order->email }}</div>
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <small class="text-muted">Metode Pembayaran:</small>
                            <div><strong class="text-info">{{ $order->payment_method }}</strong></div>
                        </div>
                        <div class="d-flex flex-column mb-3">
                            <small class="text-muted">Alamat Lengkap:</small>
                            <div class="alert alert-light p-2 mt-1 border-primary border-start border-4">
                                {{ $order->address }}, {{ $order->district }}, {{ $order->city }}, {{ $order->province }}, {{ $order->post_code }}
                            </div>
                        </div>

                        <div class="mt-4 d-grid gap-2">
                            @if($order->status == 'Delivered')
                            <a href="{{ route('user.invoice.download', $order->id) }}" class="btn btn-success btn-lg">
                                <i class="fas fa-download me-1"></i> Download Invoice
                            </a>
                            @endif

                            @if($order->status == 'Pending')
                            <form action="{{ route('user.order.cancel', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat diulang.')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg w-100">
                                    <i class="fas fa-times me-1"></i> Batalkan Pesanan
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('user.track.order') }}" class="btn btn-outline-secondary mt-2">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS khusus untuk Timeline Tracking */
.timeline-tracking {
    position: relative;
    padding-left: 30px;
}

.timeline-tracking::before {
    content: '';
    position: absolute;
    top: 0;
    left: -19px;
    width: 2px;
    height: 100%;
    background: #e0e0e0; /* Garis abu-abu untuk belum selesai */
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
    padding-top: 5px; /* Sedikit padding atas agar marker tidak terlalu mepet */
}

.timeline-item:last-child {
    padding-bottom: 0;
}

/* Garis vertikal hijau untuk yang sudah selesai */
.timeline-item.completed:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -19px;
    top: 30px;
    width: 2px;
    height: calc(100% - 10px);
    background: #4CAF50; /* Hijau */
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #fff;
    z-index: 2; /* Pastikan marker di atas garis */
}

.timeline-item.completed .timeline-marker {
    color: #4CAF50;
    font-size: 20px; /* Ukuran icon check */
}

.timeline-item.pending .timeline-marker {
    color: #ccc;
    font-size: 10px; /* Ukuran icon circle */
    border: 1px solid #ccc;
}

.timeline-content h6 {
    font-weight: 700;
    color: #333;
}

.timeline-item.pending .timeline-content h6 {
    color: #999;
}
</style>

{{-- SCRIPT UNTUK MENDAPATKAN LOKASI GEOLOCATION PENGGUNA --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Memeriksa apakah browser mendukung Geolocation API
    if (navigator.geolocation) {
        console.log("Geolocation didukung. Meminta lokasi Anda...");

        // Meminta lokasi pengguna
        navigator.geolocation.getCurrentPosition(
            // Callback Sukses
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                console.log("Lokasi Anda berhasil didapatkan:");
                console.log("Latitude:", latitude);
                console.log("Longitude:", longitude);

                // =============================================================
                // TODO: GUNAKAN DATA INI UNTUK UPDATE PETA ATAU LOG
                // =============================================================

                // Contoh: Menampilkan pesan sukses di halaman
                // Anda bisa menambahkan div kosong di atas dan mengisinya di sini
                const locationDisplay = document.getElementById('user-location-info');
                if (locationDisplay) {
                    locationDisplay.innerHTML = `
                        <div class="alert alert-success mt-3 mb-0">
                            <i class="fas fa-location-dot me-2"></i>
                            <strong>Posisi Anda:</strong> Lat: ${latitude.toFixed(6)}, Lon: ${longitude.toFixed(6)}
                            <br><small class="text-success">Data ini diambil dari browser Anda.</small>
                        </div>
                    `;

                    // Jika Anda ingin mengupdate iframe peta (menggunakan Google Maps)
                    // Anda perlu membuat URL peta statis yang sesuai dengan koordinat ini.
                    // Contoh update:
                    const mapFrame = document.querySelector('iframe');
                    if(mapFrame) {
                        // Perhatian: Ini hanya contoh. Anda perlu memastikan URL peta Anda mendukung
                        // koordinat ini dan memiliki API Key jika diperlukan.
                        // mapFrame.src = `URL_PETA_DENGAN_KOORDINAT?lat=${latitude}&lon=${longitude}`;
                    }
                }
            },

            // Callback Error
            function(error) {
                let errorMessage = "Terjadi kesalahan saat mendapatkan lokasi.";
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = "Akses lokasi ditolak oleh pengguna.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = "Informasi lokasi tidak tersedia.";
                        break;
                    case error.TIMEOUT:
                        errorMessage = "Permintaan lokasi habis waktu.";
                        break;
                    default:
                        errorMessage = "Terjadi kesalahan yang tidak diketahui.";
                        break;
                }
                console.error("Kesalahan Geolocation:", errorMessage);

                // Contoh: Menampilkan pesan error di halaman
                const locationDisplay = document.getElementById('user-location-info');
                if (locationDisplay) {
                    locationDisplay.innerHTML = `
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Gagal mendapatkan lokasi Anda:</strong> ${errorMessage}
                        </div>
                    `;
                }
            },

            // Opsi Tambahan (Opsional)
            {
                enableHighAccuracy: true,
                timeout: 5000, // Maksimal 5 detik
                maximumAge: 0
            }
        );
    } else {
        console.error("Geolocation tidak didukung oleh browser ini.");
        const locationDisplay = document.getElementById('user-location-info');
        if (locationDisplay) {
            locationDisplay.innerHTML = `
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Browser Anda tidak mendukung fitur Geolocation.
                </div>
            `;
        }
    }
});
</script>

@endsection
