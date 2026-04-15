<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('barang', BarangController::class);
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');