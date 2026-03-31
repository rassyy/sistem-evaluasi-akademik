@extends('layouts.app')
@section('title', 'Edit Mata Kuliah')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:var(--primary)"><i class="fas fa-edit me-2"></i>Edit Mata Kuliah</h4>
        <a href="{{ route('mata-kuliah.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card" style="max-width:600px">
        <div class="card-header"><i class="fas fa-book me-2"></i>Form Edit Mata Kuliah</div>
        <div class="card-body">
            <form action="{{ route('mata-kuliah.update', $mataKuliah->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Mata Kuliah</label>
                    <input type="text" name="kode_matakuliah"
                        class="form-control @error('kode_matakuliah') is-invalid @enderror"
                        value="{{ old('kode_matakuliah', $mataKuliah->kode_matakuliah) }}" required>
                    @error('kode_matakuliah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matakuliah"
                        class="form-control @error('nama_matakuliah') is-invalid @enderror"
                        value="{{ old('nama_matakuliah', $mataKuliah->nama_matakuliah) }}" required>
                    @error('nama_matakuliah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">SKS</label>
                    <input type="number" name="sks" class="form-control" value="{{ $mataKuliah->sks }}" min="1" max="6">
                </div>
                <hr>
                <label class="form-label fw-semibold">Bobot Nilai (%)</label>
                <div class="row g-3 mb-1">
                    <div class="col-md-4">
                        <label class="form-label small">Bobot Tugas</label>
                        <input type="number" name="bobot_tugas" id="bt"
                            class="form-control @error('bobot_tugas') is-invalid @enderror"
                            value="{{ old('bobot_tugas', $mataKuliah->bobot_tugas) }}" min="0" max="100" step="0.01"
                            required>
                        @error('bobot_tugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Bobot UTS</label>
                        <input type="number" name="bobot_uts" id="buts" class="form-control"
                            value="{{ old('bobot_uts', $mataKuliah->bobot_uts) }}" min="0" max="100" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Bobot UAS</label>
                        <input type="number" name="bobot_uas" id="buas" class="form-control"
                            value="{{ old('bobot_uas', $mataKuliah->bobot_uas) }}" min="0" max="100" step="0.01" required>
                    </div>
                </div>
                <div class="small mb-3">
                    Total: <strong
                        id="totalBobot">{{ $mataKuliah->bobot_tugas + $mataKuliah->bobot_uts + $mataKuliah->bobot_uas }}%</strong>
                    <span id="warn" class="text-danger ms-2 d-none">⚠ Harus 100%</span>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        ['bt', 'buts', 'buas'].forEach(id => document.getElementById(id).oninput = cekBobot);
        function cekBobot() {
            const t = +document.getElementById('bt').value + +document.getElementById('buts').value + +document.getElementById('buas').value;
            document.getElementById('totalBobot').textContent = t.toFixed(2) + '%';
            document.getElementById('warn').classList.toggle('d-none', Math.abs(t - 100) < 0.01);
        }
    </script>
@endpush