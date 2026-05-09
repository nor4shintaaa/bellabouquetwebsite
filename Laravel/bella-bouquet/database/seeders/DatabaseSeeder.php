<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin untuk Login (Tugas Aktivitas 6)
        // Cek dulu agar tidak double saat running seeder
        if (User::where('email', 'admin@gmail.com')->count() == 0) {
            User::create([
                'name' => 'Admin Bella',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
            ]);
        }

        // 2. Memanggil seeder produk jika file ProductSeeder sudah ada
        // Jika ProductSeeder belum ada, bagian ini bisa di-comment dulu
        if (class_exists(ProductSeeder::class)) {
            $this->call([
                ProductSeeder::class,
            ]);
        }
    }
}