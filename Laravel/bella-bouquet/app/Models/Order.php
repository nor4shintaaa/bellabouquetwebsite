<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'user_id',
        'product_id',
        'product_name',
        'product_category',
        'product_image',
        'quantity',
        'unit_price',
        'total_price',
        'phone',
        'delivery_method',
        'order_date',
        'address',
        'notes',
        'status',
        'stock_restored_at',
    ];

    protected $casts = [
        'order_date' => 'date',
        'stock_restored_at' => 'datetime',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi Admin',
            'diproses' => 'Diproses',
            'siap_diambil' => 'Siap Diambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'dibatalkan' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'warning',
            'menunggu_konfirmasi' => 'info',
            'diproses' => 'primary',
            'siap_diambil' => 'success',
            'selesai' => 'success',
            'ditolak' => 'danger',
            'dibatalkan' => 'danger',
            default => 'secondary',
        };
    }

    public function canUploadPayment(): bool
    {
        return in_array($this->status, ['menunggu_pembayaran'])
            || optional($this->payment)->status === 'ditolak';
    }

    public function isActiveOrder(): bool
    {
        return in_array($this->status, [
            'menunggu_pembayaran',
            'menunggu_konfirmasi',
            'diproses',
            'siap_diambil',
        ]);
    }
}