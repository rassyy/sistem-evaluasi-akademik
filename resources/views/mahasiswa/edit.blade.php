@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-user-edit me-2"></i>Edit Mahasiswa
        </h4>
        <small class="text-muted">Perubahan nama akan ikut diperbarui di akun login</small>
    </div>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-id-badge me-2"></i>Form Edit Mahasiswa</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            NIM <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim', $mahasiswa->nim) }}" required>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Program Studi</label>
                        <input type="text" name="program_studi"
                            class="form-control @error('program_studi') is-invalid @enderror"
                            value="{{ old('program_studi', $mahasiswa->program_studi) }}">
                        @error('program_studi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($mahasiswa->user)
                    <div class="alert alert-secondary d-flex gap-2 align-items-start py-2 mb-4">
                        <i class="fas fa-link mt-1 flex-shrink-0"></i>
                        <div class="small">
                            Terhubung ke akun: <strong>{{ $mahasiswa->user->email }}</strong><br>
                            Nama akun akan ikut diperbarui. Password <strong>tidak</strong> berubah.
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection