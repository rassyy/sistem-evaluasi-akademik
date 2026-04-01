@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-user-plus me-2"></i>Tambah Mahasiswa
        </h4>
        <small class="text-muted">Akun login dibuat otomatis (password default: NIM)</small>
    </div>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-id-badge me-2"></i>Form Data Mahasiswa</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            NIM <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim') }}" placeholder="Contoh: 2210001" required>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">NIM akan digunakan sebagai password default akun mahasiswa.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama Lengkap Mahasiswa" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Program Studi</label>
                        <input type="text" name="program_studi"
                            class="form-control @error('program_studi') is-invalid @enderror"
                            value="{{ old('program_studi') }}" placeholder="Informatika">
                        @error('program_studi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info d-flex gap-2 align-items-start py-2 mb-4">
                        <i class="fas fa-info-circle mt-1 flex-shrink-0"></i>
                        <div class="small">
                            Akun login dibuat otomatis:<br>
                            <strong>Email:</strong> NIM@student.ac.id &nbsp;|&nbsp;
                            <strong>Password:</strong> NIM &nbsp;|&nbsp;
                            <strong>Role:</strong> Mahasiswa
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
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