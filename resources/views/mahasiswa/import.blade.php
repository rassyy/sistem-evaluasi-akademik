@extends('layouts.app')

@section('title', 'Import Mahasiswa dari Excel')

@push('styles')
<style>
    /* ── Drop zone ─────────────────────────────────────────── */
    #drop-zone {
        border: 2.5px dashed var(--bs-border-color);
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }

    #drop-zone:hover,
    #drop-zone.dragover {
        border-color: var(--app-accent, #2E86AB);
        background: var(--bs-secondary-bg);
    }

    #drop-zone .drop-icon {
        font-size: 3rem;
        color: #198754;
        opacity: .6;
        margin-bottom: 1rem;
    }

    #file-name-display {
        font-size: .875rem;
        margin-top: .75rem;
    }

    /* ── Preview tabel template ────────────────────────────── */
    .template-table th {
        background: var(--bs-secondary-bg);
        font-size: .8rem;
    }

    .template-table td {
        font-size: .8rem;
        font-family: monospace;
    }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-file-excel me-2"></i>Import Mahasiswa dari Excel
        </h4>
        <small class="text-muted">Akun login dibuat otomatis untuk setiap mahasiswa baru</small>
    </div>
    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">

    {{-- ── Kolom kiri: Form upload ──────────────────────────────── --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="mb-0"><i class="fas fa-upload me-2"></i>Upload File</h6>
            </div>
            <div class="card-body">

                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {!! nl2br(e(session('warning'))) !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data"
                    id="import-form">
                    @csrf

                    {{-- Drop zone --}}
                    <div id="drop-zone" onclick="document.getElementById('file-input').click()">
                        <div class="drop-icon">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        <p class="fw-semibold mb-1">Klik atau drag & drop file di sini</p>
                        <p class="text-muted small mb-0">Format: .xlsx atau .xls &nbsp;|&nbsp; Maks. 5 MB</p>
                        <div id="file-name-display" class="text-success fw-semibold d-none"></div>
                    </div>

                    {{-- Input tersembunyi --}}
                    <input type="file" id="file-input" name="file" accept=".xlsx,.xls,.csv"
                        class="d-none @error('file') is-invalid @enderror">
                    @error('file')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    {{-- Opsi tambahan --}}
                    <div class="mt-3 p-3 rounded" style="background:var(--bs-secondary-bg)">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="skip-existing" checked disabled>
                            <label class="form-check-label small" for="skip-existing">
                                Lewati baris yang NIM-nya sudah ada (duplikat otomatis dilewati)
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success" id="btn-import" disabled>
                            <i class="fas fa-file-import me-1"></i>Mulai Import
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ── Kolom kanan: Panduan format ─────────────────────────── --}}
    <div class="col-lg-5">

        {{-- Format file --}}
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0">
                    <i class="fas fa-table me-2"></i>Format Kolom Excel
                </h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    Baris pertama harus berupa <strong>header</strong> dengan nama kolom persis seperti berikut:
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered template-table mb-0">
                        <thead>
                            <tr>
                                <th>nim</th>
                                <th>nama</th>
                                <th>program_studi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2210001</td>
                                <td>Budi Santoso</td>
                                <td>Informatika</td>
                            </tr>
                            <tr>
                                <td>2210002</td>
                                <td>Dewi Rahayu</td>
                                <td>Sistem Informasi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="small text-muted mt-3 mb-0 ps-3">
                    <li>Kolom <code>nim</code> dan <code>nama</code> wajib diisi</li>
                    <li>Kolom <code>program_studi</code> boleh kosong</li>
                    <li>Huruf header harus <strong>huruf kecil semua</strong></li>
                </ul>
            </div>
        </div>

        {{-- Info akun yang dibuat --}}
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0">
                    <i class="fas fa-key me-2"></i>Akun Login Otomatis
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-primary mt-1">Email</span>
                        <span class="small"><code>NIM@student.ac.id</code></span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-primary mt-1">Password</span>
                        <span class="small">NIM masing-masing mahasiswa</span>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge bg-primary mt-1">Role</span>
                        <span class="small">Mahasiswa (read-only KHS)</span>
                    </div>
                </div>
                <hr>
                <p class="small text-muted mb-0">
                    <i class="fas fa-shield-alt me-1"></i>
                    Mahasiswa sebaiknya segera mengganti password setelah login pertama.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    (function () {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const fileLabel = document.getElementById('file-name-display');
        const btnImport = document.getElementById('btn-import');

        // ── Tampilkan nama file & aktifkan tombol ──────────────────
        function handleFile(file) {
            if (!file) return;
            fileLabel.textContent = '✓ ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            fileLabel.classList.remove('d-none');
            btnImport.disabled = false;
        }

        fileInput.addEventListener('change', function () {
            handleFile(this.files[0]);
        });

        // ── Drag & Drop ────────────────────────────────────────────
        dropZone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', function () {
            this.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                // Transfer ke input tersembunyi
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                handleFile(file);
            }
        });

        // ── Loading state saat submit ──────────────────────────────
        document.getElementById('import-form').addEventListener('submit', function () {
            btnImport.disabled = true;
            btnImport.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Mengimpor...';
        });
    })();
</script>
@endpush