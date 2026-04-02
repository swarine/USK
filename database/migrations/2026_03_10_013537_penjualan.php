<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
    $table->increments('PenjualanID');
    $table->date('TanggalPenjualan');
    $table->decimal('TotalHarga', 10, 2);
    $table->unsignedInteger('PelangganID');
    $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
    $table->string('nama_penerima')->nullable();
    $table->string('nomor_telepon')->nullable();
    $table->text('alamat')->nullable();
    $table->string('metode_pembayaran')->nullable();
    $table->string('bukti_pembayaran')->nullable();
    $table->timestamps();

    $table->foreign('PelangganID')->references('PelangganID')->on('pelanggan')->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};