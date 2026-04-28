<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/tentang', [DashboardController::class, 'tentang'])->name('tentang');

Route::get('/hitung/{a}/{b}', fn($a, $b) => $a + $b);
