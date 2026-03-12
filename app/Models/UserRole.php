<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles'; // Nama tabel di pgAdmin
    protected $fillable = ['user_id', 'role_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

