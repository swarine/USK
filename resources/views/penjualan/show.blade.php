@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Detail <span>Transaksi</span></h1>
    <a href="{{ route('penjualan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">

    {{-- INFO TRANSAKSI --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-file-invoice" style="color:var(--pink); margin-right:6px;"></i>
                Transaksi #{{ $penjualan->PenjualanID }}
            </h2>
        </div>
        <div class="card-body">
            <table style="width:100%;">
                <tr>
                    <td style="color:var(--gray); padding:0.45rem 0; font-size:0.85rem; width:130px;">Pelanggan</td>
                    <td style="font-weight:600; font-size:0.875rem;">{{ $penjualan->pelanggan->NamaPelanggan }}</td>
                </tr>
                <tr>
                    <td style="color:var(--gray); padding:0.45rem 0; font-size:0.85rem;">Tanggal</td>
                    <td style="font-size:0.875rem;">{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="color:var(--gray); padding:0.45rem 0; font-size:0.85rem;">Total</td>
                    <td>
                        <span class="badge badge-pink" style="font-size:0.95rem; padding:0.3rem 0.8rem;">
                            Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- DETAIL PRODUK --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-box" style="color:var(--pink); margin-right:6px;"></i> Item Pembelian</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detailPenjualan as $detail)
                    <tr>
                        <td><strong>{{ $detail->produk->NamaProduk }}</strong></td>
                        <td>Rp {{ number_format($detail->produk->Harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->JumlahProduk }}</td>
                        <td>Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem;">Total</td>
                        <td>
                            <span class="badge badge-pink" style="font-size:0.95rem; padding:0.3rem 0.8rem;">
                                Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @if($penjualan->nama_penerima)
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem;">Penerima</td>
                        <td style="font-size:0.875rem;">{{ $penjualan->nama_penerima }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem;">Telepon</td>
                        <td style="font-size:0.875rem;">{{ $penjualan->nomor_telepon }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem;">Alamat</td>
                        <td style="font-size:0.875rem;">{{ $penjualan->alamat }}</td>
                    </tr>
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem;">Pembayaran</td>
                        <td>
                            @if($penjualan->metode_pembayaran === 'qris')
                                <span class="badge" style="background:#ede9fe; color:#7c3aed;"><i class="fas fa-qrcode"></i> QRIS</span>
                            @else
                                <span class="badge" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-money-bill-wave"></i> COD</span>
                            @endif
                        </td>
                    </tr>
                    @if($penjualan->bukti_pembayaran)
                    <tr>
                        <td style="color:var(--gray); padding:0.45rem 0 0.45rem 1rem; font-size:0.85rem; vertical-align:top;">Bukti Transfer</td>
                        <td style="padding:0.45rem 0;">
                            <a href="{{ asset('storage/' . $penjualan->bukti_pembayaran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $penjualan->bukti_pembayaran) }}"
                                    style="width:160px; border-radius:10px; border:2px solid var(--border); cursor:pointer; transition:transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </a>
                            <div style="font-size:0.72rem; color:var(--gray); margin-top:0.3rem;">Klik untuk lihat full</div>
                        </td>
                    </tr>
                    @endif
                    @endif
                </tfoot>
            </table>
        </div>
    </div>

</div>

@endsection
