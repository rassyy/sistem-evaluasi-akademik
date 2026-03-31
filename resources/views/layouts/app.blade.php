<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Evaluasi Pembelajaran')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ============================================================
           CSS CUSTOM PROPERTIES — otomatis berganti saat data-bs-theme berubah
           ============================================================ */
        [data-bs-theme="light"] {
            --app-primary: #1E3A5F;
            --app-accent: #2E86AB;
            --app-sidebar-bg: #e8edf3;
            --app-sidebar-border: #c5d0dc;
            --app-link-color: #1E3A5F;
            --app-link-hover-bg: #d0dbe8;
            --app-link-hover-clr: #0f2440;
            --app-link-active-bg: #1E3A5F;
            --app-link-active-clr: #ffffff;
            --app-muted-label: #4a6080;
        }

        [data-bs-theme="dark"] {
            --app-primary: #4a9fd4;
            --app-accent: #5bc8f5;
            --app-sidebar-bg: #1a1f2e;
            --app-sidebar-border: #2d3550;
            --app-link-color: #c8dff0;
            --app-link-hover-bg: #2a3550;
            --app-link-hover-clr: #ffffff;
            --app-link-active-bg: #4a9fd4;
            --app-link-active-clr: #ffffff;
            --app-muted-label: #8ca8c5;
        }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .app-navbar {
            background: var(--app-primary) !important;
        }

        .app-navbar .navbar-brand,
        .app-navbar .nav-link {
            color: #ffffff !important;
        }

        .app-navbar .nav-link:hover {
            color: #a8d8ea !important;
        }

        /* Tombol toggle tema */
        #btn-theme-toggle {
            border: 1.5px solid rgba(255, 255, 255, 0.45);
            color: #ffffff;
            background: transparent;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background .2s, border-color .2s;
        }

        #btn-theme-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.75);
        }

        /* ============================================================
           SIDEBAR
           ============================================================ */
        .sidebar {
            background: var(--app-sidebar-bg);
            min-height: calc(100vh - 56px);
            border-right: 1px solid var(--app-sidebar-border);
            padding: 1.25rem 0;
            transition: background .3s, border-color .3s;
        }

        /* Label section kecil ("Master Data") */
        .sidebar .sidebar-label {
            color: var(--app-muted-label);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: .5rem 1.25rem .25rem;
        }

        /* Nav link default */
        .sidebar .nav-link {
            color: var(--app-link-color);
            font-weight: 500;
            padding: .6rem 1.25rem;
            border-radius: 0 24px 24px 0;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .18s, color .18s;
        }

        .sidebar .nav-link i {
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        /* Hover */
        .sidebar .nav-link:hover {
            background: var(--app-link-hover-bg);
            color: var(--app-link-hover-clr);
        }

        /* Active */
        .sidebar .nav-link.active {
            background: var(--app-link-active-bg);
            color: var(--app-link-active-clr) !important;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .18);
        }

        /* ============================================================
           MAIN CONTENT & CARD
           ============================================================ */
        .main-content {
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 2px 12px rgba(30, 58, 95, .08);
            border-radius: 12px;
        }

        [data-bs-theme="dark"] .card {
            box-shadow: 0 2px 12px rgba(0, 0, 0, .35);
        }

        .card-header {
            background: var(--app-primary);
            color: #ffffff;
            border-radius: 12px 12px 0 0 !important;
        }

        /* ============================================================
           BADGE GRADE
           ============================================================ */
        .badge-A {
            background: #198754;
        }

        .badge-Bp {
            background: #0d6efd;
        }

        .badge-B {
            background: #0dcaf0;
            color: #000;
        }

        .badge-Cp {
            background: #ffc107;
            color: #000;
        }

        .badge-C {
            background: #fd7e14;
        }

        .badge-D {
            background: #dc3545;
        }

        .badge-E {
            background: #6c757d;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ================================================================
    NAVBAR
    ================================================================ --}}
    <nav class="navbar navbar-expand-lg app-navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('nilai.index') }}">
                <i class="fas fa-graduation-cap me-2"></i>Evaluasi Pembelajaran
            </a>

            {{-- Tombol toggle tema (pojok kanan navbar) --}}
            <button id="btn-theme-toggle" type="button" title="Ganti tema">
                {{-- Icon akan diisi oleh JS --}}
                <i id="theme-icon" class="fas fa-sun"></i>
                <span id="theme-label">Light</span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            {{-- ============================================================
            SIDEBAR
            ============================================================ --}}
            <div class="col-md-2 sidebar d-none d-md-block">
                <ul class="nav flex-column mt-2">

                    <li class="nav-item">
                        <a href="{{ route('nilai.index') }}"
                            class="nav-link {{ request()->routeIs('nilai.index') ? 'active' : '' }}">
                            <i class="fas fa-table"></i>Data Nilai
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('nilai.create') }}"
                            class="nav-link {{ request()->routeIs('nilai.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>Input Nilai
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <span class="sidebar-label">Master Data</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('mata-kuliah.index') }}"
                            class="nav-link {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>Mata Kuliah
                        </a>
                    </li>

                </ul>
            </div>

            {{-- ============================================================
            MAIN CONTENT
            ============================================================ --}}
            <div class="col-md-10 main-content">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ================================================================
    DARK / LIGHT MODE — Vanilla JS
    ================================================================ --}}
    <script>
        (function () {
            /* ── Elemen ─────────────────────────────────────────────── */
            const html = document.documentElement;   // <html data-bs-theme="…">
            const btn = document.getElementById('btn-theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const themeLbl = document.getElementById('theme-label');

            /* ── Konstanta ──────────────────────────────────────────── */
            const STORAGE_KEY = 'app-theme';              // key localStorage
            const THEMES = {
                light: {
                    attr: 'light',
                    iconClass: 'fas fa-sun',
                    label: 'Light',
                    nextTheme: 'dark',
                },
                dark: {
                    attr: 'dark',
                    iconClass: 'fas fa-moon',
                    label: 'Dark',
                    nextTheme: 'light',
                },
            };

            /* ── Baca preferensi tersimpan, fallback ke 'light' ─────── */
            const savedTheme = localStorage.getItem(STORAGE_KEY) || 'light';

            /* ── Terapkan tema ke halaman ───────────────────────────── */
            function applyTheme(theme) {
                const cfg = THEMES[theme] || THEMES.light;

                // 1. Ganti atribut Bootstrap
                html.setAttribute('data-bs-theme', cfg.attr);

                // 2. Ganti icon
                themeIcon.className = cfg.iconClass;

                // 3. Ganti label teks
                themeLbl.textContent = cfg.label;

                // 4. Simpan ke localStorage
                localStorage.setItem(STORAGE_KEY, theme);
            }

            /* ── Handler klik tombol ────────────────────────────────── */
            btn.addEventListener('click', function () {
                const current = localStorage.getItem(STORAGE_KEY) || 'light';
                const next = THEMES[current]?.nextTheme || 'light';
                applyTheme(next);
            });

            /* ── Inisialisasi saat halaman pertama kali dimuat ──────── */
            applyTheme(savedTheme);
        })();
    </script>

    @stack('scripts')
</body>

</html>