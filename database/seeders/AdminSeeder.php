<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 superadmin
        User::factory()->superadmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
        ]);

        // Buat 1 admin
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        // Buat 5 user biasa
        User::factory(5)->create();
    }
}