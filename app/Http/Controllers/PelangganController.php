<?php
// app/Http/Controllers/PelangganController.php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Tampilkan semua pelanggan
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('pelanggan.create');
    }

    public function home()
{
    // Mengambil semua data produk dari database
    $produk = \App\Models\Produk::all(); 

    // Kirim data tersebut ke view dengan compact('produk')
    return view('home', compact('produk'));
}
    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'EmailPelanggan' => 'required|email|unique:pelanggan,EmailPelanggan',
            'Alamat'        => 'nullable|string',
            'NomorTelepon'  => 'nullable|string|max:15',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    // Form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Update pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'EmailPelanggan' => 'required|email|unique:pelanggan,EmailPelanggan,'.$id.',PelangganID',
            'Alamat'        => 'nullable|string',
            'NomorTelepon'  => 'nullable|string|max:15',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diupdate!');
    }

    // Hapus pelanggan
    public function destroy($id)
{
    $pelanggan = \App\Models\Pelanggan::findOrFail($id);

    // Hapus semua detail penjualan dulu
    foreach ($pelanggan->penjualan as $jual) {
        \App\Models\DetailPenjualan::where('PenjualanID', $jual->PenjualanID)->delete();
    }

    // Hapus semua penjualan
    $pelanggan->penjualan()->delete();

    // Hapus pelanggan
    $pelanggan->delete();

    return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
}
}