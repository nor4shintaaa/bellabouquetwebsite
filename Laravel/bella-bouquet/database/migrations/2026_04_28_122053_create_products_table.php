<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // TUGAS 4 POIN 2: Menerapkan kolom unique, enum, integer, nullable, dan boolean
            $table->string('kode_produk')->unique();
            $table->string('nama');
            $table->enum('kategori', ['Flower', 'Snack', 'Money', 'Doll']); 
            $table->integer('stok');
            $table->decimal('harga', 12, 2); 
            $table->string('status')->default('Tersedia'); 
            $table->string('gambar_url')->nullable(); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};