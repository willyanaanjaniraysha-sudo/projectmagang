<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use SoftDeletes, LogsActivity;

     // Konfigurasi apa saja yang disimpan saat data dimanipulasi/dihapus
    
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Mencatat seluruh kolom fillable (termasuk judul & deskripsi)
            ->logOnlyDirty() 
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Pengaduan telah {$eventName}");
    }
}