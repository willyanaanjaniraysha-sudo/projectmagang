<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id', 'role', 'action', 'resource', 'ip_address', 'device_info', 'description'
    ];

    // Relasi balik ke model User, agar di halaman Admin kita bisa panggil nama usernya
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
