<?php
// app/Models/Penjualan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';

    protected $fillable = ['TanggalPenjualan', 'TotalHarga', 'PelangganID', 'status', 'nama_penerima', 'nomor_telepon', 'alamat', 'metode_pembayaran', 'bukti_pembayaran'];

    // Penjualan milik satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }

    // Penjualan punya banyak detail
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }
}