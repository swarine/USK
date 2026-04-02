@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Data <span>Produk</span></h1>
    <a href="{{ route('produk.create') }}" class="btn btn-pink">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="section-banner">
    <h2>Latest <span>Products</h2>
</div>

@if($produk->count())
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(185px,1fr)); gap:1.15rem;">
    @foreach($produk as $p)
    <div class="produk-card">
        <div class="produk-card__img">
            @if($p->Gambar)
                <img src="{{ asset('storage/' . $p->Gambar) }}" alt="{{ $p->NamaProduk }}">
            @else
                <i class="fas fa-cube"></i>
            @endif
        </div>

        <div class="produk-card__body">
            <div class="produk-card__name">{{ $p->NamaProduk }}</div>
            <div class="produk-card__price">
                Rp {{ number_format($p->Harga, 0, ',', '.') }}
            </div>
            <div style="margin-top:0.4rem;">
                @if($p->Stok > 0)
                    <span class="badge badge-green">Stok: {{ $p->Stok }}</span>
                @else
                    <span class="badge badge-red">Stok Habis</span>
                @endif
            </div>
        </div>

        <div class="produk-card__actions">
            <a href="{{ route('produk.edit', $p->ProdukID) }}" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <div class="produk-card__sep"></div>
            <form action="{{ route('produk.destroy', $p->ProdukID) }}" method="POST"
                  onsubmit="return confirm('Hapus produk ini?')" style="display:contents;">
                @csrf @method('DELETE')
                <button type="submit" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card" style="text-align:center; padding:3rem 2rem;">
    <i class="fas fa-box-open" style="font-size:2.5rem; color:var(--pink-mid); display:block; margin-bottom:0.75rem;"></i>
    <p style="color:var(--gray);">Belum ada produk.
        <a href="{{ route('produk.create') }}" style="color:var(--pink); font-weight:600;">Tambah sekarang →</a>
    </p>
</div>
@endif

@endsection

@push('styles')
<style>
    .produk-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s;
    }
    .produk-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    .produk-card__img {
        height: 155px;
        background: var(--pink-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--pink-mid);
        overflow: hidden;
    }
    .produk-card__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .produk-card__body {
        padding: 0.85rem 1rem 0.7rem;
    }
    .produk-card__name {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .produk-card__price {
        color: var(--pink);
        font-weight: 700;
        font-size: 0.95rem;
    }
    .produk-card__actions {
        display: flex;
        border-top: 1px solid var(--border);
    }
    .produk-card__actions a,
    .produk-card__actions button {
        flex: 1;
        padding: 0.5rem;
        text-align: center;
        font-size: 0.85rem;
        border: none;
        background: transparent;
        cursor: pointer;
        color: var(--gray);
        transition: all 0.15s;
        font-family: inherit;
    }
    .produk-card__actions a:hover { background: var(--pink-light); color: var(--pink); }
    .produk-card__actions button:hover { background: #fee2e2; color: #dc2626; }
    .produk-card__sep { width: 1px; background: var(--border); }
</style>
@endpush
