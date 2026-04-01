@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@push('styles')
<style>
    /* ── Stat strip ──────────────────────────────────────────── */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .stat-item {
        background: var(--bs-body-bg, #fff);
        border: 1px solid var(--app-topbar-border, #e8edf4);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: .9rem;
        box-shadow: var(--app-shadow-sm);
        transition: transform .15s, box-shadow .15s;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--app-shadow-md);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .stat-item .stat-val {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
        color: var(--bs-body-color);
    }

    .stat-item .stat-lbl {
        font-size: .72rem;
        color: var(--app-muted-label, #94a3b8);
        margin-top: .15rem;
    }

    /* ── Table card ──────────────────────────────────────────── */
    .table-card {
        border-radius: 14px;
        overflow: hidden;
    }

    .table-card .table {
        margin-bottom: 0;
    }

    .table-card .table thead th {
        background: var(--bs-tertiary-bg);
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--app-muted-label);
        padding: .75rem 1rem;
        border-bottom: 1px solid var(--bs-border-color);
        white-space: nowrap;
    }

    .table-card .table tbody td {
        padding: .85rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        font-size: .875rem;
    }

    .table-card .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-card .table tbody tr {
        transition: background .12s;
    }

    .table-card .table tbody tr:hover {
        background: var(--bs-tertiary-bg);
    }

    /* Avatar initials */
    .avatar-initials {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--app-primary, #1E3A5F), var(--app-accent, #2E86AB));
        color: #fff;
        font-weight: 700;
        font-size: .8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Status badge */
    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    /* Action buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        border: 1.5px solid transparent;
        transition: all .15s;
    }

    .btn-action-edit {
        border-color: #e2a800;
        color: #e2a800;
        background: transparent;
    }

    .btn-action-edit:hover {
        background: #e2a800;
        color: #fff;
    }

    .btn-action-del {
        border-color: #dc3545;
        color: #dc3545;
        background: transparent;
    }

    .btn-action-del:hover {
        background: #dc3545;
        color: #fff;
    }

    /* ── Search bar ──────────────────────────────────────────── */
    .search-bar {
        position: relative;
    }

    .search-bar .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--app-muted-label);
        font-size: .8rem;
        pointer-events: none;
    }

    .search-bar input {
        padding-left: 2.2rem;
        border-radius: 10px;
        font-size: .875rem;
        border: 1.5px solid var(--bs-border-color);
        background: var(--bs-body-bg);
        transition: border-color .2s, box-shadow .2s;
    }

    .search-bar input:focus {
        border-color: var(--app-accent, #2E86AB);
        box-shadow: 0 0 0 3px rgba(46, 134, 171, .12);
    }

    /* ── Modals ──────────────────────────────────────────────── */
    .modal-content {
        border: none;
        border-radius: 18px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, .18);
    }

    .modal-header {
        border-bottom: 1px solid var(--bs-border-color);
        padding: 1.25rem 1.5rem;
        border-radius: 18px 18px 0 0;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: .95rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--bs-border-color);
    }

    .form-label {
        font-weight: 600;
        font-size: .8rem;
        color: var(--bs-body-color);
        margin-bottom: .35rem;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        font-size: .875rem;
        border: 1.5px solid var(--bs-border-color);
        transition: border-color .2s, box-shadow .2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--app-accent, #2E86AB);
        box-shadow: 0 0 0 3px rgba(46, 134, 171, .12);
    }

    /* Drop zone inside import modal */
    .drop-zone {
        border: 2px dashed var(--bs-border-color);
        border-radius: 12px;
        padding: 2rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }

    .drop-zone:hover,
    .drop-zone.dragover {
        border-color: #198754;
        background: rgba(25, 135, 84, .04);
    }

    .drop-zone .dz-icon {
        font-size: 2.25rem;
        color: #198754;
        opacity: .7;
        margin-bottom: .75rem;
    }

    /* Empty state */
    .empty-state {
        padding: 3.5rem 1rem;
        text-align: center;
    }

    .empty-state .empty-icon {
        font-size: 3rem;
        opacity: .18;
        margin-bottom: 1rem;
    }

    /* Pagination reset */
    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')

