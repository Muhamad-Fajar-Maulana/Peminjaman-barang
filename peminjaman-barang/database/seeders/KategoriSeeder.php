<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Kategori::create(['nama_kategori' => 'Elektronik', 'deskripsi' => 'Alat-alat elektronik']);
        Kategori::create(['nama_kategori' => 'Alat Tulis', 'deskripsi' => 'Kebutuhan kantor dan tulis menulis']);
        Kategori::create(['nama_kategori' => 'Furniture', 'deskripsi' => 'Meja, kursi, dan lemari']);
    }
}