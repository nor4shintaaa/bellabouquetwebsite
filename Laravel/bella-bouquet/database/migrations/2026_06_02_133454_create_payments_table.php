<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->onDelete('cascade');

            $table->enum('method', ['transfer_bank', 'e_wallet', 'cod']);
            $table->string('proof_image')->nullable();

            $table->enum('status', [
                'belum_bayar',
                'menunggu_konfirmasi',
                'diterima',
                'ditolak',
            ])->default('belum_bayar');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};