@extends('layouts.app')

@section('title', 'Dashboard — Kartu Hasil Studi')

@push('styles')
    <style>
        /* ── Fonts ───────────────────────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── Hero card ───────────────────────────────────────────── */
        .hero-card {
            background: linear-gradient(135deg, #0f2744 0%, #1E3A5F 50%, #2E86AB 100%);
            border-radius: 20px;
            padding: 2rem 2.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 8px 32px rgba(15, 39, 68, .25);
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            right: 80px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .hero-card .hero-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: rgba(255, 255, 255, .6);
            margin-bottom: .3rem;
        }

        .hero-card .hero-nama {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.2;
        }

        .hero-card .hero-nim {
            font-size: .85rem;
            color: rgba(255, 255, 255, .6);
            margin-top: .2rem;
        }

        .hero-card .hero-prodi {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 20px;
            padding: .25rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            margin-top: .75rem;
        }

        /* IPK meter */
        .ipk-meter {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .ipk-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: 3px solid rgba(255, 255, 255, .25);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .ipk-value {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
            color: #fff;
        }

        .ipk-label {
            font-size: .62rem;
            color: rgba(255, 255, 255, .6);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-top: 2px;
        }

        .ipk-predicate {
            font-size: .75rem;
            font-weight: 700;
            margin-top: .6rem;
            color: rgba(255, 255, 255, .85);
        }

        /* ── Stat grid ───────────────────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .stat-box {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .85rem;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
        }

        .stat-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
        }

        .stat-box .s-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .stat-box .s-val {
            font-size: 1.4rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-box .s-lbl {
            font-size: .7rem;
            color: var(--bs-secondary-color);
            margin-top: 2px;
        }

        /* ── Grade badge ─────────────────────────────────────────── */
        .grade-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            font-size: .95rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .g-A {
            background: #198754;
            color: #fff;
        }

        .g-Bp {
            background: #0d6efd;
            color: #fff;
        }

        .g-B {
            background: #0dcaf0;
            color: #000;
        }

        .g-Cp {
            background: #ffc107;
            color: #000;
        }

        .g-C {
            background: #fd7e14;
            color: #fff;
        }

        .g-D {
            background: #dc3545;
            color: #fff;
        }

        .g-E {
            background: #6c757d;
            color: #fff;
        }

        /* ── Progress bar (nilai) ────────────────────────────────── */
        .score-bar {
            height: 7px;
            border-radius: 4px;
            background: var(--bs-secondary-bg);
            overflow: hidden;
            margin-top: 4px;
        }

        .score-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width .8s cubic-bezier(.22, 1, .36, 1);
        }

        /* ── Distribution chart (CSS-only) ──────────────────────── */
        .dist-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .6rem;
        }

        .dist-label {
            width: 28px;
            font-size: .78rem;
            font-weight: 700;
            text-align: right;
            flex-shrink: 0;
        }

        .dist-bar-wrap {
            flex: 1;
            height: 18px;
            background: var(--bs-secondary-bg);
            border-radius: 5px;
            overflow: hidden;
        }

        .dist-bar {
            height: 100%;
            border-radius: 5px;
            display: flex;
            align-items: center;
            padding-left: 8px;
            font-size: .65rem;
            font-weight: 700;
            color: #fff;
            transition: width 1s cubic-bezier(.22, 1, .36, 1);
            min-width: 0;
        }

        .dist-count {
            font-size: .72rem;
            color: var(--bs-secondary-color);
            width: 55px;
            text-align: right;
            flex-shrink: 0;
        }

        /* ── Table ───────────────────────────────────────────────── */
        .nilai-table th {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--bs-secondary-color);
            padding: .7rem 1rem;
            border-bottom: 1px solid var(--bs-border-color);
            white-space: nowrap;
            background: var(--bs-tertiary-bg);
        }

        .nilai-table td {
            padding: .85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--bs-border-color-translucent);
            font-size: .875rem;
        }

        .nilai-table tbody tr:last-child td {
            border-bottom: none;
        }

        .nilai-table tbody tr {
            transition: background .12s;
        }

        .nilai-table tbody tr:hover {
            background: var(--bs-tertiary-bg);
        }

        /* ── Card defaults ───────────────────────────────────────── */
        .khs-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .khs-card .khs-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
            font-weight: 700;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ── Semester pill filter ────────────────────────────────── */
        .semester-filter {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .sem-pill {
            background: transparent;
            border: 1.5px solid var(--bs-border-color);
            border-radius: 20px;
            padding: .3rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            color: var(--bs-secondary-color);
            cursor: pointer;
            transition: all .15s;
        }

        .sem-pill.active,
        .sem-pill:hover {
            border-color: #1E3A5F;
            color: #1E3A5F;
            background: rgba(30, 58, 95, .07);
        }

        [data-bs-theme="dark"] .sem-pill.active,
        [data-bs-theme="dark"] .sem-pill:hover {
            border-color: #4a9fd4;
            color: #4a9fd4;
            background: rgba(74, 159, 212, .1);
        }

        /* ── Print ───────────────────────────────────────────────── */
        @media print {
            .no-print {
                display: none !important;
            }

            .hero-card {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .grade-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* ── Animasi masuk ───────────────────────────────────────── */
        .fade-in-up {
            animation: fadeInUp .45s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 {
            animation-delay: .08s;
        }

        .delay-2 {
            animation-delay: .16s;
        }

        .delay-3 {
            animation-delay: .24s;
        }

        .delay-4 {
            animation-delay: .32s;
        }
    </style>
@endpush

@section('content')

    @php
        /*
        |------------------------------------------------------------------
        | Data mahasiswa milik user yang sedang login
        | Logic dibatasi hanya pada mahasiswa_id = auth()->user()->mahasiswa->id
        |------------------------------------------------------------------
        */
        $mahasiswa = auth()->user()->mahasiswa;

        abort_unless($mahasiswa, 404, 'Data mahasiswa tidak ditemukan untuk akun ini.');

        // Ambil semua nilai milik mahasiswa ini
        $semuaNilai = $mahasiswa->nilais()
            ->with('mataKuliah')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester')
            ->get();

        // Statistik agregat
        $totalMatkul = $semuaNilai->count();
        $rataRata = $totalMatkul > 0 ? round($semuaNilai->avg('nilai_akhir'), 2) : 0;
        $totalSks = $semuaNilai->sum(fn($n) => $n->mataKuliah?->sks ?? 0);
        $nilaiMax = $totalMatkul > 0 ? $semuaNilai->max('nilai_akhir') : 0;
        $nilaiMin = $totalMatkul > 0 ? $semuaNilai->min('nilai_akhir') : 0;

        // Predikat berdasarkan rata-rata
        $predicate = match (true) {
            $rataRata >= 85 => ['Sangat Memuaskan', '#198754'],
            $rataRata >= 75 => ['Memuaskan', '#0d6efd'],
            $rataRata >= 61 => ['Cukup', '#ffc107'],
            $rataRata >= 50 => ['Kurang', '#fd7e14'],
            default => ['Tidak Memuaskan', '#dc3545'],
        };

        // Distribusi grade
        $distGrade = $semuaNilai->groupBy('nilai_huruf')->map->count();

        // Daftar semester unik untuk filter
        $semesters = $semuaNilai
            ->filter(fn($n) => $n->semester && $n->tahun_ajaran)
            ->map(fn($n) => $n->semester . ' ' . $n->tahun_ajaran)
            ->unique()
            ->values();
    @endphp

    {{-- ── Page header ──────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0" style="color:var(--app-primary, #1E3A5F)">
                <i class="fas fa-scroll me-2"></i>Kartu Hasil Studi
            </h4>
            <small class="text-muted">Rekap nilai akademik Anda</small>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-print me-1"></i>Cetak KHS
        </button>
    </div>

    {{-- ── Hero card ────────────────────────────────────────────────── --}}
    <div class="hero-card mb-4 fade-in-up">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <div class="hero-label">Kartu Hasil Studi</div>
                <div class="hero-nama">{{ $mahasiswa->nama }}</div>
                <div class="hero-nim">NIM: {{ $mahasiswa->nim }}</div>
                @if($mahasiswa->program_studi)
                    <div class="hero-prodi">
                        <i class="fas fa-building-columns" style="font-size:.7rem"></i>
                        {{ $mahasiswa->program_studi }}
                    </div>
                @endif
            </div>
            <div class="col-md-4 d-flex justify-content-md-end justify-content-start">
                <div class="ipk-meter">
                    <div class="ipk-circle">
                        <div class="ipk-value">{{ number_format($rataRata, 1) }}</div>
                        <div class="ipk-label">Rata-rata</div>
                    </div>
                    <div class="ipk-predicate">{{ $predicate[0] }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Stat grid ─────────────────────────────────────────────────── --}}
    <div class="stat-grid mb-4 fade-in-up delay-1">
        <div class="stat-box">
            <div class="s-icon" style="background:rgba(30,58,95,.1);color:#1E3A5F">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <div class="s-val">{{ $totalMatkul }}</div>
                <div class="s-lbl">Mata Kuliah</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="s-icon" style="background:rgba(46,134,171,.1);color:#2E86AB">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="s-val">{{ $totalSks }}</div>
                <div class="s-lbl">Total SKS</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="s-icon" style="background:rgba(25,135,84,.1);color:#198754">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
            <div>
                <div class="s-val">{{ number_format($nilaiMax, 1) }}</div>
                <div class="s-lbl">Nilai Tertinggi</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="s-icon" style="background:rgba(220,53,69,.1);color:#dc3545">
                <i class="fas fa-arrow-trend-down"></i>
            </div>
            <div>
                <div class="s-val">{{ number_format($nilaiMin, 1) }}</div>
                <div class="s-lbl">Nilai Terendah</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="s-icon" style="background:rgba(111,66,193,.1);color:#6f42c1">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <div class="s-val">{{ $distGrade->keys()->first() ?? '—' }}</div>
                <div class="s-lbl">Grade Terbanyak</div>
            </div>
        </div>
    </div>

    {{-- ── Main content: tabel + distribusi ────────────────────────── --}}
    <div class="row g-4">

        {{-- ── Tabel nilai ──────────────────────────────────────────── --}}
        <div class="col-lg-8 fade-in-up delay-2">
            <div class="khs-card">
                <div class="khs-card-header">
                    <i class="fas fa-table text-primary"></i>
                    Rincian Nilai Per Mata Kuliah

                    {{-- Filter semester (no-print) ──────────────────── --}}
                    @if($semesters->count() > 1)
                        <div class="ms-auto semester-filter no-print">
                            <button class="sem-pill active" data-filter="all">Semua</button>
                            @foreach($semesters as $sem)
                                <button class="sem-pill" data-filter="{{ $sem }}">{{ $sem }}</button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($totalMatkul === 0)
                    {{-- Empty state --}}
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                        <p class="fw-semibold mb-1">Belum ada nilai tercatat</p>
                        <small>Nilai akan muncul setelah dosen menginput penilaian Anda.</small>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table nilai-table mb-0" id="nilai-table">
                            <thead>
                                <tr>
                                    <th width="42" class="text-center">#</th>
                                    <th>Mata Kuliah</th>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">Tugas</th>
                                    <th class="text-center">UTS</th>
                                    <th class="text-center">UAS</th>
                                    <th style="min-width:130px">Nilai Akhir</th>
                                    <th class="text-center">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semuaNilai as $i => $n)
                                    @php
                                        $gKey = str_replace('+', 'p', $n->nilai_huruf);
                                        $barColor = match (true) {
                                            $n->nilai_akhir >= 85 => '#198754',
                                            $n->nilai_akhir >= 75 => '#0d6efd',
                                            $n->nilai_akhir >= 61 => '#ffc107',
                                            $n->nilai_akhir >= 50 => '#fd7e14',
                                            default => '#dc3545',
                                        };
                                        $semLabel = trim(($n->semester ?? '') . ' ' . ($n->tahun_ajaran ?? ''));
                                    @endphp
                                    <tr data-semester="{{ $semLabel }}">
                                        <td class="text-center text-muted small">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold" style="font-size:.875rem">
                                                {{ $n->mataKuliah->nama_matakuliah ?? '—' }}
                                            </div>
                                            <div class="d-flex align-items-center gap-1 mt-1 flex-wrap">
                                                <span class="badge rounded-pill bg-secondary" style="font-size:.65rem">
                                                    {{ $n->mataKuliah->kode_matakuliah ?? '' }}
                                                </span>
                                                @if($semLabel)
                                                    <span style="font-size:.68rem; color:var(--bs-secondary-color)">
                                                        · {{ $semLabel }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $n->mataKuliah->sks ?? '—' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($n->rata_rata_tugas, 1) }}</strong>
                                            <div style="font-size:.67rem;color:var(--bs-secondary-color)">
                                                {{ $n->bobot_tugas }}%
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($n->nilai_uts, 1) }}</strong>
                                            <div style="font-size:.67rem;color:var(--bs-secondary-color)">
                                                {{ $n->bobot_uts }}%
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($n->nilai_uas, 1) }}</strong>
                                            <div style="font-size:.67rem;color:var(--bs-secondary-color)">
                                                {{ $n->bobot_uas }}%
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold" style="min-width:38px;font-size:1rem">
                                                    {{ number_format($n->nilai_akhir, 1) }}
                                                </span>
                                                <div class="score-bar flex-grow-1">
                                                    <div class="score-bar-fill" data-width="{{ $n->nilai_akhir }}"
                                                        style="width:0%; background:{{ $barColor }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="grade-badge g-{{ $gKey }}">
                                                {{ $n->nilai_huruf }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            {{-- Baris total --}}
                            <tfoot>
                                <tr style="background:var(--bs-tertiary-bg)">
                                    <td colspan="2" class="fw-bold text-end pe-3" style="font-size:.8rem">
                                        RATA-RATA KESELURUHAN
                                    </td>
                                    <td class="text-center fw-bold">{{ $totalSks }}</td>
                                    <td colspan="3"></td>
                                    <td>
                                        <span class="fw-bold" style="font-size:1.1rem">
                                            {{ number_format($rataRata, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $avgGrade = \App\Models\Nilai::konversiHuruf($rataRata);
                                            $avgGKey = str_replace('+', 'p', $avgGrade);
                                        @endphp
                                        <div class="grade-badge g-{{ $avgGKey }}">
                                            {{ $avgGrade }}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Distribusi & tabel konversi ─────────────────────────── --}}
        <div class="col-lg-4 fade-in-up delay-3">

            {{-- Distribusi grade --}}
            <div class="khs-card mb-4">
                <div class="khs-card-header">
                    <i class="fas fa-chart-bar text-primary"></i>Distribusi Grade
                </div>
                <div class="p-3">
                    @php
                        $gradeColors = [
                            'A' => '#198754',
                            'B+' => '#0d6efd',
                            'B' => '#0dcaf0',
                            'C+' => '#ffc107',
                            'C' => '#fd7e14',
                            'D' => '#dc3545',
                            'E' => '#6c757d',
                        ];
                    @endphp
                    @foreach($gradeColors as $g => $color)
                        @php
                            $cnt = $distGrade[$g] ?? 0;
                            $pct = $totalMatkul > 0 ? ($cnt / $totalMatkul) * 100 : 0;
                        @endphp
                        <div class="dist-row">
                            <div class="dist-label" style="color:{{ $color }}">{{ $g }}</div>
                            <div class="dist-bar-wrap">
                                <div class="dist-bar" data-width="{{ $pct }}" style="width:0%; background:{{ $color }}">
                                    @if($pct > 15){{ round($pct) }}%@endif
                                </div>
                            </div>
                            <div class="dist-count">{{ $cnt }} MK</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tabel konversi nilai --}}
            <div class="khs-card fade-in-up delay-4">
                <div class="khs-card-header">
                    <i class="fas fa-info-circle text-primary"></i>Konversi Nilai
                </div>
                <div class="p-3">
                    <table class="table table-sm table-borderless mb-0" style="font-size:.8rem">
                        <thead>
                            <tr style="border-bottom:1px solid var(--bs-border-color)">
                                <th class="ps-0" style="font-size:.68rem;color:var(--bs-secondary-color)">Rentang</th>
                                <th class="text-center" style="font-size:.68rem;color:var(--bs-secondary-color)">Grade</th>
                                <th style="font-size:.68rem;color:var(--bs-secondary-color)">Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $konversi = [
                                    ['85 – 100', 'A', 'g-A', 'Sangat Baik'],
                                    ['80 – <85', 'B+', 'g-Bp', 'Hampir Sangat Baik'],
                                    ['75 – <80', 'B', 'g-B', 'Baik'],
                                    ['70 – <75', 'C+', 'g-Cp', 'Hampir Baik'],
                                    ['61 – <70', 'C', 'g-C', 'Cukup'],
                                    ['50 – 60', 'D', 'g-D', 'Kurang'],
                                    ['< 50', 'E', 'g-E', 'Tidak Lulus'],
                                ];
                            @endphp
                            @foreach($konversi as [$range, $grade, $cls, $label])
                                <tr>
                                    <td class="ps-0 text-muted">{{ $range }}</td>
                                    <td class="text-center">
                                        <span class="grade-badge {{ $cls }}" style="width:28px;height:28px;font-size:.75rem">
                                            {{ $grade }}
                                        </span>
                                    </td>
                                    <td>{{ $label }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Animasikan progress bar setelah halaman muat ──────────
            setTimeout(() => {
                document.querySelectorAll('.score-bar-fill[data-width]').forEach(el => {
                    el.style.width = el.dataset.width + '%';
                });
                document.querySelectorAll('.dist-bar[data-width]').forEach(el => {
                    el.style.width = el.dataset.width + '%';
                });
            }, 300);

            // ── Filter semester ───────────────────────────────────────
            document.querySelectorAll('.sem-pill').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.sem-pill').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;
                    document.querySelectorAll('#nilai-table tbody tr').forEach(tr => {
                        const match = filter === 'all' || tr.dataset.semester === filter;
                        tr.style.display = match ? '' : 'none';
                    });
                });
            });

        });
    </script>
@endpush