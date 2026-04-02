<?php
// Isi file migration add_status_to_penjualan_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::table('penjualan', function (Blueprint $table) {
        // Tambahkan semua kolom yang ada di $fillable Model tapi belum ada di DB
        if (!Schema::hasColumn('penjualan', 'status')) {
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu')->after('PelangganID');
        }
        if (!Schema::hasColumn('penjualan', 'nama_penerima')) {
            $table->string('nama_penerima')->nullable()->after('status');
        }
        if (!Schema::hasColumn('penjualan', 'nomor_telepon')) {
            $table->string('nomor_telepon', 20)->nullable()->after('nama_penerima');
        }
        if (!Schema::hasColumn('penjualan', 'alamat')) {
            $table->text('alamat')->nullable()->after('nomor_telepon');
        }
        if (!Schema::hasColumn('penjualan', 'metode_pembayaran')) {
            $table->string('metode_pembayaran')->nullable()->after('alamat');
        }
        if (!Schema::hasColumn('penjualan', 'bukti_pembayaran')) {
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
        }
    });
}

};
