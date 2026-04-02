<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kita hapus dulu semua data lama yang bikin error duplicate
        DB::table('pelanggan')->truncate();

        // 2. Sekarang baru kita tambahkan kolomnya dengan aman
        Schema::table('pelanggan', function (Blueprint $table) {
            if (!Schema::hasColumn('pelanggan', 'EmailPelanggan')) {
                $table->string('EmailPelanggan')->unique()->after('NamaPelanggan');
            }
            if (!Schema::hasColumn('pelanggan', 'password')) {
                $table->string('password')->after('EmailPelanggan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['EmailPelanggan', 'password']);
        });
    }
};