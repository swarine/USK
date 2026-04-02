<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doll. - Toko Boneka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ── TOKENS ─────────────────────────────── */
        :root {
            --pink:        #e91e8c;
            --pink-dark:   #c4177a;
            --pink-light:  #fce4f3;
            --pink-mid:    #f8b4db;
            --dark:        #1a1a2e;
            --gray:        #6b7280;
            --gray-light:  #f3f4f6;
            --white:       #ffffff;
            --border:      #f0e0ec;
            --bg:          #fafafa;
            --shadow-sm:   0 2px 8px rgba(233,30,140,0.06);
            --shadow-md:   0 4px 24px rgba(233,30,140,0.10);
            --shadow-lg:   0 12px 40px rgba(233,30,140,0.14);
            --radius-sm:   8px;
            --radius-md:   12px;
            --radius-lg:   18px;
        }

        /* ── RESET ───────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--dark); min-height: 100vh; }
        a { color: inherit; text-decoration: none; }

        /* ── NAVBAR ──────────────────────────────── */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            height: 62px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: var(--shadow-sm);
        }
        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.02em;
        }
        .brand span { color: var(--pink); }

        .nav-links { display: flex; align-items: center; gap: 2px; list-style: none; }
        .nav-links a {
            padding: 0.4rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
            transition: all 0.18s;
        }
        .nav-links a:hover { color: var(--pink); background: var(--pink-light); }
        .nav-links a.active { color: var(--pink); background: var(--pink-light); font-weight: 600; }

        .nav-icons { display: flex; align-items: center; gap: 1.1rem; }
        .nav-icons a { color: var(--dark); font-size: 1rem; transition: color 0.18s; }
        .nav-icons a:hover { color: var(--pink); }

        /* ── LAYOUT ──────────────────────────────── */
        .layout { display: flex; min-height: calc(100vh - 62px); }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: 210px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 1.5rem 0.85rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            justify-content: space-between;
        }
        .sidebar-label {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--pink-mid);
            padding: 0 0.6rem;
            margin: 0.75rem 0 0.3rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.55rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
            transition: all 0.18s;
        }
        .sidebar-link i { width: 16px; text-align: center; font-size: 0.85rem; }
        .sidebar-link:hover { color: var(--pink); background: var(--pink-light); }
        .sidebar-link.active { color: var(--pink); background: var(--pink-light); font-weight: 600; }
        .btn-logout { display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; border-radius: 8px; font-size: 0.8rem; font-weight: 500; font-family: inherit; background: #fee2e2; color: #dc2626; border: none; cursor: pointer; transition: all 0.18s; }
        .btn-logout:hover { background: #fecaca; }

        /* ── MAIN ────────────────────────────────── */
        .main { flex: 1; padding: 2rem 2.25rem; min-width: 0; }

        /* ── PAGE HEADER ─────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .page-title span { color: var(--pink); }

        /* ── SECTION BANNER ──────────────────────── */
        .section-banner {
            background: linear-gradient(110deg, var(--pink-light) 0%, #fff4fb 100%);
            border: 1px solid var(--pink-mid);
            border-radius: var(--radius-lg);
            padding: 1rem 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .section-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 700;
        }
        .section-banner h2 span { color: var(--pink); }

        /* ── ALERT ───────────────────────────────── */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.8rem 1.1rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        .alert-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .alert-pink    { background: var(--pink-light); color: var(--pink); border: 1px solid var(--pink-mid); }

        /* ── CARD ────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h2 { font-size: 0.95rem; font-weight: 600; }
        .card-body { padding: 1.5rem; }

        /* ── BUTTONS ─────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.2rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            font-family: inherit;
            border: none;
            cursor: pointer;
            transition: all 0.18s;
            white-space: nowrap;
        }
        .btn-pink    { background: var(--pink); color: #fff; }
        .btn-pink:hover    { background: var(--pink-dark); }
        .btn-outline { background: transparent; color: var(--pink); border: 1.5px solid var(--pink); }
        .btn-outline:hover { background: var(--pink-light); }
        .btn-danger  { background: #fee2e2; color: #dc2626; border: none; }
        .btn-danger:hover  { background: #fecaca; }
        .btn-sm { padding: 0.32rem 0.75rem; font-size: 0.8rem; }

        /* ── TABLE ───────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 0.7rem 1.1rem;
            font-size: 0.73rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--gray);
            border-bottom: 1px solid var(--border);
            text-align: left;
            background: var(--bg);
        }
        tbody td { padding: 0.85rem 1.1rem; font-size: 0.875rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.12s; }
        tbody tr:hover td { background: var(--pink-light); }
        tfoot td { padding: 0.85rem 1.1rem; font-size: 0.875rem; }

        /* ── TOP BAR ─────────────────────────────── */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        /* ── FORM ────────────────────────────────── */
        .form-group { margin-bottom: 1.2rem; }
        label {
            display: block;
            font-size: 0.83rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.35rem;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-family: inherit;
            background: var(--white);
            color: var(--dark);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(233,30,140,0.09);
        }
        select { cursor: pointer; }

        /* ── PRODUK ITEM (penjualan create) ──────── */
        .produk-item {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            margin-bottom: 0.6rem;
            background: var(--pink-light);
            padding: 0.7rem 0.9rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }
        .produk-item select { flex: 3; }
        .produk-item input  { flex: 1; min-width: 80px; }

        /* ── BADGE ───────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 0.18rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-pink  { background: var(--pink-light); color: var(--pink); }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-red   { background: #fee2e2; color: #dc2626; }
        .badge-gray  { background: var(--gray-light); color: var(--gray); }

        /* ── ACTION ROW ──────────────────────────── */
        .action-row { display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 860px) {
            .sidebar { display: none; }
            .main { padding: 1.25rem; }
        }
        @media (max-width: 520px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar">
    <a href="/" class="brand">Doll<span>.</span></a>
</nav>

<div class="layout">
    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <span class="sidebar-label">Menu</span>
        <a href="{{ route('penjualan.index') }}"
           class="sidebar-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Penjualan
        </a>
        <a href="{{ route('pelanggan.index') }}"
           class="sidebar-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pelanggan
        </a>
        <a href="{{ route('produk.index') }}"
           class="sidebar-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Produk
        </a>
        <div style="margin-top: auto; padding: 1rem 0.85rem;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── CONTENT ── --}}
    <main class="main">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
