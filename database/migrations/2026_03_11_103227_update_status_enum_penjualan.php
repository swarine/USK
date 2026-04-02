<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Kita gunakan change() untuk mengubah struktur yang sudah ada
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])
                  ->default('menunggu')
                  ->change();
        });
    }

    public function down(): void 
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])
                  ->default('menunggu')
                  ->change();
        });
    }
};