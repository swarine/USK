<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detailpenjualan', function (Blueprint $table) {
            $table->increments('DetailID');
            $table->unsignedInteger('PenjualanID');
            $table->unsignedInteger('ProdukID');
            $table->integer('JumlahProduk')->default(1);
            $table->decimal('Subtotal', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('PenjualanID')
                  ->references('PenjualanID')
                  ->on('penjualan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ProdukID')
                  ->references('ProdukID')
                  ->on('produk')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->index('PenjualanID', 'idx_detail_penjualan');
            $table->index('ProdukID', 'idx_detail_produk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detailpenjualan');
    }
};