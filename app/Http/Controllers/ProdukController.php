<?php
// app/Http/Controllers/ProdukController.php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga'      => 'required|numeric|min:0',
            'Stok'       => 'required|integer|min:0',
            'Gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['NamaProduk', 'Harga', 'Stok']);

        if ($request->hasFile('Gambar')) {
            $data['Gambar'] = $request->file('Gambar')->store('produk', 'public');
        }

        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga'      => 'required|numeric|min:0',
            'Stok'       => 'required|integer|min:0',
            'Gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $data   = $request->only(['NamaProduk', 'Harga', 'Stok']);

        if ($request->hasFile('Gambar')) {
            // Hapus gambar lama kalau ada
            if ($produk->Gambar) {
                Storage::disk('public')->delete($produk->Gambar);
            }
            $data['Gambar'] = $request->file('Gambar')->store('produk', 'public');
        }

        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus detail penjualan yang terkait dulu
        \App\Models\DetailPenjualan::where('ProdukID', $id)->delete();

        // Hapus gambar dari storage kalau ada
        if ($produk->Gambar) {
            Storage::disk('public')->delete($produk->Gambar);
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success','Produk berhasil di hapus.');
    }
}
