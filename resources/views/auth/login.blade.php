<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Evaluasi Pembelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:      #0f2744;
            --navy-mid:  #1E3A5F;
            --accent:    #2E86AB;
            --accent-lt: #5bc8f5;
            --cream:     #f7f9fc;
            --card-bg:   #ffffff;
            --text-main: #0f2744;
            --text-muted:#64748b;
            --border:    #e2e8f0;
            --shadow:    0 20px 60px rgba(15,39,68,.13);
        }

        [data-bs-theme="dark"] {
            --cream:     #0d1117;
            --card-bg:   #161b27;
            --text-main: #e2e8f0;
            --text-muted:#8ca8c5;
            --border:    #2d3550;
            --shadow:    0 20px 60px rgba(0,0,0,.45);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        /* ── LEFT PANEL ──────────────────────────────────── */
        .left-panel {
            flex: 0 0 42%;
            background: var(--navy);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3.5rem;
            overflow: hidden;
        }

        /* Animated geometric shapes */
        .geo {
            position: absolute;
            border-radius: 50%;
            opacity: .07;
            animation: float 8s ease-in-out infinite;
        }
        .geo-1 { width: 360px; height: 360px; background: var(--accent-lt); top: -100px; right: -80px; animation-delay: 0s; }
        .geo-2 { width: 220px; height: 220px; background: #fff; bottom: 80px; left: -60px; animation-delay: -3s; }
        .geo-3 { width: 120px; height: 120px; background: var(--accent-lt); bottom: 260px; right: 40px; animation-delay: -5s; }
        .geo-4 {
            width: 180px; height: 180px;
            background: transparent;
            border: 2px solid rgba(255,255,255,.12);
            top: 200px; left: 60px;
            border-radius: 32px;
            transform: rotate(20deg);
            animation: spin 25s linear infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-18px) scale(1.04); }
        }
        @keyframes spin {
            from { transform: rotate(20deg); }
            to   { transform: rotate(380deg); }
        }

        /* Grid dot overlay */
        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .brand-logo {
            position: relative;
            z-index: 2;
        }
        .brand-logo .icon-wrap {
            width: 52px; height: 52px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            margin-bottom: 1rem;
            backdrop-filter: blur(4px);
        }
        .brand-logo h1 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.02em;
            line-height: 1.2;
        }
        .brand-logo p {
            color: rgba(255,255,255,.55);
            font-size: .82rem;
            margin-top: .3rem;
        }

        .panel-tagline {
            position: relative;
            z-index: 2;
        }
        .panel-tagline h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.25;
            letter-spacing: -.03em;
        }
        .panel-tagline h2 span {
            color: var(--accent-lt);
        }
        .panel-tagline p {
            color: rgba(255,255,255,.5);
            font-size: .875rem;
            margin-top: .75rem;
            line-height: 1.7;
        }

        .role-pills {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-top: 1.5rem;
        }
        .role-pill {
            display: flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 20px;
            padding: .35rem .9rem;
            font-size: .75rem;
            font-weight: 600;
            color: rgba(255,255,255,.8);
            backdrop-filter: blur(4px);
        }
        .role-pill i { font-size: .7rem; }

        /* ── RIGHT PANEL ─────────────────────────────────── */
        .right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            position: relative;
        }

        /* Dark mode toggle top-right */
        .theme-toggle-btn {
            position: absolute;
            top: 1.5rem; right: 1.5rem;
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--text-muted);
            border-radius: 10px;
            padding: 6px 14px;
            font-size: .8rem;
            cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: all .2s;
        }
        .theme-toggle-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* Login card */
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.75rem 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow);
            animation: slideUp .5s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-card .card-heading h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -.03em;
        }
        .login-card .card-heading p {
            color: var(--text-muted);
            font-size: .875rem;
            margin-top: .3rem;
        }

        /* Floating label override */
        .form-floating label {
            color: var(--text-muted);
            font-size: .875rem;
        }
        .form-floating .form-control {
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: .95rem;
            height: 58px;
            padding-top: 1.5rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-floating .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(46,134,171,.12);
            background: var(--card-bg);
        }
        .form-floating .form-control.is-invalid { border-color: #dc3545; }

        /* Input group icon */
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .field-icon {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: .85rem;
            cursor: pointer;
            z-index: 5;
            transition: color .2s;
        }
        .input-icon-wrap .field-icon:hover { color: var(--accent); }

        /* Submit button */
        .btn-login {
            background: linear-gradient(135deg, var(--navy-mid), var(--accent));
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            padding: .85rem;
            width: 100%;
            transition: transform .15s, box-shadow .15s, opacity .15s;
            position: relative;
            overflow: hidden;
        }
        .btn-login::after {
            content: '';
            position: absolute; inset: 0;
            background: rgba(255,255,255,0);
            transition: background .2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30,58,95,.35);
        }
        .btn-login:hover::after { background: rgba(255,255,255,.06); }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 1rem;
            color: var(--text-muted);
            font-size: .78rem;
            margin: 1.25rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Role demo chips */
        .demo-chips { display: flex; flex-wrap: wrap; gap: .5rem; justify-content: center; }
        .demo-chip {
            background: transparent;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .4rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .18s;
            display: flex; align-items: center; gap: 5px;
        }
        .demo-chip:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(46,134,171,.06);
        }
        .demo-chip.admin-chip:hover   { border-color: #f59e0b; color: #f59e0b; background: rgba(245,158,11,.06); }
        .demo-chip.dosen-chip:hover   { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,.06); }
        .demo-chip.mhs-chip:hover     { border-color: #10b981; color: #10b981; background: rgba(16,185,129,.06); }

        /* Error alert */
        .alert-auth {
            background: rgba(220,53,69,.08);
            border: 1px solid rgba(220,53,69,.25);
            border-radius: 12px;
            color: #dc3545;
            font-size: .85rem;
            padding: .75rem 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

    {{-- ── LEFT PANEL ─────────────────────────────────────────── --}}
    <div class="left-panel">
        <div class="geo geo-1"></div>
        <div class="geo geo-2"></div>
        <div class="geo geo-3"></div>
        <div class="geo geo-4"></div>

        <div class="brand-logo">
            <div class="icon-wrap">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1>Sistem Evaluasi<br>Pembelajaran</h1>
            <p>Platform penilaian akademik terpadu</p>
        </div>

        <div class="panel-tagline">
            <h2>Kelola nilai<br>dengan <span>presisi</span><br>dan kemudahan.</h2>
            <p>Satu platform untuk dosen input nilai,<br>admin kelola data, dan mahasiswa pantau KHS.</p>
            <div class="role-pills">
                <div class="role-pill"><i class="fas fa-shield-alt"></i>Admin</div>
                <div class="role-pill"><i class="fas fa-chalkboard-teacher"></i>Dosen</div>
                <div class="role-pill"><i class="fas fa-user-graduate"></i>Mahasiswa</div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT PANEL ─────────────────────────────────────────── --}}
    <div class="right-panel">

        {{-- Dark mode toggle --}}
        <button class="theme-toggle-btn" id="btn-theme" type="button">
            <i id="theme-icon" class="fas fa-moon"></i>
            <span id="theme-label">Dark</span>
        </button>

        <div class="login-card">
            {{-- Heading --}}
            <div class="card-heading mb-4">
                <h2>Selamat datang 👋</h2>
                <p>Masuk untuk melanjutkan ke dashboard Anda</p>
            </div>

            {{-- Session error --}}
            @if ($errors->any())
            <div class="alert-auth mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            {{-- Status message --}}
            @if (session('status'))
            <div class="alert alert-success rounded-3 py-2 mb-3 small">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                {{-- Email --}}
                <div class="mb-3 input-icon-wrap">
                    <div class="form-floating">
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}"
                               autocomplete="email"
                               required>
                        <label for="email"><i class="fas fa-envelope me-2 opacity-50"></i>Alamat Email</label>
                    </div>
                    <i class="fas fa-at field-icon" style="top: 30px; pointer-events:none"></i>
                </div>

                {{-- Password --}}
                <div class="mb-1 input-icon-wrap">
                    <div class="form-floating">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password"
                               autocomplete="current-password"
                               required>
                        <label for="password"><i class="fas fa-lock me-2 opacity-50"></i>Password</label>
                    </div>
                    <i class="fas fa-eye field-icon" id="toggle-pwd" title="Tampilkan password"
                       style="top: 30px; right: 14px"></i>
                </div>

                {{-- Remember & Forgot --}}
                <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember"
                               style="color:var(--text-muted)">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="small text-decoration-none" style="color:var(--accent)">
                        Lupa password?
                    </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="btn-submit">
                    <span id="btn-text">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
                    </span>
                    <span id="btn-loading" class="d-none">
                        <span class="spinner-border spinner-border-sm me-2"></span>Memproses...
                    </span>
                </button>
            </form>

            {{-- Quick login demo chips --}}
            <div class="divider">Akun Demo</div>
            <div class="demo-chips">
                <button class="demo-chip admin-chip"
                        onclick="fillLogin('admin@evaluasi.ac.id','password')">
                    <i class="fas fa-shield-alt"></i>Admin
                </button>
                <button class="demo-chip dosen-chip"
                        onclick="fillLogin('budi.prasetyo@evaluasi.ac.id','123456')">
                    <i class="fas fa-chalkboard-teacher"></i>Dosen
                </button>
                <button class="demo-chip mhs-chip"
                        onclick="fillLogin('2210001@student.ac.id','2210001')">
                    <i class="fas fa-user-graduate"></i>Mahasiswa
                </button>
            </div>
        </div>

        {{-- Footer --}}
        <p class="mt-4" style="font-size:.75rem; color:var(--text-muted); text-align:center">
            &copy; {{ date('Y') }} Sistem Evaluasi Pembelajaran. All rights reserved.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ── Theme toggle ────────────────────────────────────────────
    (function () {
        const html  = document.documentElement;
        const btn   = document.getElementById('btn-theme');
        const icon  = document.getElementById('theme-icon');
        const label = document.getElementById('theme-label');
        const KEY   = 'app-theme';

        function apply(t) {
            html.setAttribute('data-bs-theme', t);
            if (t === 'dark') {
                icon.className  = 'fas fa-sun';
                label.textContent = 'Light';
            } else {
                icon.className  = 'fas fa-moon';
                label.textContent = 'Dark';
            }
            localStorage.setItem(KEY, t);
        }

        btn.addEventListener('click', function () {
            apply(html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
        });

        apply(localStorage.getItem(KEY) || 'light');
    })();

    // ── Toggle password visibility ───────────────────────────
    document.getElementById('toggle-pwd').addEventListener('click', function () {
        const inp = document.getElementById('password');
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        this.className = show ? 'fas fa-eye-slash field-icon' : 'fas fa-eye field-icon';
        this.style.cssText = 'top:30px; right:14px';
    });

    // ── Submit loading state ─────────────────────────────────
    document.getElementById('login-form').addEventListener('submit', function () {
        document.getElementById('btn-text').classList.add('d-none');
        document.getElementById('btn-loading').classList.remove('d-none');
    });

    // ── Demo chips autofill ───────────────────────────────────
    function fillLogin(email, pass) {
        document.getElementById('email').value    = email;
        document.getElementById('password').value = pass;
        document.getElementById('email').dispatchEvent(new Event('input'));
    }
    </script>
</body>
</html>