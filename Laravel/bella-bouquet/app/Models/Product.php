<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // TUGAS 4 POIN 4: Isi $fillable
    protected $fillable = [
        'kode_produk', 'nama', 'kategori', 'stok', 'harga', 'status', 'gambar_url', 'is_active'
    ];

    // TUGAS 4 POIN 4: Tambahkan $casts
    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'decimal:2', // Format decimal
        'stok' => 'integer'
    ];

    // TUGAS 4 POIN 4: Buat local scope (scopeAktif)
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // TUGAS 4 POIN 8: Relasi belongsToMany (Banyak-ke-Banyak)
    // Produk memiliki banyak Tag, setara relasi Mahasiswa <-> Mata Kuliah
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
}