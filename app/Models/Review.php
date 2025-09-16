<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Field yang boleh diisi mass assignment
    protected $fillable = [
        'client_id',
        'user_id',
        'comment',
        'rating',
        'media',
        'status',
    ];

    /**
     * Relasi ke Client (produk)
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Relasi ke User (yang memberi review)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Cek apakah review punya media (foto/video)
     */
    public function hasMedia(): bool
    {
        return !empty($this->media);
    }

    /**
     * Dapatkan URL media (gambar/video)
     */
    public function mediaUrl(): ?string
    {
        return $this->media ? asset('storage/'.$this->media) : null;
    }
}
