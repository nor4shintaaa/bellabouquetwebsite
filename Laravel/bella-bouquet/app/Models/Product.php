<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama',
        'kategori',
        'stok',
        'harga',
        'status',
        'gambar_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'decimal:2',
        'stok' => 'integer'
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
}