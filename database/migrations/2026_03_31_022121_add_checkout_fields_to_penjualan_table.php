<?php
// Isi migration add_checkout_fields_to_penjualan_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->string('nama_penerima')->nullable()->after('status');
            $table->string('nomor_telepon')->nullable()->after('nama_penerima');
            $table->text('alamat')->nullable()->after('nomor_telepon');
            $table->enum('metode_pembayaran', ['cod', 'qris'])->nullable()->after('alamat');
        });
    }

    public function down(): void {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['nama_penerima', 'nomor_telepon', 'alamat', 'metode_pembayaran']);
        });
    }
};
