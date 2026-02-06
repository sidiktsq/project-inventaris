<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiController;


Route::get('/', function () {
    return view('welcome');
});

// Auth routes (Register dimatikan sesuai kodingan Anda)
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Bungkus semua yang butuh login di sini
Route::middleware('auth')->group(function () {

    // Dashboard routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('users', UserController::class);
    });

    // Pindahkan ke sini agar Auth::user() selalu ada (tidak null)

// routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('lokasi', App\Http\Controllers\LokasiController::class);
    Route::resource('barang', App\Http\Controllers\BarangController::class);
       Route::get('peminjaman/export/excel', [App\Http\Controllers\PeminjamanController::class, 'exportExcel'])->name('peminjaman.export.excel');
           Route::get('peminjaman/export/pdf', [App\Http\Controllers\PeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
    Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class);
    Route::post('/peminjaman/{id}/kembalikan', [App\Http\Controllers\PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');




});


