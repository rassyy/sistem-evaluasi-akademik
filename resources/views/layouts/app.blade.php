<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Evaluasi Pembelajaran')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ── CSS Variables ───────────────────────────────────── */
        [data-bs-theme="light"] {
            --app-primary: #1E3A5F;
            --app-accent: #2E86AB;
            --app-sidebar-bg: #f0f4f8;
            --app-sidebar-border: #dde5ee;
            --app-link-color: #2d4a6e;
            --app-link-hover-bg: #dce6f0;
            --app-link-hover-clr: #0f2440;
            --app-link-active-bg: #1E3A5F;
            --app-link-active-clr: #ffffff;
            --app-muted-label: #7a96b0;
            --app-body-bg: #f7f9fc;
            --app-topbar-bg: #ffffff;
            --app-topbar-border: #e8edf4;
            --app-shadow-sm: 0 1px 3px rgba(15, 39, 68, .07), 0 1px 2px rgba(15, 39, 68, .06);
            --app-shadow-md: 0 4px 16px rgba(15, 39, 68, .09);
        }

        [data-bs-theme="dark"] {
            --app-primary: #4a9fd4;
            --app-accent: #5bc8f5;
            --app-sidebar-bg: #111827;
            --app-sidebar-border: #1f2937;
            --app-link-color: #94b8d8;
            --app-link-hover-bg: #1f2d42;
            --app-link-hover-clr: #e2e8f0;
            --app-link-active-bg: #1e3a5f;
            --app-link-active-clr: #ffffff;
            --app-muted-label: #4a6580;
            --app-body-bg: #0d1117;
            --app-topbar-bg: #111827;
            --app-topbar-border: #1f2937;
            --app-shadow-sm: 0 1px 3px rgba(0, 0, 0, .3);
            --app-shadow-md: 0 4px 16px rgba(0, 0, 0, .4);
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--app-body-bg);
            font-size: .9rem;
        }

        /* ── Top Bar ─────────────────────────────────────────── */
        .app-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 60px;
            background: var(--app-topbar-bg);
            border-bottom: 1px solid var(--app-topbar-border);
            box-shadow: var(--app-shadow-sm);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1rem;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .topbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--app-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .topbar-brand .brand-name {
            font-weight: 800;
            font-size: .95rem;
            color: var(--app-primary);
            letter-spacing: -.02em;
            line-height: 1.2;
        }

        .topbar-brand .brand-sub {
            font-size: .68rem;
            color: var(--app-muted-label);
            display: block;
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: var(--app-topbar-border);
        }

        .topbar-spacer {
            flex: 1;
        }

        /* Theme toggle */
        #btn-theme-toggle {
            background: transparent;
            border: 1.5px solid var(--app-topbar-border);
            color: var(--app-muted-label);
            border-radius: 9px;
            padding: 5px 12px;
            font-size: .78rem;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all .2s;
        }

        #btn-theme-toggle:hover {
            border-color: var(--app-accent);
            color: var(--app-accent);
        }

        /* User dropdown */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: transparent;
            border: 1.5px solid var(--app-topbar-border);
            border-radius: 10px;
            padding: .35rem .75rem;
            cursor: pointer;
            transition: all .2s;
        }

        .topbar-user:hover {
            border-color: var(--app-accent);
        }

        .topbar-user .user-avatar {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--app-primary), var(--app-accent));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .topbar-user .user-info {
            text-align: left;
        }

        .topbar-user .user-name {
            font-size: .8rem;
            font-weight: 700;
            color: var(--bs-body-color);
            line-height: 1.2;
            display: block;
        }

        .topbar-user .user-role {
            font-size: .65rem;
            color: var(--app-muted-label);
            display: block;
            text-transform: capitalize;
        }

        /* Hamburger (mobile) */
        #sidebar-toggle {
            display: none;
            background: transparent;
            border: 1.5px solid var(--app-topbar-border);
            color: var(--app-muted-label);
            border-radius: 9px;
            padding: 5px 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            #sidebar-toggle {
                display: flex;
                align-items: center;
            }
        }

        /* ── Sidebar ─────────────────────────────────────────── */
        .app-sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--app-sidebar-bg);
            border-right: 1px solid var(--app-sidebar-border);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 1rem 0 2rem;
            transition: transform .25s cubic-bezier(.22, 1, .36, 1), background .3s;
            z-index: 1020;
        }

        /* Scrollbar */
        .app-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .app-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .app-sidebar::-webkit-scrollbar-thumb {
            background: var(--app-sidebar-border);
            border-radius: 4px;
        }

        /* Section label */
        .sidebar-section-label {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--app-muted-label);
            padding: .9rem 1.25rem .3rem;
            display: block;
        }

        /* Nav link */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .55rem 1rem .55rem 1.25rem;
            margin: 1px .75rem 1px 0;
            border-radius: 0 12px 12px 0;
            color: var(--app-link-color);
            text-decoration: none;
            font-weight: 500;
            font-size: .875rem;
            transition: background .15s, color .15s;
            position: relative;
        }

        .sidebar-link .link-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            flex-shrink: 0;
            transition: background .15s, color .15s;
        }

        .sidebar-link:hover {
            background: var(--app-link-hover-bg);
            color: var(--app-link-hover-clr);
        }

        .sidebar-link:hover .link-icon {
            background: rgba(46, 134, 171, .12);
            color: var(--app-accent);
        }

        .sidebar-link.active {
            background: var(--app-link-active-bg);
            color: var(--app-link-active-clr) !important;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(15, 39, 68, .2);
        }

        .sidebar-link.active .link-icon {
            background: rgba(255, 255, 255, .15);
            color: #fff;
        }

        /* Left accent bar on active */
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 4px;
            bottom: 4px;
            width: 3px;
            background: var(--app-accent);
            border-radius: 0 3px 3px 0;
        }

        /* Role badge */
        .sidebar-role-badge {
            margin: 0 1.25rem .75rem;
            padding: .5rem .85rem;
            border-radius: 10px;
            font-size: .72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sidebar-role-badge.admin {
            background: rgba(245, 158, 11, .1);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, .25);
        }

        .sidebar-role-badge.dosen {
            background: rgba(59, 130, 246, .1);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, .2);
        }

        .sidebar-role-badge.mahasiswa {
            background: rgba(16, 185, 129, .1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, .2);
        }

        [data-bs-theme="dark"] .sidebar-role-badge.admin {
            background: rgba(245, 158, 11, .15);
            color: #fbbf24;
        }

        [data-bs-theme="dark"] .sidebar-role-badge.dosen {
            background: rgba(59, 130, 246, .15);
            color: #60a5fa;
        }

        [data-bs-theme="dark"] .sidebar-role-badge.mahasiswa {
            background: rgba(16, 185, 129, .15);
            color: #34d399;
        }

        /* Mobile sidebar */
        @media (max-width: 768px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.open {
                transform: translateX(0);
            }
        }

        /* ── Main content ────────────────────────────────────── */
        .app-main {
            margin-left: 240px;
            margin-top: 60px;
            padding: 1.75rem 2rem;
            min-height: calc(100vh - 60px);
            transition: margin-left .25s;
        }

        @media (max-width: 768px) {
            .app-main {
                margin-left: 0;
                padding: 1.25rem;
            }
        }

        /* ── Card overrides ──────────────────────────────────── */
        .card {
            border: 1px solid var(--app-topbar-border);
            border-radius: 14px;
            box-shadow: var(--app-shadow-sm);
        }

        .card-header {
            background: var(--app-primary);
            color: #fff;
            border-radius: 13px 13px 0 0 !important;
            border-bottom: none;
            padding: .9rem 1.25rem;
            font-weight: 600;
            font-size: .875rem;
        }

        /* ── Badge grades ────────────────────────────────────── */
        .badge-A {
            background: #198754;
            color: #fff;
        }

        .badge-Bp {
            background: #0d6efd;
            color: #fff;
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
            color: #fff;
        }

        .badge-D {
            background: #dc3545;
            color: #fff;
        }

        .badge-E {
            background: #6c757d;
            color: #fff;
        }

        /* ── Overlay (mobile) ───────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 1015;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ════════════════════════════════════════════════
    TOP BAR
    ════════════════════════════════════════════════ --}}
    <header class="app-topbar">

        {{-- Mobile hamburger --}}
        <button id="sidebar-toggle" type="button" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Brand --}}
        <a href="/" class="topbar-brand">
            <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <span class="brand-name">Evaluasi Pembelajaran</span>
                <span class="brand-sub">Sistem Penilaian Akademik</span>
            </div>
        </a>

        <div class="topbar-spacer"></div>

        {{-- Theme toggle --}}
        <button id="btn-theme-toggle" type="button">
            <i id="theme-icon" class="fas fa-moon"></i>
            <span id="theme-label">Dark</span>
        </button>

        @auth
            {{-- User dropdown --}}
            <div class="topbar-divider d-none d-md-block"></div>
            <div class="dropdown">
                <div class="topbar-user" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info d-none d-md-block">
                        <span class="user-name">{{ Str::limit(auth()->user()->name, 18) }}</span>
                        <span class="user-role">{{ auth()->user()->role }}</span>
                    </div>
                    <i class="fas fa-chevron-down ms-1" style="font-size:.65rem; color:var(--app-muted-label)"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                    style="min-width:200px; border-radius:12px; border:1px solid var(--app-topbar-border)">
                    <li class="px-3 pt-2 pb-1">
                        <div class="fw-bold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ auth()->user()->email }}</div>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger py-2">
                                <i class="fas fa-sign-out-alt fa-fw"></i>Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </header>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    {{-- ════════════════════════════════════════════════
    SIDEBAR
    ════════════════════════════════════════════════ --}}
    @auth
        <aside class="app-sidebar" id="app-sidebar">

            {{-- Role badge ──────────────────────────────── --}}
            @php $role = auth()->user()->role; @endphp
            <div class="sidebar-role-badge {{ $role }}">
                @if(auth()->user()->isAdmin())
                    <i class="fas fa-shield-alt"></i> Administrator
                @elseif(auth()->user()->isDosen())
                    <i class="fas fa-chalkboard-teacher"></i> Dosen
                @else
                    <i class="fas fa-user-graduate"></i> Mahasiswa
                @endif
            </div>

            {{-- ════ MENU MAHASISWA ══════════════════════ --}}
            @if(auth()->user()->isMahasiswa())

                <span class="sidebar-section-label">Akademik</span>
                <a href="{{ route('khs.index') }}" class="sidebar-link {{ request()->routeIs('khs.*') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-scroll"></i></span>
                    Hasil Studi (KHS)
                </a>

                {{-- ════ MENU DOSEN ═══════════════════════════ --}}
            @elseif(auth()->user()->isDosen())

                <span class="sidebar-section-label">Penilaian</span>
                <a href="{{ route('nilai.index') }}"
                    class="sidebar-link {{ request()->routeIs('nilai.index') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-table"></i></span>
                    Data Nilai Kelas
                </a>
                <a href="{{ route('nilai.create') }}"
                    class="sidebar-link {{ request()->routeIs('nilai.create') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-plus-circle"></i></span>
                    Input Nilai Kelas
                </a>

                {{-- ════ MENU ADMIN ═══════════════════════════ --}}
            @elseif(auth()->user()->isAdmin())

                <span class="sidebar-section-label">Penilaian</span>
                <a href="{{ route('nilai.index') }}"
                    class="sidebar-link {{ request()->routeIs('nilai.index') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-table-list"></i></span>
                    Semua Nilai
                </a>
                <a href="{{ route('nilai.create') }}"
                    class="sidebar-link {{ request()->routeIs('nilai.create') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-plus-circle"></i></span>
                    Input Nilai
                </a>

                <span class="sidebar-section-label">Master Data</span>
                <a href="{{ route('dosen.index') }}" class="sidebar-link {{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                    Data Dosen
                </a>
                <a href="{{ route('mahasiswa.index') }}"
                    class="sidebar-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-users"></i></span>
                    Data Mahasiswa
                </a>
                <a href="{{ route('mata-kuliah.index') }}"
                    class="sidebar-link {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-book-open"></i></span>
                    Mata Kuliah
                </a>

                <span class="sidebar-section-label">Utilitas</span>
                <a href="{{ route('mahasiswa.import.form') }}"
                    class="sidebar-link {{ request()->routeIs('mahasiswa.import*') ? 'active' : '' }}">
                    <span class="link-icon"><i class="fas fa-file-excel"></i></span>
                    Import Excel
                </a>
                <a href="{{ route('nilai.export') }}" class="sidebar-link">
                    <span class="link-icon"><i class="fas fa-file-arrow-down"></i></span>
                    Export Nilai
                </a>

            @endif
        </aside>
    @endauth

    {{-- ════════════════════════════════════════════════
    MAIN CONTENT
    ════════════════════════════════════════════════ --}}
    <main class="app-main" id="app-main">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle text-success fs-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-warning fs-5"></i>
                    <span>{!! nl2br(e(session('warning'))) !!}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Theme toggle ────────────────────────────────────────────────
        (function () {
            const html = document.documentElement;
            const btn = document.getElementById('btn-theme-toggle');
            const icon = document.getElementById('theme-icon');
            const label = document.getElementById('theme-label');
            const KEY = 'app-theme';

            const CFG = {
                light: { attr: 'light', ic: 'fas fa-moon', lb: 'Dark' },
                dark: { attr: 'dark', ic: 'fas fa-sun', lb: 'Light' },
            };

            function apply(t) {
                const c = CFG[t] || CFG.light;
                html.setAttribute('data-bs-theme', c.attr);
                icon.className = c.ic;
                label.textContent = c.lb;
                localStorage.setItem(KEY, t);
            }

            btn.addEventListener('click', () => apply(html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark'));
            apply(localStorage.getItem(KEY) || 'light');
        })();

        // ── Mobile sidebar toggle ───────────────────────────────────────
        (function () {
            const sidebar = document.getElementById('app-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle');
            if (!sidebar) return;

            function openSidebar() { sidebar.classList.add('open'); overlay.classList.add('show'); }
            function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('show'); }

            toggleBtn?.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
            overlay.addEventListener('click', closeSidebar);
        })();
    </script>

    @stack('scripts')
</body>

</html>