<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Memastikan 1 user hanya bisa like 1 laporan sebanyak 1 kali
            $table->unique(['pengaduan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_likes');
    }
};
