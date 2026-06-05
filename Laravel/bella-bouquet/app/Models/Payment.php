<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'proof_image',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'cod' => 'COD',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'belum_bayar' => 'Belum Bayar',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }
}