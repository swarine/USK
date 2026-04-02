<?php
// app/Http/Controllers/PelangganHomeController.php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Session;

class PelangganHomeController extends Controller
{
    // Halaman toko - lihat semua produk
    public function home()
    {
        $produk = Produk::all();
        return view('pelanggan.home', compact('produk'));
    }

    // Halaman riwayat pembelian pelanggan yg login
    public function riwayat()
    {
        $pelangganId = Session::get('pelanggan_id');

        $penjualan = Penjualan::with('detailPenjualan.produk')
                        ->where('PelangganID', $pelangganId)
                        ->latest()
                        ->get();

        $totalBelanja  = $penjualan->where('status', 'selesai')->sum('TotalHarga');
        $totalTransaksi = $penjualan->where('status', 'selesai')->count();

        return view('pelanggan.riwayat', compact('penjualan', 'totalBelanja', 'totalTransaksi'));
    }
}
