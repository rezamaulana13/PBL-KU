<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Wajib di-import untuk generateTrackingNumber() dan casts

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        // Mengubah kolom tanggal/waktu di database menjadi objek Carbon secara otomatis
        'confirmed_date'  => 'datetime',
        'processing_date' => 'datetime',
        'delivered_date'  => 'datetime',
        'created_at'      => 'datetime',
        'order_date'      => 'datetime', // Jika Anda menyimpannya sebagai timestamp
    ];

    // --- RELATIONS ---

    /**
     * Relasi ke User (Pembeli)
     */
    public function user()
    {
        // Asumsi Model User berada di App\Models\User
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke OrderItems (Rincian Produk yang Dibeli)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke Client/Restaurant (Pemilik produk)
     * Catatan: Pastikan Model 'Client' atau 'Restaurant' tersedia.
     */
    public function client()
    {
        // Ganti 'Client' dengan nama Model yang benar jika berbeda
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    // --- TRACKING AND HELPER METHODS ---

    /**
     * Menyusun linimasa (timeline) status pesanan untuk tracking.
     * Digunakan di ManageOrderController::UserOrderDetails
     */
    public function getTrackingTimeline()
    {
        $timeline = [
            [
                'status' => 'Pending',
                'label' => 'Pesanan Dibuat',
                'time' => $this->created_at, // Menggunakan created_at
                'completed' => true,
                'icon' => 'box' // Icon fas-box
            ],
            [
                'status' => 'Confirm',
                'label' => 'Pesanan Dikonfirmasi & Sedang Diproses',
                'time' => $this->confirmed_date,
                'completed' => $this->confirmed_date !== null,
                'icon' => 'check-circle'
            ],
            [
                'status' => 'Processing',
                'label' => 'Pesanan Dalam Pengiriman',
                'time' => $this->processing_date,
                'completed' => $this->processing_date !== null,
                'icon' => 'shipping-fast' // Atau 'clock', 'truck'
            ],
            [
                'status' => 'Delivered',
                'label' => 'Pesanan Telah Diterima',
                'time' => $this->delivered_date,
                'completed' => $this->delivered_date !== null,
                'icon' => 'check-double'
            ]
        ];

        // Tambahkan status batal sebagai langkah terpisah jika terjadi
        if (strtolower($this->status) === 'cancelled') {
             $timeline[] = [
                 'status' => 'Cancelled',
                 'label' => 'Pesanan Dibatalkan',
                 'time' => $this->updated_at,
                 'completed' => true,
                 'icon' => 'x-circle'
               ];
        }

        return $timeline;
    }

    /**
     * Memberikan kelas CSS untuk badge status.
     */
    public function getStatusBadgeClass()
    {
        // Menggunakan PHP 8.0+ match expression
        return match(strtolower($this->status)) {
            'pending' => 'badge bg-warning text-dark',
            'confirm' => 'badge bg-info',
            'processing' => 'badge bg-primary',
            'delivered' => 'badge bg-success',
            'cancelled' => 'badge bg-danger',
            default => 'badge bg-secondary'
        };
        
        switch ($this->status) {
        case 'Pending':
            return 'bg-warning text-dark';
        case 'Confirm':
            return 'bg-info';
        case 'Processing':
            return 'bg-primary';
        case 'Shipped':
            return 'bg-purple'; // Asumsi Anda punya kelas ini
        case 'Delivered':
            return 'bg-success';
        case 'Cancelled':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
    }

    /**
     * Menggunakan Accessor untuk format total harga (opsional tapi disarankan)
     * Dipanggil dengan $order->formattedTotalPrice
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }


    /**
     * Menghasilkan nomor tracking unik (static method).
     * Digunakan saat admin mengubah status dari Pending ke Confirm.
     */
    public static function generateTrackingNumber()
    {
        // Format: TRK + Tanggal Hari Ini (Ymd) + 6 Karakter Unik
        return 'TRK' . Carbon::now()->format('Ymd') . strtoupper(substr(uniqid(), -6));
    }

}
