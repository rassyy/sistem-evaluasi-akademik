@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-user-edit me-2"></i>Edit Dosen
        </h4>
        <small class="text-muted">Perubahan nama & email akan ikut diperbarui di akun login</small>
    </div>
    <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>Form Edit Dosen</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dosen.update', $dosen->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            NIDN <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
                            value="{{ old('nidn', $dosen->nidn) }}" required>
                        @error('nidn')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $dosen->nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $dosen->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Program Studi</label>
                        <input type="text" name="program_studi"
                            class="form-control @error('program_studi') is-invalid @enderror"
                            value="{{ old('program_studi', $dosen->program_studi) }}">
                        @error('program_studi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info akun terhubung --}}
                    @if($dosen->user)
                    <div class="alert alert-secondary d-flex gap-2 align-items-start py-2 mb-4">
                        <i class="fas fa-link mt-1 flex-shrink-0"></i>
                        <div class="small">
                            Terhubung ke akun: <strong>{{ $dosen->user->email }}</strong><br>
                            Nama & email akun akan ikut diperbarui. Password <strong>tidak</strong> berubah.
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update
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