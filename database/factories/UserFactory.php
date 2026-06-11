<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     */
    public function definition(): array
{
    // 1. Buat nama Indonesia acak secara otomatis
    $name = fake()->name();
    
    // 2. Buat email otomatis yang sinkron dengan nama di atas
    $email = strtolower(str_replace([' ', '.', ','], '', $name)) . '@gmail.com';

    return [
        'name' => $name,
        'email' => $email,
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
        
        // 🛠️ KUNCI PERBAIKAN: Mengacak otomatis 3 pilihan role untuk setiap data
        'role' => fake()->randomElement(['super admin', 'admin', 'user']),
    ];
}


    /**
     * State khusus jika kamu ingin membuat user dengan role 'admin' secara pasti.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
