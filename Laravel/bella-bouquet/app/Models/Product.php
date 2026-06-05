<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->gambar_url) {
            return null;
        }

        if (Str::startsWith($this->gambar_url, ['http://', 'https://'])) {
            return $this->gambar_url;
        }

        return Storage::url($this->gambar_url);
    }

    public function updateStockStatus(): void
    {
        $this->update([
            'status' => $this->stok < 5 ? 'Menipis' : 'Tersedia',
        ]);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}