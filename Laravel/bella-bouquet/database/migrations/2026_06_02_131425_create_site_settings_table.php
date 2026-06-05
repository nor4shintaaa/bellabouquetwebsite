<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Tentang
            $table->text('about_description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('banner_path')->nullable();

            // Kontak
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();

            // Footer
            $table->string('footer_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};