<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUD Produk
Route::get('/produk', [DashboardController::class, 'produk'])->name('produk');
Route::get('/produk/tambah', [DashboardController::class, 'create'])->name('produk.create');
Route::post('/produk/simpan', [DashboardController::class, 'store'])->name('produk.store');
Route::get('/produk/edit/{id}', [DashboardController::class, 'edit'])->name('produk.edit');
Route::put('/produk/update/{id}', [DashboardController::class, 'update'])->name('produk.update');
Route::delete('/produk/hapus/{id}', [DashboardController::class, 'destroy'])->name('produk.destroy');
Route::get('/tentang', [DashboardController::class, 'tentang'])->name('tentang');
Route::get('/hitung/{a}/{b}', fn($a, $b) => $a + $b);
