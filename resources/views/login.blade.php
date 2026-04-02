<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doll. — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--white);
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 45%;
            background: linear-gradient(145deg, #fce4f3 0%, #fff0fa 50%, #fce4f3 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        /* floating decorative circles */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(233,30,140,0.12) 0%, transparent 70%);
            top: -80px; left: -80px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(233,30,140,0.09) 0%, transparent 70%);
            bottom: -60px; right: -40px;
        }

        .deco-dots {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 340px; height: 340px;
            border-radius: 50%;
            border: 1.5px dashed var(--pink-mid);
            opacity: 0.5;
            animation: spin 30s linear infinite;
        }
        .deco-dots-2 {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 240px; height: 240px;
            border-radius: 50%;
            border: 1.5px dashed var(--pink-mid);
            opacity: 0.35;
            animation: spin 20s linear infinite reverse;
        }
        @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .left-brand {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .left-brand span { color: var(--pink); }

        .left-tagline {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
        }

        /* cute doll illustration placeholder */
        .doll-icon {
            width: 110px; height: 110px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 32px rgba(233,30,140,0.15);
            font-size: 3.5rem;
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }

        .left-desc {
            font-size: 0.875rem;
            color: var(--gray);
            line-height: 1.7;
            max-width: 260px;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            animation: fadeUp 0.5s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.4rem;
        }
        .login-title span { color: var(--pink); }

        .login-sub {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 2rem;
        }

        /* ALERT */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.83rem;
            margin-bottom: 1.25rem;
        }
        .alert-danger  { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .alert-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }

        /* FORM */
        .form-group { margin-bottom: 1.1rem; }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.35rem;
        }

        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--pink-mid);
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .input-wrap input {
            width: 100%;
            padding: 0.65rem 0.9rem 0.65rem 2.5rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            font-family: inherit;
            background: #fffafd;
            color: var(--dark);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-wrap input:focus {
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(233,30,140,0.09);
            background: var(--white);
        }
        .input-wrap input:focus + i,
        .input-wrap:focus-within i.icon-left { color: var(--pink); }

        /* toggle password */
        .toggle-pw {
            position: absolute;
            right: 2.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            cursor: pointer;
            font-size: 0.85rem;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--pink); }

        /* role selector */
        .role-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .role-tab {
            flex: 1;
            padding: 0.55rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--white);
            font-size: 0.83rem;
            font-weight: 500;
            font-family: inherit;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .role-tab:hover { border-color: var(--pink-mid); color: var(--pink); }
        .role-tab.active {
            background: var(--pink-light);
            border-color: var(--pink);
            color: var(--pink);
            font-weight: 600;
        }

        /* submit button */
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: var(--pink);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-login:hover {
            background: var(--pink-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(233,30,140,0.25);
        }
        .btn-login:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--gray);
        }
        .login-footer a { color: var(--pink); font-weight: 500; text-decoration: none; }
        .login-footer a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ── */
        @media (max-width: 700px) {
            .left-panel { display: none; }
            body { background: var(--pink-light); }
            .right-panel { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- LEFT DECORATIVE PANEL -->
<div class="left-panel">
    <div class="deco-dots"></div>
    <div class="deco-dots-2"></div>
    <div class="left-content">
        <div class="doll-icon">🧸</div>
        <div class="left-brand">Doll<span>.</span></div>
        <div class="left-tagline">your favourite doll store</div>
        <p class="left-desc">Find you favorite doll here! Login to continue and buy stuff</p>
    </div>
</div>

<!-- RIGHT LOGIN PANEL -->
<div class="right-panel">
    <div class="login-box">

        <h1 class="login-title">Selamat <span>Datang !</span></h1>
        <p class="login-sub">Login ke akun kamu untuk melanjutkan</p>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('login.post') }}" method="POST" id="login-form">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrap">
                    <input type="text" name="EmailPelanggan" value="{{ old('EmailPelanggan') }}"
                        placeholder="Masukkan Email" required autocomplete="off">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password" name="password" id="password-input"
                           placeholder="Masukkan password" required"">
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>

        <div class="login-footer">
            Belum punya akun? <a href="{{ route('register') }}"">Daftar sekarang</a>
        </div>

    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password-input');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
</script>

</body>
</html>
