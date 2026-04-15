<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            KategoriSeeder::class,
        ]);

        // Opsi: Buat 1 user admin untuk login testing
        User::create([
            'name' => 'Admin Peminjaman',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);
    }
}