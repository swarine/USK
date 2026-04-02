<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doll. — @yield('title', 'Toko')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --pink:       #e91e8c;
            --pink-dark:  #c4177a;
            --pink-light: #fce4f3;
            --pink-mid:   #f8b4db;
            --dark:       #1a1a2e;
            --gray:       #6b7280;
            --border:     #f0e0ec;
            --white:      #ffffff;
            --bg:         #fafafa;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--dark); }
        a { text-decoration: none; color: inherit; }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            height: 62px;
            padding: 0 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 300;
            box-shadow: 0 2px 12px rgba(233,30,140,0.06);
        }
        .brand { font-family: 'Playfair Display', serif; font-size: 1.65rem; font-weight: 700; color: var(--dark); }
        .brand span { color: var(--pink); }
        .nav-links { display: flex; align-items: center; gap: 2px; list-style: none; }
        .nav-links a { padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 500; color: var(--gray); transition: all 0.18s; }
        .nav-links a:hover, .nav-links a.active { color: var(--pink); background: var(--pink-light); }
        .nav-right { display: flex; align-items: center; gap: 0.75rem; }
        .nav-user { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 500; }
        .nav-user .avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--pink-light); display: flex; align-items: center; justify-content: center; color: var(--pink); font-size: 0.8rem; }

        /* CART BUTTON */
        .btn-cart {
            position: relative;
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--pink-light);
            border: none;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--pink);
            font-size: 1rem;
            transition: all 0.18s;
        }
        .btn-cart:hover { background: var(--pink); color: var(--white); }
        .cart-count {
            position: absolute;
            top: -5px; right: -5px;
            width: 18px; height: 18px;
            background: var(--pink);
            color: var(--white);
            border-radius: 50%;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            display: none;
        }

        .btn-logout { display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; border-radius: 8px; font-size: 0.8rem; font-weight: 500; font-family: inherit; background: #fee2e2; color: #dc2626; border: none; cursor: pointer; transition: all 0.18s; }
        .btn-logout:hover { background: #fecaca; }

        /* ── MAIN ── */
        .main { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* ── CART OVERLAY ── */
        .cart-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 400;
            opacity: 0; pointer-events: none;
            transition: opacity 0.25s;
        }
        .cart-overlay.open { opacity: 1; pointer-events: all; }

        /* ── CART DRAWER ── */
        .cart-drawer {
            position: fixed;
            top: 0; right: 0;
            width: 380px; height: 100vh;
            background: var(--white);
            z-index: 500;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: -8px 0 40px rgba(0,0,0,0.12);
        }
        .cart-drawer.open { transform: translateX(0); }

        .cart-drawer__head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .cart-drawer__head h2 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; }
        .cart-drawer__head h2 span { color: var(--pink); }
        .btn-close-cart { background: none; border: none; font-size: 1.1rem; cursor: pointer; color: var(--gray); padding: 0.25rem; transition: color 0.18s; }
        .btn-close-cart:hover { color: var(--pink); }

        .cart-drawer__body { flex: 1; overflow-y: auto; padding: 1rem 1.5rem; }

        .cart-empty { text-align: center; padding: 3rem 1rem; color: var(--gray); }
        .cart-empty i { font-size: 2.5rem; color: var(--pink-mid); display: block; margin-bottom: 0.75rem; }
        .cart-empty p { font-size: 0.875rem; }

        .cart-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--border);
        }
        .cart-item:last-child { border-bottom: none; }
        .cart-item__img {
            width: 54px; height: 54px; border-radius: 10px;
            background: var(--pink-light);
            overflow: hidden; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: var(--pink-mid); font-size: 1.3rem;
        }
        .cart-item__img img { width: 100%; height: 100%; object-fit: cover; }
        .cart-item__info { flex: 1; min-width: 0; }
        .cart-item__name { font-weight: 600; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cart-item__price { color: var(--pink); font-weight: 600; font-size: 0.85rem; margin-top: 0.15rem; }
        .cart-item__qty {
            display: flex; align-items: center; gap: 0.4rem;
        }
        .qty-btn {
            width: 26px; height: 26px; border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--white); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; color: var(--dark);
            transition: all 0.15s; font-family: inherit;
        }
        .qty-btn:hover { border-color: var(--pink); color: var(--pink); }
        .qty-num { font-weight: 600; font-size: 0.875rem; min-width: 20px; text-align: center; }
        .btn-remove { background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.8rem; padding: 0.2rem; transition: opacity 0.15s; }
        .btn-remove:hover { opacity: 0.7; }

        .cart-drawer__foot {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border);
            background: var(--white);
        }
        .cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .cart-total-label { font-size: 0.875rem; color: var(--gray); font-weight: 500; }
        .cart-total-value { font-size: 1.25rem; font-weight: 700; color: var(--pink); font-family: 'Playfair Display', serif; }

        .btn-checkout {
            width: 100%; padding: 0.8rem;
            background: var(--pink); color: var(--white);
            border: none; border-radius: 10px;
            font-size: 0.9rem; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-checkout:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,140,0.25); }
        .btn-checkout:disabled { background: var(--pink-mid); cursor: not-allowed; transform: none; box-shadow: none; }

        /* ── ALERTS ── */
        .alert { display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.875rem; margin-bottom: 1.25rem; }
        .alert-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

        /* ── HERO ── */
        .hero { background: linear-gradient(120deg, var(--pink-light) 0%, #fff4fb 60%, #fce4f3 100%); border-radius: 20px; padding: 2.5rem 3rem; margin-bottom: 2rem; position: relative; overflow: hidden; }
        .hero::after { content: '🧸'; position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); font-size: 5rem; opacity: 0.18; }
        .hero-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; line-height: 1.3; margin-bottom: 0.4rem; }
        .hero-title span { color: var(--pink); }
        .hero-sub { font-size: 0.9rem; color: var(--gray); }

        /* ── SECTION BANNER ── */
        .section-banner { background: linear-gradient(110deg, var(--pink-light) 0%, #fff4fb 100%); border: 1px solid var(--pink-mid); border-radius: 16px; padding: 0.9rem 2rem; margin-bottom: 1.5rem; text-align: center; }
        .section-banner h2 { font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 700; }
        .section-banner h2 span { color: var(--pink); }

        /* ── PRODUCT GRID ── */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.25rem; }
        .product-card { background: var(--white); border-radius: 18px; border: 1px solid var(--border); overflow: hidden; transition: transform 0.22s, box-shadow 0.22s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(233,30,140,0.13); }
        .product-card__img { height: 165px; background: var(--pink-light); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--pink-mid); overflow: hidden; }
        .product-card__img img { width: 100%; height: 100%; object-fit: cover; }
        .product-card__body { padding: 0.9rem 1rem 0.6rem; }
        .product-card__name { font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .product-card__price { color: var(--pink); font-weight: 700; font-size: 1rem; margin-bottom: 0.4rem; }
        .product-card__stock { font-size: 0.78rem; color: var(--gray); margin-bottom: 0.7rem; }
        .badge { display: inline-block; padding: 0.18rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red   { background: #fee2e2; color: #dc2626; }

        .btn-add-cart {
            width: 100%; padding: 0.55rem;
            background: var(--pink-light); color: var(--pink);
            border: 1.5px solid var(--pink-mid);
            border-radius: 10px; font-size: 0.83rem; font-weight: 600;
            font-family: inherit; cursor: pointer; transition: all 0.18s;
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
        }
        .btn-add-cart:hover { background: var(--pink); color: var(--white); border-color: var(--pink); }
        .btn-add-cart:disabled { background: var(--bg); color: var(--gray); border-color: var(--border); cursor: not-allowed; }

        /* TABLE (riwayat) */
        .card { background: var(--white); border-radius: 18px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 2px 12px rgba(233,30,140,0.06); }
        .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-header h2 { font-size: 0.95rem; font-weight: 600; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 0.7rem 1.1rem; font-size: 0.73rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gray); border-bottom: 1px solid var(--border); text-align: left; background: var(--bg); }
        tbody td { padding: 0.85rem 1.1rem; font-size: 0.875rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--pink-light); }
        tfoot td { padding: 0.85rem 1.1rem; font-size: 0.875rem; }
        .badge-pink { background: var(--pink-light); color: var(--pink); }

        @media (max-width: 600px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
            .hero { padding: 1.5rem; }
            .main { padding: 1rem; }
            .cart-drawer { width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>


<nav class="navbar">
    <a href="{{ route('pelanggan.home') }}" class="brand">Doll<span>.</span></a>
    <ul class="nav-links">
        <li><a href="{{ route('pelanggan.home') }}" class="{{ request()->routeIs('pelanggan.home') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Produk
        </a></li>
        <li><a href="{{ route('pelanggan.riwayat') }}" class="{{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Riwayat
        </a></li>
    </ul>
    <div class="nav-right">
        {{-- CART BUTTON --}}
        <button class="btn-cart" onclick="toggleCart()" title="Keranjang">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cart-count">0</span>
        </button>
        <div class="nav-user">
            <div class="avatar"><i class="fas fa-user"></i></div>
            <span>{{ session('nama') }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</nav>

{{-- CART OVERLAY --}}
<div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>

{{-- CART DRAWER --}}
<div class="cart-drawer" id="cart-drawer">
    <div class="cart-drawer__head">
        <h2>Keranjang <span>Belanja</span></h2>
        <button class="btn-close-cart" onclick="toggleCart()"><i class="fas fa-times"></i></button>
    </div>
    <div class="cart-drawer__body" id="cart-body">
        <div class="cart-empty">
            <i class="fas fa-shopping-cart"></i>
            <p>Keranjang kamu masih kosong</p>
        </div>
    </div>
    <div class="cart-drawer__foot">
        <div class="cart-total-row">
            <span class="cart-total-label">Total</span>
            <span class="cart-total-value" id="cart-total">Rp 0</span>
        </div>
        <button onclick="prepareCheckout()" class="btn-checkout" id="btn-checkout" disabled>
            <i class="fas fa-lock"></i> Checkout Sekarang
        </button>
    </div>
</div>

<div class="main">
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @yield('content')
</div>

{{-- ============================================================
     FOOTER + FAQ — Doll. Store
     Paste ini di layouts/pelanggan.blade.php sebelum </body>
     ============================================================ --}}

<footer style="
    background: #fff0f6;
    border-top: 1.5px solid #f4c0d1;
    padding: 2.5rem 1.5rem 1.25rem;
    margin-top: 3rem;
    font-family: inherit;
">
    <div style="max-width: 860px; margin: 0 auto;">

        {{-- BRAND --}}
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #1a0d14; letter-spacing: -0.5px;">
                Doll<span style="color: #e91e8c;">.</span>
            </div>
            <p style="font-size: 0.8rem; color: #888780; margin-top: 0.3rem;">
                Temukan boneka favoritmu di sini ♡
            </p>
        </div>

        {{-- FAQ SECTION --}}
        <div style="margin-bottom: 2rem;">
            <h3 style="
                text-align: center;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #e91e8c;
                margin-bottom: 1.25rem;
            ">Pertanyaan Umum (FAQ)</h3>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; max-width: 600px; margin: 0 auto;">

                {{-- FAQ Item --}}
                <div class="faq-item" style="background:#fff; border:1.5px solid #f4c0d1; border-radius:12px; overflow:hidden;">
                    <button class="faq-btn" onclick="toggleFaq(this)" style="
                        width:100%; display:flex; align-items:center; justify-content:space-between;
                        padding:0.85rem 1rem; background:none; border:none; cursor:pointer;
                        font-family:inherit; font-size:0.85rem; font-weight:600; color:#1a0d14; text-align:left;
                    ">
                        Bagaimana cara memesan produk?
                        <span class="faq-icon" style="font-size:1rem; color:#e91e8c; flex-shrink:0; margin-left:0.5rem; transition:transform 0.25s;">+</span>
                    </button>
                    <div class="faq-answer" style="max-height:0; overflow:hidden; transition:max-height 0.3s ease;">
                        <p style="padding:0 1rem 0.85rem; font-size:0.82rem; color:#5f5e5a; line-height:1.7; margin:0;">
                            Pilih produk yang kamu suka, klik <strong>Tambah ke Keranjang</strong>, lalu buka keranjang dan lanjutkan ke halaman <strong>Checkout</strong>. Isi data pengiriman dan pilih metode pembayaran.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item --}}
                <div class="faq-item" style="background:#fff; border:1.5px solid #f4c0d1; border-radius:12px; overflow:hidden;">
                    <button class="faq-btn" onclick="toggleFaq(this)" style="
                        width:100%; display:flex; align-items:center; justify-content:space-between;
                        padding:0.85rem 1rem; background:none; border:none; cursor:pointer;
                        font-family:inherit; font-size:0.85rem; font-weight:600; color:#1a0d14; text-align:left;
                    ">
                        Metode pembayaran apa saja yang tersedia?
                        <span class="faq-icon" style="font-size:1rem; color:#e91e8c; flex-shrink:0; margin-left:0.5rem; transition:transform 0.25s;">+</span>
                    </button>
                    <div class="faq-answer" style="max-height:0; overflow:hidden; transition:max-height 0.3s ease;">
                        <p style="padding:0 1rem 0.85rem; font-size:0.82rem; color:#5f5e5a; line-height:1.7; margin:0;">
                            Tersedia dua metode: <strong>COD</strong> (bayar tunai saat barang tiba) dan <strong>QRIS</strong> (transfer lalu upload bukti pembayaran). Pesanan akan diproses setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item --}}
                <div class="faq-item" style="background:#fff; border:1.5px solid #f4c0d1; border-radius:12px; overflow:hidden;">
                    <button class="faq-btn" onclick="toggleFaq(this)" style="
                        width:100%; display:flex; align-items:center; justify-content:space-between;
                        padding:0.85rem 1rem; background:none; border:none; cursor:pointer;
                        font-family:inherit; font-size:0.85rem; font-weight:600; color:#1a0d14; text-align:left;
                    ">
                        Berapa lama proses pengiriman?
                        <span class="faq-icon" style="font-size:1rem; color:#e91e8c; flex-shrink:0; margin-left:0.5rem; transition:transform 0.25s;">+</span>
                    </button>
                    <div class="faq-answer" style="max-height:0; overflow:hidden; transition:max-height 0.3s ease;">
                        <p style="padding:0 1rem 0.85rem; font-size:0.82rem; color:#5f5e5a; line-height:1.7; margin:0;">
                            Pesanan diproses dalam <strong>1–2 hari kerja</strong> setelah pembayaran dikonfirmasi. Estimasi pengiriman <strong>2–5 hari kerja</strong> tergantung lokasi tujuan.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item --}}
                <div class="faq-item" style="background:#fff; border:1.5px solid #f4c0d1; border-radius:12px; overflow:hidden;">
                    <button class="faq-btn" onclick="toggleFaq(this)" style="
                        width:100%; display:flex; align-items:center; justify-content:space-between;
                        padding:0.85rem 1rem; background:none; border:none; cursor:pointer;
                        font-family:inherit; font-size:0.85rem; font-weight:600; color:#1a0d14; text-align:left;
                    ">
                        Apakah pesanan bisa dibatalkan?
                        <span class="faq-icon" style="font-size:1rem; color:#e91e8c; flex-shrink:0; margin-left:0.5rem; transition:transform 0.25s;">+</span>
                    </button>
                    <div class="faq-answer" style="max-height:0; overflow:hidden; transition:max-height 0.3s ease;">
                        <p style="padding:0 1rem 0.85rem; font-size:0.82rem; color:#5f5e5a; line-height:1.7; margin:0;">
                            Pembatalan hanya bisa dilakukan saat status pesanan masih <strong>Menunggu</strong>. Segera hubungi kami via WhatsApp di <strong>0812-3456-7890</strong> sebelum pesanan diproses.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item --}}
                <div class="faq-item" style="background:#fff; border:1.5px solid #f4c0d1; border-radius:12px; overflow:hidden;">
                    <button class="faq-btn" onclick="toggleFaq(this)" style="
                        width:100%; display:flex; align-items:center; justify-content:space-between;
                        padding:0.85rem 1rem; background:none; border:none; cursor:pointer;
                        font-family:inherit; font-size:0.85rem; font-weight:600; color:#1a0d14; text-align:left;
                    ">
                        Apakah produk dijamin original dan baru?
                        <span class="faq-icon" style="font-size:1rem; color:#e91e8c; flex-shrink:0; margin-left:0.5rem; transition:transform 0.25s;">+</span>
                    </button>
                    <div class="faq-answer" style="max-height:0; overflow:hidden; transition:max-height 0.3s ease;">
                        <p style="padding:0 1rem 0.85rem; font-size:0.82rem; color:#5f5e5a; line-height:1.7; margin:0;">
                            Ya! Semua produk kami <strong>100% baru dan original</strong>, dikemas dengan aman sebelum dikirim. Kalau ada kerusakan saat diterima, segera hubungi kami ♡
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- DIVIDER --}}
        <hr style="border: none; border-top: 1px solid #f4c0d1; margin-bottom: 1.25rem;">

        {{-- BOTTOM --}}
        <div style="text-align: center;">
            <p style="font-size: 0.75rem; color: #b4b2a9;">
                &copy; {{ date('Y') }} <strong style="color:#e91e8c;">Doll.</strong> — All rights reserved. Made with ♡
            </p>
        </div>

    </div>
