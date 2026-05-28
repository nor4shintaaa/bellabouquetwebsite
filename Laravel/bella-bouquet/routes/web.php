<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PreferenceController;

// Semua route admin wajib login
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('welcome-splash');
    });

    Route::get('/welcome', function () {
        return view('welcome-splash');
    })->name('welcome.splash');

    // Dashboard + session kunjungan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/reset-kunjungan', [DashboardController::class, 'resetKunjungan'])->name('dashboard.resetKunjungan');

    // Live Search Produk AJAX
    Route::post('/produk/live-search', [ProductController::class, 'liveSearch'])->name('produk.liveSearch');

    // Halaman Preferensi
    Route::get('/preferensi', [PreferenceController::class, 'index'])->name('preferensi.index');
    Route::post('/preferensi/simpan', [PreferenceController::class, 'save'])->name('preferensi.save');

    // Route Resource untuk Produk
    Route::resource('produk', ProductController::class);

    // Halaman Statis
    Route::view('/tentang', 'tentang')->name('tentang');
    Route::view('/kontak', 'kontak')->name('kontak');

    // Halaman Profil Custom Admin
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');

    // Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //show.blade.php
    
});

// Route Autentikasi bawaan Breeze
require __DIR__.'/auth.php';