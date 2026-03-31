@extends('layouts.app')

@section('title', 'Master Mata Kuliah')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:var(--primary)"><i class="fas fa-book me-2"></i>Master Mata Kuliah</h4>
        <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Mata Kuliah
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="text-center">Bobot Tugas</th>
                        <th class="text-center">Bobot UTS</th>
                        <th class="text-center">Bobot UAS</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataKuliahs as $i => $mk)
                        <tr>
                            <td>{{ $mataKuliahs->firstItem() + $i }}</td>
                            <td><span class="badge bg-secondary">{{ $mk->kode_matakuliah }}</span></td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->sks }} SKS</td>
                            <td class="text-center">{{ $mk->bobot_tugas }}%</td>
                            <td class="text-center">{{ $mk->bobot_uts }}%</td>
                            <td class="text-center">{{ $mk->bobot_uas }}%</td>
                            <td class="text-center">
                                <a href="{{ route('mata-kuliah.edit', $mk->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('mata-kuliah.destroy', $mk->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus mata kuliah ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada data mata kuliah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mataKuliahs->hasPages())
            <div class="card-footer">{{ $mataKuliahs->links() }}</div>
        @endif
    </div>
@endsection