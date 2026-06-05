<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeReceiverIdNullableInMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::table('messages', function (Blueprint $table) {
                $table->bigInteger('receiver_id')->unsigned()->nullable()->change();
            });
            return;
        }

        Schema::table('messages', function (Blueprint $table) {
            // 1. Hapus kunci tamunya dulu (wajib pakai nama aslinya)
            $table->dropForeign('messages_receiver_id_foreign');

            // 2. Ubah kolomnya jadi boleh kosong (nullable)
            $table->bigInteger('receiver_id')->unsigned()->nullable()->change();

            // 3. Pasang lagi kunci tamunya (agar tetap terhubung ke tabel users)
            $table->foreign('receiver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::table('messages', function (Blueprint $table) {
                $table->bigInteger('receiver_id')->unsigned()->nullable(false)->change();
            });
            return;
        }

        Schema::table('messages', function (Blueprint $table) {
            // --- Logika Down (Balikin ke kondisi awal) ---
            // 1. Hapus kunci tamunya dulu
            $table->dropForeign('messages_receiver_id_foreign');

            // 2. Ubah kolomnya jadi wajib diisi (tidak boleh nullable)
            // Catatan: Ini akan gagal jika sudah ada pesan grup (NULL) di database.
            $table->bigInteger('receiver_id')->unsigned()->nullable(false)->change();

            // 3. Pasang lagi kunci tamunya (references id on users)
            $table->foreign('receiver_id')->references('id')->on('users');
        });
    }
}