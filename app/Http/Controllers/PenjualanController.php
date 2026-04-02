<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPenjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('pelanggan')->latest()->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks    = Produk::where('Stok', '>', 0)->get();
        return view('penjualan.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'PelangganID'      => 'required|exists:pelanggan,PelangganID',
            'TanggalPenjualan' => 'required|date',
            'produk'           => 'required|array|min:1',
            'produk.*.id'      => 'required|exists:produk,ProdukID',
            'produk.*.jumlah'  => 'required|integer|min:1',
        ]);

        $total = 0;
        $items = [];

        foreach ($request->produk as $item) {
            $produk   = Produk::findOrFail($item['id']);
            $subtotal = $produk->Harga * $item['jumlah'];
            $total   += $subtotal;
            $items[]  = [
                'ProdukID'     => $produk->ProdukID,
                'JumlahProduk' => $item['jumlah'],
                'Subtotal'     => $subtotal,
            ];
            $produk->decrement('Stok', $item['jumlah']);
        }

        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'TotalHarga'       => $total,
            'PelangganID'      => $request->PelangganID,
            'status'           => 'menunggu',
        ]);

        foreach ($items as $item) {
            $item['PenjualanID'] = $penjualan->PenjualanID;
            DetailPenjualan::create($item);
        }

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('pelanggan', 'detailPenjualan.produk')->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        DetailPenjualan::where('PenjualanID', $id)->delete();
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
{
    $penjualan = Penjualan::with('detailPenjualan.produk')->findOrFail($id);

    // Kembalikan stok jika status diubah ke "ditolak"
    if ($request->status === 'ditolak' && $penjualan->status !== 'ditolak') {
        foreach ($penjualan->detailPenjualan as $detail) {
            $detail->produk->increment('Stok', $detail->JumlahProduk);
        }
    }

    $penjualan->update(['status' => $request->status]);
    return redirect()->route('penjualan.index')->with('success', 'Status pesanan berhasil diperbarui!');
}
}