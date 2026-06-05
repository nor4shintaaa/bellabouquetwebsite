<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Bella',
                'role' => 'admin',
                'password' => bcrypt('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@gmail.com'],
            [
                'name' => 'Pelanggan Bella',
                'role' => 'pelanggan',
                'password' => bcrypt('pelanggan123'),
            ]
        );

        if (class_exists(ProductSeeder::class)) {
            $this->call([
                ProductSeeder::class,
            ]);
        }
    }
}