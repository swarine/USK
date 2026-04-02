<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cartData = json_decode($request->cart_data, true);

        if (!$cartData || count($cartData) === 0) {
            return redirect()->route('pelanggan.home')->with('error', 'Keranjang kosong!');
        }

        $items = [];
        $total = 0;

        foreach ($cartData as $item) {
            $produk = Produk::find($item['id']);
            if ($produk) {
                $subtotal = $produk->Harga * $item['qty'];
                $total   += $subtotal;
                $items[]  = [
                    'id'       => $produk->ProdukID,
                    'nama'     => $produk->NamaProduk,
                    'harga'    => $produk->Harga,
                    'gambar'   => $produk->Gambar,
                    'qty'      => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        $cartData = json_encode($cartData);
        return view('pelanggan.checkout', compact('items', 'total', 'cartData'));
    }

    public function process(Request $request)
    {
        $rules = [
            'cart_data'         => 'required',
            'nama_penerima'     => 'required|string',
            'nomor_telepon'     => 'required|string',
            'alamat'            => 'required|string',
            'metode_pembayaran' => 'required|in:cod,qris',
        ];

        if ($request->metode_pembayaran === 'qris') {
            $rules['bukti_pembayaran'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        $request->validate($rules, [
            'metode_pembayaran.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'bukti_pembayaran.required'  => 'Upload bukti pembayaran QRIS terlebih dahulu.',
        ]);

        $cartData    = json_decode($request->cart_data, true);
        $pelangganId = Session::get('pelanggan_id');

        if (!$cartData || count($cartData) === 0) {
            return redirect()->route('pelanggan.home')->with('error', 'Keranjang kosong!');
        }

        // Upload bukti
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti', 'public');
        }

        DB::transaction(function () use ($cartData, $pelangganId, $request, $buktiPath) {
            $total   = 0;
            $details = [];

            foreach ($cartData as $item) {
                $produk = Produk::findOrFail($item['id']);

                if ($produk->Stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->NamaProduk} tidak cukup!");
                }

                $subtotal  = $produk->Harga * $item['qty'];
                $total    += $subtotal;
                $details[] = [
                    'ProdukID'     => $produk->ProdukID,
                    'JumlahProduk' => $item['qty'],
                    'Subtotal'     => $subtotal,
                ];

                $produk->decrement('Stok', $item['qty']);
            }

            $penjualan = Penjualan::create([
                'TanggalPenjualan'  => now()->toDateString(),
                'TotalHarga'        => $total,
                'PelangganID'       => $pelangganId,
                'status'            => 'menunggu',
                'nama_penerima'     => $request->nama_penerima,
                'nomor_telepon'     => $request->nomor_telepon,
                'alamat'            => $request->alamat,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_pembayaran'  => $buktiPath,
            ]);

            foreach ($details as $d) {
                $d['PenjualanID'] = $penjualan->PenjualanID;
                DetailPenjualan::create($d);
            }
        });

        return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil dibuat! 🎀');
    }
}
