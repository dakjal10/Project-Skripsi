<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Pengaduan extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'kategori',
        'bukti',
        'status',
        'balasan',
        'rating',
        'ulasan',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'pengaduan_likes', 'pengaduan_id', 'user_id')->withTimestamps();
    }
}
