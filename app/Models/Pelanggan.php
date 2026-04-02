<?php
// app/Models/Pelanggan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID';

    protected $fillable = ['NamaPelanggan','EmailPelanggan', 'Alamat', 'NomorTelepon', 'password'];

    // Satu pelanggan bisa punya banyak penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'PelangganID', 'PelangganID');
    }
}