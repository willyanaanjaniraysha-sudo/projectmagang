<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('user_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel users
        $table->string('role')->nullable();
        $table->string('action'); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE
        $table->string('resource'); // Nama tabel/fitur yang diakses (misal: 'products', 'users')
        $table->string('ip_address')->nullable();
        $table->string('device_info')->nullable(); // Menampung info dari Jenssegers/Agent
        $table->text('description')->nullable(); // Penjelasan singkat aktivitas
        $table->timestamps(); // Otomatis membuat created_at dan updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
