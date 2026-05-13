<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable; // 1. Tambahkan ini
use Illuminate\Database\Eloquent\Builder;  // 2. Tambahkan ini

class Message extends Model
{
    // 3. Tambahkan Prunable di sini
    use HasFactory, Prunable; 

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    // 4. Tambahkan fungsi ini untuk menentukan batas waktu penghapusan
    public function prunable(): Builder
    {
        // Contoh: Hapus otomatis pesan yang umurnya lebih dari 30 hari.
        // Anda bisa mengubah "subDays(30)" menjadi "subDays(7)" untuk 1 minggu,
        // atau "subHours(24)" untuk 1 hari (24 jam).
        return static::where('created_at', '<=', now()->subDays(30));
    }

    // (Opsional) Relasi ke User pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // (Opsional) Relasi ke User penerima
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}