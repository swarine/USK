@extends('layouts.pelanggan')

@section('title', 'Riwayat Pembelian')

@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:700;">
            Riwayat <span style="color:var(--pink);">Pembelian</span>
        </h1>
        <p style="color:var(--gray); font-size:0.875rem; margin-top:0.2rem;">Semua transaksi kamu tercatat di sini</p>
    </div>
</div>

@if($penjualan->count())

{{-- SUMMARY CARDS --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.5rem;">
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1.25rem 1.5rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink); font-size:1.2rem; flex-shrink:0;">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <div style="font-size:0.75rem; color:var(--gray);">Total Transaksi</div>
            <div style="font-size:1.4rem; font-weight:700;">{{ $penjualan->count() }}</div>
        </div>
    </div>
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1.25rem 1.5rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink); font-size:1.2rem; flex-shrink:0;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <div style="font-size:0.75rem; color:var(--gray);">Total Belanja</div>
            <div style="font-size:1.1rem; font-weight:700; color:var(--pink);">Rp {{ number_format($penjualan->sum('TotalHarga'), 0, ',', '.') }}</div>
        </div>
    </div>
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1.25rem 1.5rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink); font-size:1.2rem; flex-shrink:0;">
            <i class="fas fa-calendar"></i>
        </div>
        <div>
            <div style="font-size:0.75rem; color:var(--gray);">Transaksi Terakhir</div>
            <div style="font-size:0.9rem; font-weight:600;">{{ \Carbon\Carbon::parse($penjualan->first()->TanggalPenjualan)->format('d M Y') }}</div>
        </div>
    </div>
</div>

{{-- TRANSACTION LIST --}}
<div style="display:flex; flex-direction:column; gap:1rem;">
    @foreach($penjualan as $jual)
    <div class="card">
        <div class="card-header" style="flex-wrap:wrap; gap:0.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; border-radius:10px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink); font-size:0.85rem;">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <div style="font-weight:600; font-size:0.9rem;">Transaksi #{{ $jual->PenjualanID }}</div>
                    <div style="font-size:0.78rem; color:var(--gray);">{{ \Carbon\Carbon::parse($jual->TanggalPenjualan)->format('d F Y') }}</div>
                </div>
            </div>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                @if($jual->status === 'menunggu')
                    <span class="badge" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-clock"></i> Menunggu</span>
                @elseif($jual->status === 'diproses')
                    <span class="badge" style="background:#dbeafe; color:#2563eb;"><i class="fas fa-box"></i> Diproses</span>
                @elseif($jual->status === 'selesai')
                    <span class="badge" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-check-circle"></i> Selesai</span>
                @else
                    <span class="badge" style="background:#fee2e2; color:#dc2626;"><i class="fas fa-times-circle"></i> Ditolak</span>
                @endif
            </div>
    <span class="badge badge-pink" style="font-size:0.85rem; padding:0.3rem 0.8rem;">
        Rp {{ number_format($jual->TotalHarga, 0, ',', '.') }}
    </span>
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
                    @foreach($jual->detailPenjualan as $detail)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:0.6rem;">
                                @if($detail->produk->Gambar)
                                    <img src="{{ asset('storage/' . $detail->produk->Gambar) }}"
                                         style="width:36px; height:36px; border-radius:8px; object-fit:cover; border:1px solid var(--border);">
                                @else
                                    <div style="width:36px; height:36px; border-radius:8px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink-mid); font-size:1rem;">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                @endif
                                <strong>{{ $detail->produk->NamaProduk }}</strong>
                            </div>
                        </td>
                        <td>Rp {{ number_format($detail->produk->Harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->JumlahProduk }}</td>
                        <td style="color:var(--pink); font-weight:600;">Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

@else
<div class="card" style="text-align:center; padding:3.5rem 2rem;">
    <i class="fas fa-receipt" style="font-size:2.5rem; color:var(--pink-mid); display:block; margin-bottom:0.75rem;"></i>
    <p style="color:var(--gray); font-size:0.9rem;">Belum ada riwayat pembelian.</p>
    <a href="{{ route('pelanggan.home') }}" style="display:inline-block; margin-top:1rem; color:var(--pink); font-weight:600; font-size:0.875rem;">
        Mulai belanja →
    </a>
</div>
@endif

@endsection
