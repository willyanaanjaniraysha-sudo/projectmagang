<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}