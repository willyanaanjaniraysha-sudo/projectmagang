<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Aspirasi extends Model
{
    use LogsActivity; // Mengaktifkan pencatatan log otomatis

    protected $fillable = ['user_id', 'judul', 'deskripsi'];

    // Konfigurasi apa saja yang disimpan saat data dimanipulasi/dihapus
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Mencatat seluruh kolom fillable (termasuk judul & deskripsi)
            ->logOnlyDirty() 
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Aspirasi telah {$eventName}");
    }
}
