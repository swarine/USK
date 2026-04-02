<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
    $table->increments('ProdukID');
    $table->string('NamaProduk');
    $table->decimal('Harga', 10, 2);
    $table->integer('Stok'); // Pastikan Stok ada di sini
    $table->string('Gambar')->nullable(); // Masukkan Gambar di sini
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};