@extends('layouts.pelanggan')
@section('title', 'Toko')

@section('content')

<div class="hero">
    <div>
        <div class="hero-title">Hello, <span>{{ session('nama') }}</span> ♡</div>
        <div class="hero-sub">temukan boneka favoritmu disini!⊹⋆. 𐙚 ˚</div>
    </div>
</div>

<div class="section-banner">
    <h2>Latest <span>Products</span></h2>
</div>

@if($produk->count())
<div class="product-grid">
    @foreach($produk as $p)
    <div class="product-card">
        <div class="product-card__img">
            @if($p->Gambar)
                <img src="{{ asset('storage/' . $p->Gambar) }}" alt="{{ $p->NamaProduk }}">
            @else
                <i class="fas fa-cube"></i>
            @endif
        </div>
        <div class="product-card__body">
            <div class="product-card__name">{{ $p->NamaProduk }}</div>
            <div class="product-card__price">Rp {{ number_format($p->Harga, 0, ',', '.') }}</div>
            <div class="product-card__stock">
                @if($p->Stok > 0)
                    <span class="badge badge-green"><i class="fas fa-check"></i> Tersedia ({{ $p->Stok }})</span>
                @else
                    <span class="badge badge-red"><i class="fas fa-times"></i> Stok Habis</span>
                @endif
            </div>
            <button class="btn-add-cart"
            onclick="addToCart('{{ $p->ProdukID }}', '{{ addslashes($p->NamaProduk) }}', '{{ $p->Harga }}', '{{ $p->Gambar }}', '{{ $p->Stok }}')"
            {{ $p->Stok == 0 ? 'disabled' : '' }}>
            <i class="fas fa-cart-plus"></i>
            {{ $p->Stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
        </button>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card" style="text-align:center; padding:3rem;">
    <i class="fas fa-box-open" style="font-size:2.5rem; color:var(--pink-mid); display:block; margin-bottom:0.75rem;"></i>
    <p style="color:var(--gray);">Belum ada produk tersedia.</p>
</div>
@endif

@endsection
