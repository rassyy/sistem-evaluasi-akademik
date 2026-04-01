@extends('layouts.app')

@section('title', 'Kartu Hasil Studi (KHS)')

@push('styles')
<style>
    /* ── Kartu ringkasan atas ─────────────────────────────────── */
    .stat-card {
        border: none;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
    }

    .stat-card .stat-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        opacity: .85;
    }

    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .stat-card .stat-sub {
        font-size: .78rem;
        opacity: .75;
        margin-top: .15rem;
    }

    /* ── Badge grade ──────────────────────────────────────────── */
    .badge-A {
        background: #198754;
    }

    .badge-Bp {
        background: #0d6efd;
    }

    .badge-B {
        background: #0dcaf0;
        color: #000 !important;
    }

    .badge-Cp {
        background: #ffc107;
        color: #000 !important;
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

    /* ── Progres bar nilai ────────────────────────────────────── */
    .nilai-bar {
        height: 6px;
        border-radius: 4px;
        background: var(--bs-secondary-bg);
        overflow: hidden;
    }

    .nilai-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width .6s ease;
    }

    /* ── Print ────────────────────────────────────────────────── */
    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
</style>
@endpush

@section('content')

{{-- ── Header ────────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-scroll me-2"></i>Kartu Hasil Studi (KHS)
        </h4>
        <small class="text-muted">
            {{ $mahasiswa->nim }} &nbsp;·&nbsp; {{ $mahasiswa->nama }}
            @if($mahasiswa->program_studi)
            &nbsp;·&nbsp; {{ $mahasiswa->program_studi }}
            @endif
        </small>
    </div>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm no-print">
        <i class="fas fa-print me-1"></i>Cetak
    </button>
</div>

{{-- ── Stat cards ringkasan ────────────────────────────────────── --}}
@php
$allNilais = $mahasiswa->nilais()->with('mataKuliah')->get();
$totalMatkul = $allNilais->count();
$ipk = $totalMatkul > 0 ? $allNilais->avg('nilai_akhir') : 0;

// Distribusi grade
$gradeCount = $allNilais->groupBy('nilai_huruf')->map->count();

// Total SKS (jika relasi mataKuliah ada)
$totalSks = $allNilais->sum(fn($n) => $n->mataKuliah->sks ?? 0);
@endphp

<div class="row g-3 mb-4">
    {{-- IPK --}}
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #1E3A5F, #2E86AB);">
            <div class="stat-label">Rata-rata Nilai</div>
            <div class="stat-value">{{ number_format($ipk, 2) }}</div>
            <div class="stat-sub">dari 100.00</div>
        </div>
    </div>

    {{-- Total Matkul --}}
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #198754, #20c997);">
            <div class="stat-label">Mata Kuliah</div>
            <div class="stat-value">{{ $totalMatkul }}</div>
            <div class="stat-sub">{{ $totalSks }} SKS total</div>
        </div>
    </div>

    {{-- Grade terbanyak --}}
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #6f42c1, #a855f7);">
            <div class="stat-label">Grade Terbanyak</div>
            <div class="stat-value">{{ $gradeCount->keys()->first() ?? '—' }}</div>
            <div class="stat-sub">{{ $gradeCount->first() ?? 0 }} mata kuliah</div>
        </div>
    </div>

    {{-- Nilai tertinggi --}}
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card text-white" style="background: linear-gradient(135deg, #dc3545, #f97316);">
            <div class="stat-label">Nilai Tertinggi</div>
            <div class="stat-value">{{ $allNilais->max('nilai_akhir') ? number_format($allNilais->max('nilai_akhir'), 1)
                : '—' }}</div>
            <div class="stat-sub">Nilai terendah: {{ $allNilais->min('nilai_akhir') ?
                number_format($allNilais->min('nilai_akhir'), 1) : '—' }}</div>
        </div>
    </div>
</div>

{{-- ── Tabel KHS ────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <i class="fas fa-table me-2"></i>Rincian Nilai Per Mata Kuliah
        </h6>
        <span class="badge bg-light text-dark">{{ $nilais->total() }} data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="table-light">
                        <th width="50" class="text-center">No</th>
                        <th>Mata Kuliah</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Tugas</th>
                        <th class="text-center">UTS</th>
                        <th class="text-center">UAS</th>
                        <th class="text-center" width="180">Nilai Akhir</th>
                        <th class="text-center">Grade</th>
                        <th class="text-center">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais as $i => $n)
                    @php
                    $gradeClass = match($n->nilai_huruf) {
                    'A' => 'badge-A',
                    'B+' => 'badge-Bp',
                    'B' => 'badge-B',
                    'C+' => 'badge-Cp',
                    'C' => 'badge-C',
                    'D' => 'badge-D',
                    default => 'badge-E',
                    };

                    // Warna progress bar
                    $barColor = match(true) {
                    $n->nilai_akhir >= 80 => '#198754',
                    $n->nilai_akhir >= 70 => '#0d6efd',
                    $n->nilai_akhir >= 60 => '#ffc107',
                    default => '#dc3545',
                    };
                    @endphp
                    <tr>
                        <td class="text-center text-muted small">{{ $nilais->firstItem() + $i }}</td>
                        <td>
                            <span class="badge bg-secondary me-1">
                                {{ $n->mataKuliah->kode_matakuliah ?? '—' }}
                            </span>
                            <span class="fw-semibold small">
                                {{ $n->mataKuliah->nama_matakuliah ?? '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark">
                                {{ $n->mataKuliah->sks ?? '—' }}
                            </span>
                        </td>

                        {{-- Nilai Tugas --}}
                        <td class="text-center">
                            <strong>{{ number_format($n->rata_rata_tugas, 1) }}</strong>
                            <div class="text-muted" style="font-size:.7rem">{{ $n->bobot_tugas }}%</div>
                        </td>

                        {{-- Nilai UTS --}}
                        <td class="text-center">
                            <strong>{{ number_format($n->nilai_uts, 1) }}</strong>
                            <div class="text-muted" style="font-size:.7rem">{{ $n->bobot_uts }}%</div>
                        </td>

                        {{-- Nilai UAS --}}
                        <td class="text-center">
                            <strong>{{ number_format($n->nilai_uas, 1) }}</strong>
                            <div class="text-muted" style="font-size:.7rem">{{ $n->bobot_uas }}%</div>
                        </td>

                        {{-- Nilai Akhir + progress bar --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold" style="min-width: 42px; font-size:1.05rem">
                                    {{ number_format($n->nilai_akhir, 1) }}
                                </span>
                                <div class="nilai-bar flex-grow-1">
                                    <div class="nilai-bar-fill"
                                        style="width: {{ $n->nilai_akhir }}%; background: {{ $barColor }}">
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Grade badge --}}
                        <td class="text-center">
                            <span class="badge {{ $gradeClass }} px-3 py-2 fs-6">
                                {{ $n->nilai_huruf }}
                            </span>
                        </td>

                        {{-- Semester --}}
                        <td class="text-center">
                            @if($n->semester || $n->tahun_ajaran)
                            <div class="small">{{ $n->semester }}</div>
                            <div class="text-muted" style="font-size:.7rem">{{ $n->tahun_ajaran }}</div>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada nilai yang tercatat untuk Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{-- Footer total --}}
                @if($nilais->count() > 0)
                <tfoot>
                    <tr class="table-light fw-semibold">
                        <td colspan="2" class="text-end">Rata-rata keseluruhan</td>
                        <td class="text-center">{{ $totalSks }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <span class="fw-bold" style="font-size:1.05rem">
                                {{ number_format($ipk, 2) }}
                            </span>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    @if($nilais->hasPages())
    <div class="card-footer no-print">
        {{ $nilais->links() }}
    </div>
    @endif
</div>

{{-- ── Distribusi Grade ────────────────────────────────────────── --}}
@if($totalMatkul > 0)
<div class="row g-3 mt-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Distribusi Grade</h6>
            </div>
            <div class="card-body">
                @foreach(['A','B+','B','C+','C','D','E'] as $g)
                @php
                $cnt = $gradeCount[$g] ?? 0;
                $pct = $totalMatkul > 0 ? ($cnt / $totalMatkul) * 100 : 0;
                $gc = match($g) {
                'A' => 'bg-success',
                'B+' => 'bg-primary',
                'B' => 'bg-info',
                'C+' => 'bg-warning',
                'C' => 'bg-orange',
                'D' => 'bg-danger',
                default => 'bg-secondary',
                };
                @endphp
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="width:32px; font-weight:700; font-size:.85rem">{{ $g }}</span>
                    <div class="flex-grow-1 nilai-bar">
                        <div class="nilai-bar-fill {{ $gc }}" style="width: {{ $pct }}%; height:100%"></div>
                    </div>
                    <span class="text-muted small" style="width:55px; text-align:right">
                        {{ $cnt }} MK ({{ number_format($pct, 0) }}%)
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Keterangan Konversi Nilai</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Rentang Nilai</th>
                            <th class="text-center">Huruf Mutu</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <tr>
                            <td>85 – 100</td>
                            <td class="text-center"><span class="badge badge-A">A</span></td>
                            <td>Sangat Baik</td>
                        </tr>
                        <tr>
                            <td>80 – &lt;85</td>
                            <td class="text-center"><span class="badge badge-Bp">B+</span></td>
                            <td>Antara Baik & Sangat Baik</td>
                        </tr>
                        <tr>
                            <td>75 – &lt;80</td>
                            <td class="text-center"><span class="badge badge-B">B</span></td>
                            <td>Baik</td>
                        </tr>
                        <tr>
                            <td>70 – &lt;75</td>
                            <td class="text-center"><span class="badge badge-Cp">C+</span></td>
                            <td>Antara Cukup & Baik</td>
                        </tr>
                        <tr>
                            <td>61 – &lt;70</td>
                            <td class="text-center"><span class="badge badge-C">C</span></td>
                            <td>Cukup</td>
                        </tr>
                        <tr>
                            <td>50 – 60</td>
                            <td class="text-center"><span class="badge badge-D">D</span></td>
                            <td>Kurang</td>
                        </tr>
                        <tr>
                            <td>&lt;50</td>
                            <td class="text-center"><span class="badge badge-E">E</span></td>
                            <td>Tidak Lulus</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@endsection