@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-user-plus me-2"></i>Tambah Dosen
        </h4>
        <small class="text-muted">Akun login akan otomatis dibuat (password default: NIDN)</small>
    </div>
    <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>Form Data Dosen</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dosen.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            NIDN <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                            value="{{ old('nidn') }}" placeholder="Contoh: 0012345601" required>
                        @error('nidn')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">NIDN akan digunakan sebagai password default akun dosen.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Dr. Nama Dosen, M.Kom" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="nama@kampus.ac.id" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Email ini akan digunakan untuk login ke sistem.</div>
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

                    {{-- Info akun yang akan dibuat --}}
                    <div class="alert alert-info d-flex gap-2 align-items-start py-2 mb-4">
                        <i class="fas fa-info-circle mt-1 flex-shrink-0"></i>
                        <div class="small">
                            Sistem akan otomatis membuat akun login dengan:<br>
                            <strong>Email:</strong> sesuai input &nbsp;|&nbsp;
                            <strong>Password:</strong> NIDN &nbsp;|&nbsp;
                            <strong>Role:</strong> Dosen
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection