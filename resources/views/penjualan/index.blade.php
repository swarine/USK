@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:700;">
            Data <span style="color:var(--pink);">Penjualan</span>
        </h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

{{-- SUMMARY CARDS --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; gap:0.85rem;">
        <div style="width:40px; height:40px; border-radius:10px; background:#fef9c3; display:flex; align-items:center; justify-content:center; color:#ca8a04; font-size:1rem; flex-shrink:0;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div style="font-size:0.73rem; color:var(--gray);">Menunggu</div>
            <div style="font-size:1.3rem; font-weight:700;">{{ $penjualan->where('status','menunggu')->count() }}</div>
        </div>
    </div>
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; gap:0.85rem;">
        <div style="width:40px; height:40px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center; color:#2563eb; font-size:1rem; flex-shrink:0;">
            <i class="fas fa-box"></i>
        </div>
        <div>
            <div style="font-size:0.73rem; color:var(--gray);">Diproses</div>
            <div style="font-size:1.3rem; font-weight:700;">{{ $penjualan->where('status','diproses')->count() }}</div>
        </div>
    </div>
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; gap:0.85rem;">
        <div style="width:40px; height:40px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; color:#16a34a; font-size:1rem; flex-shrink:0;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div style="font-size:0.73rem; color:var(--gray);">Selesai</div>
            <div style="font-size:1.3rem; font-weight:700;">{{ $penjualan->where('status','selesai')->count() }}</div>
        </div>
    </div>
    <div style="background:var(--white); border-radius:16px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; gap:0.85rem;">
        <div style="width:40px; height:40px; border-radius:10px; background:#fee2e2; display:flex; align-items:center; justify-content:center; color:#dc2626; font-size:1rem; flex-shrink:0;">
            <i class="fas fa-times-circle"></i>
        </div>
        <div>
            <div style="font-size:0.73rem; color:var(--gray);">Ditolak</div>
            <div style="font-size:1.3rem; font-weight:700;">{{ $penjualan->where('status','ditolak')->count() }}</div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualan as $i => $jual)
                <tr>
                    <td style="color:var(--gray); font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($jual->TanggalPenjualan)->format('d M Y') }}</td>
                    <td><strong>{{ $jual->pelanggan->NamaPelanggan ?? '-' }}</strong></td>
                    <td>
                        <span class="badge badge-pink">Rp {{ number_format($jual->TotalHarga, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @if($jual->status === 'menunggu')
                            <span class="badge" style="background:#fef9c3; color:#ca8a04;">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                        @elseif($jual->status === 'diproses')
                            <span class="badge" style="background:#dbeafe; color:#2563eb;">
                                <i class="fas fa-box"></i> Diproses
                            </span>
                        @elseif($jual->status === 'selesai')
                            <span class="badge" style="background:#dcfce7; color:#16a34a;">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @else
                            <span class="badge" style="background:#fee2e2; color:#dc2626;">
                                <i class="fas fa-times-circle"></i> Ditolak
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.4rem; flex-wrap:wrap;">

                            @if($jual->status === 'menunggu')
                                {{-- Proses --}}
                                <form action="{{ route('penjualan.status', $jual->PenjualanID) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="diproses">
                                    <button type="submit" style="display:flex; align-items:center; gap:0.3rem; padding:0.3rem 0.7rem; border-radius:7px; font-size:0.75rem; font-weight:600; font-family:inherit; background:#dbeafe; color:#2563eb; border:none; cursor:pointer;">
                                        <i class="fas fa-box"></i> Proses
                                    </button>
                                </form>
                                {{-- Tolak --}}
                                <form action="{{ route('penjualan.status', $jual->PenjualanID) }}" method="POST"
                                      onsubmit="return confirm('Tolak pesanan ini?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" style="display:flex; align-items:center; gap:0.3rem; padding:0.3rem 0.7rem; border-radius:7px; font-size:0.75rem; font-weight:600; font-family:inherit; background:#fee2e2; color:#dc2626; border:none; cursor:pointer;">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>

                            @elseif($jual->status === 'diproses')
                                {{-- Selesai --}}
                                <form action="{{ route('penjualan.status', $jual->PenjualanID) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" style="display:flex; align-items:center; gap:0.3rem; padding:0.3rem 0.7rem; border-radius:7px; font-size:0.75rem; font-weight:600; font-family:inherit; background:#dcfce7; color:#16a34a; border:none; cursor:pointer;">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>

                            @else
                                <span style="font-size:0.75rem; color:var(--gray); font-style:italic;">
                                    {{ $jual->status === 'selesai' ? '✓ Done' : '✗ Ditolak' }}
                                </span>
                            @endif

                            <a href="{{ route('penjualan.show', $jual->PenjualanID) }}"
                               style="display:flex; align-items:center; gap:0.3rem; padding:0.3rem 0.7rem; border-radius:7px; font-size:0.75rem; font-weight:600; color:var(--pink); border:1.5px solid var(--pink-mid); background:var(--white); text-decoration:none;">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--gray);">
                        <i class="fas fa-receipt" style="font-size:2rem; display:block; margin-bottom:0.5rem; color:var(--pink-mid);"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
.alert { display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; border-radius:10px; font-size:0.875rem; margin-bottom:1.25rem; }
.alert-success { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }
.table-card { background:var(--white); border-radius:18px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 12px rgba(233,30,140,0.06); }
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; }
thead th { padding:0.7rem 1.1rem; font-size:0.73rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; color:var(--gray); border-bottom:1px solid var(--border); text-align:left; background:var(--bg); }
tbody td { padding:0.85rem 1.1rem; font-size:0.875rem; border-bottom:1px solid var(--border); vertical-align:middle; }
tbody tr:last-child td { border-bottom:none; }
tbody tr:hover td { background:var(--pink-light); }
.badge { display:inline-block; padding:0.2rem 0.65rem; border-radius:20px; font-size:0.75rem; font-weight:600; }
.badge-pink { background:var(--pink-light); color:var(--pink); }
.btn-primary:hover { background:var(--pink-dark); }
</style>
@endpush

@endsection