</footer>

@push('scripts')
<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const icon   = btn.querySelector('.faq-icon');
    const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

    // tutup semua
    document.querySelectorAll('.faq-answer').forEach(a => a.style.maxHeight = '0px');
    document.querySelectorAll('.faq-icon').forEach(i => {
        i.textContent = '+';
        i.style.transform = 'rotate(0deg)';
    });
    document.querySelectorAll('.faq-btn').forEach(b => b.style.color = '#1a0d14');

    if (!isOpen) {
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.textContent = '×';
        icon.style.transform = 'rotate(90deg)';
        btn.style.color = '#e91e8c';
    }
}
</script>
@endpush

<script>
    // ── CART STATE ──
    let cart = {};

    function prepareCheckout() {
    const items = Object.values(cart);
    if (items.length === 0) return;
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("pelanggan.checkout.show") }}';
    const field = document.createElement('input');
    field.type = 'hidden';
    field.name = 'cart_data';
    field.value = JSON.stringify(items.map(i => ({ id: i.id, qty: i.qty })));
    form.appendChild(field);
    document.body.appendChild(form);
    form.submit();
}

    function toggleCart() {
        document.getElementById('cart-drawer').classList.toggle('open');
        document.getElementById('cart-overlay').classList.toggle('open');
    }

    function addToCart(id, nama, harga, gambar, stok) {
        if (cart[id]) {
            if (cart[id].qty >= stok) { alert('Stok tidak cukup!'); return; }
            cart[id].qty++;
        } else {
            cart[id] = { id, nama, harga, gambar, stok, qty: 1 };
        }
        renderCart();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        cart[id].qty += delta;
        if (cart[id].qty <= 0) delete cart[id];
        renderCart();
    }

    function removeItem(id) {
        delete cart[id];
        renderCart();
    }

    function renderCart() {
        const body   = document.getElementById('cart-body');
        const countEl = document.getElementById('cart-count');
        const totalEl = document.getElementById('cart-total');
        const btn    = document.getElementById('btn-checkout');
        const input  = document.getElementById('cart-data-input');

        const items = Object.values(cart);
        let total = 0, count = 0;

        if (items.length === 0) {
            body.innerHTML = `<div class="cart-empty"><i class="fas fa-shopping-cart"></i><p>Keranjang kamu masih kosong</p></div>`;
            countEl.style.display = 'none';
            totalEl.textContent = 'Rp 0';
            btn.disabled = true;
            input.value = '';
            return;
        }

        let html = '';
        items.forEach(item => {
            total += item.harga * item.qty;
            count += item.qty;
            const imgHtml = item.gambar
                ? `<img src="/storage/${item.gambar}" alt="${item.nama}">`
                : `<i class="fas fa-cube"></i>`;
            html += `
                <div class="cart-item">
                    <div class="cart-item__img">${imgHtml}</div>
                    <div class="cart-item__info">
                        <div class="cart-item__name">${item.nama}</div>
                        <div class="cart-item__price">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</div>
                    </div>
                    <div class="cart-item__qty">
                        <button class="qty-btn" onclick="changeQty(${item.id}, -1)"><i class="fas fa-minus"></i></button>
                        <span class="qty-num">${item.qty}</span>
                        <button class="qty-btn" onclick="changeQty(${item.id}, 1)"><i class="fas fa-plus"></i></button>
                        <button class="btn-remove" onclick="removeItem(${item.id})"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`;
        });

        body.innerHTML = html;
        countEl.style.display = 'flex';
        countEl.textContent = count;
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        btn.disabled = false;
        input.value = JSON.stringify(items.map(i => ({ id: i.id, qty: i.qty })));
    }
</script>
@stack('scripts')
</body>
</html>