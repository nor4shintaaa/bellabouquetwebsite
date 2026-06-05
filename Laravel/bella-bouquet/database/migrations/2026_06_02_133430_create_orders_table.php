<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            // Snapshot produk saat dipesan
            $table->string('product_name');
            $table->string('product_category')->nullable();
            $table->string('product_image')->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);

            $table->string('phone');
            $table->enum('delivery_method', ['ambil', 'kirim'])->default('ambil');
            $table->date('order_date')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();

            $table->enum('status', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi',
                'diproses',
                'siap_diambil',
                'selesai',
                'ditolak',
                'dibatalkan',
            ])->default('menunggu_pembayaran');

            $table->timestamp('stock_restored_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};