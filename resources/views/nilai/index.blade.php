@extends('layouts.app')

@section('title', 'Data Nilai Mahasiswa')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:var(--primary)"><i class="fas fa-table me-2"></i>Data Nilai Mahasiswa</h4>
        <div>
            <a href="{{ route('nilai.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus me-1"></i>Input Nilai
            </a>
            <a href="{{ route('nilai.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('nilai.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Mata Kuliah</label>
                    <select name="mata_kuliah_id" class="form-select form-select-sm">
                        <option value="">-- Semua --</option>
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" {{ request('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Semester</label>
                    <input type="text" name="semester" class="form-control form-control-sm" placeholder="Ganjil/Genap"
                        value="{{ request('semester') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control form-control-sm" placeholder="2024/2025"
                        value="{{ request('tahun_ajaran') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Cari NIM/Nama</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="NIM atau Nama..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card">
        <div class="card-header py-3">
            <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Nilai ({{ $nilais->total() }} data)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Mata Kuliah</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th class="text-center">Tugas</th>
                            <th class="text-center">UTS</th>
                            <th class="text-center">UAS</th>
                            <th class="text-center">Nilai Akhir</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $i => $n)
                            <tr>
                                <td class="text-center">{{ $nilais->firstItem() + $i }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $n->mataKuliah->kode_matakuliah }}</span>
                                    <div class="small">{{ $n->mataKuliah->nama_matakuliah }}</div>
                                </td>
                                <td><code>{{ $n->mahasiswa->nim }}</code></td>
                                <td>{{ $n->mahasiswa->nama }}</td>
                                <td class="text-center">
                                    <strong>{{ number_format($n->rata_rata_tugas, 1) }}</strong>
                                    <div class="small text-muted">{{ $n->bobot_tugas }}%</div>
                                </td>
                                <td class="text-center">
                                    <strong>{{ number_format($n->nilai_uts, 1) }}</strong>
                                    <div class="small text-muted">{{ $n->bobot_uts }}%</div>
                                </td>
                                <td class="text-center">
                                    <strong>{{ number_format($n->nilai_uas, 1) }}</strong>
                                    <div class="small text-muted">{{ $n->bobot_uas }}%</div>
                                </td>
                                <td class="text-center">
                                    <strong class="fs-5"
                                        style="color:var(--primary)">{{ number_format($n->nilai_akhir, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    @php
                                        $gradeClass = match ($n->nilai_huruf) {
                                            'A' => 'badge-A',
                                            'B+' => 'badge-Bp',
                                            'B' => 'badge-B',
                                            'C+' => 'badge-Cp',
                                            'C' => 'badge-C',
                                            'D' => 'badge-D',
                                            default => 'badge-E',
                                        };
                                    @endphp
                                    <span class="badge {{ $gradeClass }} fs-6 px-3">{{ $n->nilai_huruf }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('nilai.edit', $n->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus data nilai ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada data nilai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($nilais->hasPages())
            <div class="card-footer">
                {{ $nilais->links() }}
            </div>
        @endif
    </div>
@endsection