{{-- ── Page header ──────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-0" style="color:var(--app-primary)">
            <i class="fas fa-users me-2"></i>Data Mahasiswa
        </h4>
        <small class="text-muted">Kelola data mahasiswa dan akun login mereka</small>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">
            <i class="fas fa-file-excel me-1"></i>Import Excel
        </button>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-1"></i>Tambah Mahasiswa
        </button>
    </div>
</div>

{{-- ── Stat strip ───────────────────────────────────────────────── --}}
@php
$total = $mahasiswas->total();
$totalAktif = \App\Models\Mahasiswa::whereHas('user')->count();
$totalTanpa = $total - $totalAktif;
$prodiList = \App\Models\Mahasiswa::select('program_studi')->distinct()->whereNotNull('program_studi')->count();
@endphp
<div class="stat-strip">
    <div class="stat-item">
        <div class="stat-icon" style="background:rgba(30,58,95,.1); color:#1E3A5F">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-val">{{ $total }}</div>
            <div class="stat-lbl">Total Mahasiswa</div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-icon" style="background:rgba(25,135,84,.1); color:#198754">
            <i class="fas fa-user-check"></i>
        </div>
        <div>
            <div class="stat-val">{{ $totalAktif }}</div>
            <div class="stat-lbl">Punya Akun Login</div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-icon" style="background:rgba(220,53,69,.1); color:#dc3545">
            <i class="fas fa-user-times"></i>
        </div>
        <div>
            <div class="stat-val">{{ $totalTanpa }}</div>
            <div class="stat-lbl">Tanpa Akun</div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-icon" style="background:rgba(46,134,171,.1); color:#2E86AB">
            <i class="fas fa-building-columns"></i>
        </div>
        <div>
            <div class="stat-val">{{ $prodiList }}</div>
            <div class="stat-lbl">Program Studi</div>
        </div>
    </div>
</div>

{{-- ── Table card ───────────────────────────────────────────────── --}}
<div class="card table-card">

    {{-- Toolbar --}}
    <div class="card-header d-flex align-items-center gap-3">
        <i class="fas fa-list me-1"></i>
        <span>Daftar Mahasiswa</span>
        <div class="ms-auto search-bar" style="width:240px">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="table-search" class="form-control form-control-sm"
                placeholder="Cari NIM atau nama...">
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table" id="mhs-table">
                <thead>
                    <tr>
                        <th width="48" class="text-center">#</th>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Status Akun</th>
                        <th class="text-center" width="96">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $i => $mhs)
                    <tr data-name="{{ strtolower($mhs->nama) }}" data-nim="{{ $mhs->nim }}">
                        <td class="text-center text-muted small">
                            {{ $mahasiswas->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initials">
                                    {{ strtoupper(substr($mhs->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:.875rem">{{ $mhs->nama }}</div>
                                    @if($mhs->user)
                                    <div class="text-muted" style="font-size:.72rem">{{ $mhs->user->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><code class="text-primary fw-semibold">{{ $mhs->nim }}</code></td>
                        <td>
                            @if($mhs->program_studi)
                            <span class="badge rounded-pill"
                                style="background:rgba(46,134,171,.1); color:#1E3A5F; font-weight:600; font-size:.72rem">
                                {{ $mhs->program_studi }}
                            </span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($mhs->user)
                            <span class="badge rounded-pill"
                                style="background:rgba(25,135,84,.1); color:#198754; font-size:.72rem; font-weight:600">
                                <span class="status-dot" style="background:#198754"></span>Aktif
                            </span>
                            @else
                            <span class="badge rounded-pill"
                                style="background:rgba(220,53,69,.1); color:#dc3545; font-size:.72rem; font-weight:600">
                                <span class="status-dot" style="background:#dc3545"></span>Tanpa Akun
                            </span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- Tombol Edit: isi data ke modal edit --}}
                            <button class="btn-action btn-action-edit me-1" title="Edit" onclick="openEditModal(
                                        {{ $mhs->id }},
                                        '{{ addslashes($mhs->nim) }}',
                                        '{{ addslashes($mhs->nama) }}',
                                        '{{ addslashes($mhs->program_studi ?? '') }}'
                                    )">
                                <i class="fas fa-pen"></i>
                            </button>
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus {{ addslashes($mhs->nama) }} beserta akun loginnya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-action-del" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-users"></i></div>
                                <p class="fw-semibold mb-1">Belum ada data mahasiswa</p>
                                <p class="text-muted small mb-3">Tambahkan mahasiswa satu per satu atau import dari
                                    Excel</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalTambah">
                                        <i class="fas fa-plus me-1"></i>Tambah
                                    </button>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalImport">
                                        <i class="fas fa-file-excel me-1"></i>Import
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($mahasiswas->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">
            Menampilkan {{ $mahasiswas->firstItem() }}–{{ $mahasiswas->lastItem() }}
            dari {{ $mahasiswas->total() }} data
        </small>
        {{ $mahasiswas->links() }}
    </div>
    @endif
</div>

{{-- ════════════════════════════════════════════════════════════════
MODAL: TAMBAH MAHASISWA
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">
                    <i class="fas fa-user-plus me-2 text-primary"></i>Tambah Mahasiswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mahasiswa.store') }}" method="POST" id="form-tambah">
                @csrf
                <div class="modal-body">

                    {{-- Error bag untuk modal tambah --}}
                    @if($errors->any() && old('_form') === 'tambah')
                    <div class="alert alert-danger rounded-3 py-2 small mb-3">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim') }}" placeholder="Contoh: 2210001" required>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">Password default akun = NIM</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama lengkap mahasiswa" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Program Studi</label>
                        <input type="text" name="program_studi"
                            class="form-control @error('program_studi') is-invalid @enderror"
                            value="{{ old('program_studi') }}" placeholder="Informatika">
                    </div>

                    {{-- hidden field untuk deteksi form mana yang error --}}
                    <input type="hidden" name="_form" value="tambah">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
MODAL: EDIT MAHASISWA
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-user-edit me-2 text-warning"></i>Edit Mahasiswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="form-edit">
                @csrf @method('PUT')
                <div class="modal-body">

                    @if($errors->any() && old('_form') === 'edit')
                    <div class="alert alert-danger rounded-3 py-2 small mb-3">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" id="edit-nim"
                            class="form-control @error('nim') is-invalid @enderror" required>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="edit-nama"
                            class="form-control @error('nama') is-invalid @enderror" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Program Studi</label>
                        <input type="text" name="program_studi" id="edit-prodi" class="form-control">
                    </div>

                    <input type="hidden" name="_form" value="edit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-3">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════
MODAL: IMPORT EXCEL
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">
                    <i class="fas fa-file-excel me-2 text-success"></i>Import Mahasiswa dari Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data" id="form-import">
                @csrf
                <div class="modal-body">
                    <div class="row g-4">

                        {{-- Drop zone --}}
                        <div class="col-md-7">
                            <label class="form-label">File Excel</label>
                            <div class="drop-zone" id="drop-zone"
                                onclick="document.getElementById('import-file').click()">
                                <div class="dz-icon"><i class="fas fa-file-excel"></i></div>
                                <p class="fw-semibold mb-1 small">Klik atau drag & drop file</p>
                                <p class="text-muted" style="font-size:.75rem">.xlsx / .xls / .csv · maks 5 MB</p>
                                <p id="dz-filename" class="text-success fw-semibold small d-none mt-2"></p>
                            </div>
                            <input type="file" id="import-file" name="file" accept=".xlsx,.xls,.csv" class="d-none"
                                required>
                            @error('file')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Format panduan --}}
                        <div class="col-md-5">
                            <label class="form-label">Format Kolom Excel</label>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0" style="font-size:.75rem">
                                    <thead class="table-light">
                                        <tr>
                                            <th>nim</th>
                                            <th>nama</th>
                                            <th>program_studi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2210001</td>
                                            <td>Budi S.</td>
                                            <td>Informatika</td>
                                        </tr>
                                        <tr>
                                            <td>2210002</td>
                                            <td>Dewi R.</td>
                                            <td>SI</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <ul class="small text-muted mt-2 ps-3 mb-0">
                                <li>Header harus <strong>huruf kecil</strong></li>
                                <li>Kolom <code>nim</code> & <code>nama</code> wajib</li>
                                <li>Duplikat NIM otomatis dilewati</li>
                            </ul>

                            <div class="mt-3 p-2 rounded-3 small"
                                style="background:rgba(46,134,171,.07); border:1px solid rgba(46,134,171,.2)">
                                <i class="fas fa-key me-1 text-primary"></i>
                                Password default = NIM masing-masing
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3" id="btn-import-submit" disabled>
                        <i class="fas fa-file-import me-1"></i>Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Buka Modal Edit & isi data ─────────────────────────────────
    function openEditModal(id, nim, nama, prodi) {
        const form = document.getElementById('form-edit');
        // Set action URL
        form.action = '/mahasiswa/' + id;
        // Isi field
        document.getElementById('edit-nim').value = nim;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-prodi').value = prodi;
        // Buka modal
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    // ── Auto-buka modal jika ada error validasi ────────────────────
    @if ($errors -> any() && old('_form') === 'tambah')
        document.addEventListener('DOMContentLoaded', () =>
            new bootstrap.Modal(document.getElementById('modalTambah')).show()
        );
    @elseif($errors -> any() && old('_form') === 'edit')
    document.addEventListener('DOMContentLoaded', () => {
        const m = new bootstrap.Modal(document.getElementById('modalEdit'));
        document.getElementById('form-edit').action = '/mahasiswa/{{ old("_id") }}';
        document.getElementById('edit-nim').value = '{{ old("nim") }}';
        document.getElementById('edit-nama').value = '{{ old("nama") }}';
        document.getElementById('edit-prodi').value = '{{ old("program_studi") }}';
        m.show();
    });
    @endif

        // ── Import: drag & drop + file input ──────────────────────────
        (function () {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('import-file');
            const filenameEl = document.getElementById('dz-filename');
            const btnSubmit = document.getElementById('btn-import-submit');

            function setFile(file) {
                if (!file) return;
                filenameEl.textContent = '✓ ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                filenameEl.classList.remove('d-none');
                btnSubmit.disabled = false;
            }

            fileInput.addEventListener('change', () => setFile(fileInput.files[0]));

            dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                if (file) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                    setFile(file);
                }
            });

            document.getElementById('form-import').addEventListener('submit', function () {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Mengimpor...';
            });
        })();

    // ── Live search di tabel ───────────────────────────────────────
    document.getElementById('table-search').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#mhs-table tbody tr[data-name]').forEach(tr => {
            const match = tr.dataset.name.includes(q) || tr.dataset.nim.includes(q);
            tr.style.display = match ? '' : 'none';
        });
    });
</script>
@endpush