@extends('layouts.app')

@section('title', 'Master Data Dosen')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-chalkboard-teacher me-2"></i>Master Data Dosen
        </h4>
        <small class="text-muted">Kelola data dosen pengampu mata kuliah</small>
    </div>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Dosen
    </a>
</div>

{{-- ── Tabel ────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Dosen</h6>
        <span class="badge bg-light text-dark">{{ $dosens->total() }} data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="table-light">
                        <th width="50" class="text-center">No</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Program Studi</th>
                        <th>Email Akun</th>
                        <th>Mata Kuliah Diampu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosens as $i => $dosen)
                    <tr>
                        <td class="text-center text-muted small">{{ $dosens->firstItem() + $i }}</td>
                        <td>
                            <code class="text-primary">{{ $dosen->nidn }}</code>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $dosen->nama }}</div>
                            <small class="text-muted">{{ $dosen->program_studi ?? '-' }}</small>
                        </td>
                        <td>{{ $dosen->program_studi ?? '-' }}</td>
                        <td>
                            @if($dosen->user)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="fas fa-user-check me-1"></i>{{ $dosen->user->email }}
                            </span>
                            @else
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                <i class="fas fa-user-times me-1"></i>Belum punya akun
                            </span>
                            @endif
                        </td>
                        <td>
                            @php $jml = $dosen->mataKuliahs->count(); @endphp
                            @if($jml > 0)
                            <span class="badge rounded-pill bg-primary">{{ $jml }} matkul</span>
                            @else
                            <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-sm btn-warning me-1"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus dosen {{ addslashes($dosen->nama) }} beserta akun login-nya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada data dosen.
                            <a href="{{ route('dosen.create') }}" class="d-block mt-2">Tambah dosen pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($dosens->hasPages())
    <div class="card-footer">
        {{ $dosens->links() }}
    </div>
    @endif
</div>

@endsection