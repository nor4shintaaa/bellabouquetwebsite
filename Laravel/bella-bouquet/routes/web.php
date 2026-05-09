<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

// TUGAS 6: Amankan semua route dengan middleware auth
// Tambahkan route ini di dalam middleware auth
Route::middleware(['auth'])->group(function () {
    // Ganti redirect '/' menjadi ke splash screen
    Route::get('/', function () {
        return view('welcome-splash');
    });

    Route::get('/welcome', function () {
        return view('welcome-splash');
    })->name('welcome.splash');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ... route lainnya ...

    // Route Resource untuk Produk (Aktivitas 5)
    Route::resource('produk', ProductController::class);

    // Halaman Statis (Aktivitas 3)
    Route::view('/tentang', 'tentang')->name('tentang');
    Route::view('/kontak', 'kontak')->name('kontak');
    Route::view('/profil', 'profil')->name('profil');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Autentikasi bawaan Breeze
require __DIR__.'/auth.php';