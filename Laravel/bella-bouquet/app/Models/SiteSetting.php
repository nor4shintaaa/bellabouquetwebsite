<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'about_description',
        'vision',
        'mission',
        'banner_path',
        'whatsapp',
        'email',
        'address',
        'instagram',
        'tiktok',
        'footer_text',
    ];

    public static function getSetting(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'about_description' => 'Bella Bouquet adalah layanan pemesanan bouquet yang membantu pelanggan memilih hadiah cantik dengan proses pemesanan yang mudah dan praktis.',
                'vision' => 'Menjadi florist pilihan utama yang menghadirkan kebahagiaan di setiap momen berharga.',
                'mission' => 'Menyediakan bouquet cantik, rapi, berkualitas, dan mudah dipesan melalui website.',
                'whatsapp' => '08xxxxxxxxxx',
                'email' => 'bellabouquet@gmail.com',
                'address' => 'Jember, Jawa Timur',
                'instagram' => '@bellabouquet',
                'tiktok' => '@bellabouquet.official',
                'footer_text' => 'Bella Bouquet menyediakan berbagai pilihan bouquet cantik untuk momen spesial.',
            ]
        );
    }
}