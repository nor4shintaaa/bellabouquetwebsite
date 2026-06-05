<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\SiteSettingController;

/*
|--------------------------------------------------------------------------
| Public Customer Page
|--------------------------------------------------------------------------
| Halaman pertama langsung menampilkan dashboard/beranda pelanggan.
| Guest boleh lihat beranda, produk, detail produk, tentang, kontak.
| Tetapi guest tidak boleh pesan, status, riwayat, profil.
*/

Route::get('/', [PelangganController::class, 'index'])->name('landing');

Route::prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::get('/produk', [PelangganController::class, 'produk'])->name('produk');
        Route::get('/produk/{product}', [PelangganController::class, 'showProduk'])->name('produk.show');
    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Hanya admin yang boleh masuk dashboard admin dan mengelola data.
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/reset-kunjungan', [DashboardController::class, 'resetKunjungan'])
        ->name('dashboard.resetKunjungan');

    Route::post('/produk/live-search', [ProductController::class, 'liveSearch'])
        ->name('produk.liveSearch');

    Route::resource('produk', ProductController::class);

    Route::get('/preferensi', [PreferenceController::class, 'index'])->name('preferensi.index');
    Route::post('/preferensi/simpan', [PreferenceController::class, 'save'])->name('preferensi.save');

    Route::get('/tentang', [SiteSettingController::class, 'editAbout'])->name('tentang');
    Route::put('/tentang', [SiteSettingController::class, 'updateAbout'])->name('tentang.update');

    Route::get('/kontak', [SiteSettingController::class, 'editContact'])->name('kontak');
    Route::put('/kontak', [SiteSettingController::class, 'updateContact'])->name('kontak.update');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/pesanan', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/pesanan/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('/admin/pesanan/{order}/payment/confirm', [AdminOrderController::class, 'confirmPayment'])->name('admin.orders.confirmPayment');
    Route::patch('/admin/pesanan/{order}/payment/reject', [AdminOrderController::class, 'rejectPayment'])->name('admin.orders.rejectPayment');
});


/*
|--------------------------------------------------------------------------
| Customer Protected Routes
|--------------------------------------------------------------------------
| Pelanggan wajib login untuk pesan, bayar, lihat status, riwayat, dan profil.
*/

Route::middleware(['auth', 'role:pelanggan'])
    ->prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {
        Route::get('/produk/{product}/pesan', [PelangganController::class, 'pesan'])->name('pesan');
        Route::post('/produk/{product}/pesan', [PelangganController::class, 'storePesan'])->name('pesan.store');

        Route::get('/status', [PelangganController::class, 'status'])->name('status');
        Route::get('/riwayat', [PelangganController::class, 'riwayat'])->name('riwayat');

        Route::get('/pesanan/{order}', [PelangganController::class, 'detailPesanan'])->name('pesanan.show');
        Route::patch('/pesanan/{order}/batal', [PelangganController::class, 'batalPesanan'])->name('pesanan.batal');

        Route::get('/pesanan/{order}/bayar', [PelangganController::class, 'bayar'])->name('bayar');
        Route::post('/pesanan/{order}/bayar', [PelangganController::class, 'storeBayar'])->name('bayar.store');

        Route::get('/profil', [PelangganController::class, 'profil'])->name('profil');
    });


require __DIR__.'/auth.php';