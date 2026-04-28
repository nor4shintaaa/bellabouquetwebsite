<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void

    { 
        $products = [
            [
                'kode_produk' => 'SNK-001',
                'nama' => 'Snack Tower Gold',
                'kategori' => 'Snack',
                'stok' => 8,
                'harga' => 85000,
                'status' => 'Tersedia',
                'gambar_url' => 'https://i.pinimg.com/originals/cc/53/b2/cc53b27699a7d89303f00dbf77ab066a.jpg'
            ],
            [
                'kode_produk' => 'MNY-001',
                'nama' => 'Money Rose 100k',
                'kategori' => 'Money',
                'stok' => 3,
                'harga' => 200000,
                'status' => 'Menipis',
                'gambar_url' => 'https://athaya.co.id/storage/2024/01/uruha-buket-uang-dari-athaya-dengan-rangkaian-bunga-mawar-carnetion-baby-breath.webp'
            ],
            [
                'kode_produk' => 'DOL-001',
                'nama' => 'Graduation Bear',
                'kategori' => 'Doll',
                'stok' => 12,
                'harga' => 95000,
                'status' => 'Tersedia',
                'gambar_url' => 'https://img.lazcdn.com/g/ff/kf/S97a881dcdc1a44e1821e4309f5c1b055y.jpg_720x720q80.jpg'
            ],
            [
                'kode_produk' => 'FLW-002',
                'nama' => 'pink tulip box',
                'kategori' => 'Flower',
                'stok' => 2,
                'harga' => 150000,
                'status' => 'Menipis',
                'gambar_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVxcepSW4KgfKXcgYYV7O3HrhrAO4R3RCqHA&s'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}