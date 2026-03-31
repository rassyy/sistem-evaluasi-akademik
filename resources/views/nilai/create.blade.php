@extends('layouts.app')

@section('title', 'Input Nilai Mahasiswa')

@push('styles')
<style>
    .tugas-item {
        background: var(--bs-secondary-bg);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
    }

    /* ── Kotak gradient: semua teks DIKUNCI putih ── */
    #hasil-preview {
        background: linear-gradient(135deg, #1E3A5F, #2E86AB);
        border-radius: 12px;
        padding: 1.5rem;

        /* Kunci warna teks agar tidak bisa di-override Bootstrap */
        color: #ffffff !important;
    }

    /* Targetkan setiap elemen di dalam kotak secara eksplisit */
    #hasil-preview *,
    #hasil-preview .small,
    #hasil-preview #previewNilaiAngka,
    #hasil-preview #previewNilaiHuruf {
        color: #ffffff !important;
    }

    /* Badge huruf mutu di dalam kotak gradient */
    #hasil-preview #previewNilaiHuruf {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: .2rem 1rem;
        display: inline-block;
        font-size: 1.5rem;
        font-weight: 700;
    }

    /* ── Tabel rekap di bawah kotak: ikut tema Bootstrap ── */
    /* Tidak perlu CSS tambahan — Bootstrap menanganinya otomatis
       via var(--bs-body-color) yang berganti sesuai data-bs-theme */
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold" style="color:var(--primary)"><i class="fas fa-plus-circle me-2"></i>Input Nilai Mahasiswa</h4>
    <a href="{{ route('nilai.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<form action="{{ route('nilai.store') }}" method="POST" id="formNilai">
    @csrf

    <div class="row g-4">
        <!-- Kolom Kiri -->
        <div class="col-md-8">

            <!-- Data Akademik -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-info-circle me-2"></i>Data Akademik</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mata Kuliah <span class="text-danger">*</span></label>
                            <select name="mata_kuliah_id" class="form-select @error('mata_kuliah_id') is-invalid @enderror" id="selectMK">
                                <option value="">-- Pilih Mata Kuliah --</option>
                                @foreach($mataKuliahs as $mk)
                                    <option value="{{ $mk->id }}"
                                        data-bobot-tugas="{{ $mk->bobot_tugas }}"
                                        data-bobot-uts="{{ $mk->bobot_uts }}"
                                        data-bobot-uas="{{ $mk->bobot_uas }}"
                                        {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_kuliah_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mahasiswa <span class="text-danger">*</span></label>
                            <select name="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror">
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswas as $mhs)
                                    <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                        {{ $mhs->nim }} - {{ $mhs->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control"
                                placeholder="2024/2025" value="{{ old('tahun_ajaran') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bobot Nilai -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-balance-scale me-2"></i>Bobot Nilai (%)</div>
                <div class="card-body">
                    @error('bobot_tugas')
                        <div class="alert alert-danger py-2">{{ $message }}</div>
                    @enderror
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bobot Tugas (%)</label>
                            <input type="number" name="bobot_tugas" id="bobotTugas"
                                class="form-control @error('bobot_tugas') is-invalid @enderror"
                                min="0" max="100" step="0.01"
                                value="{{ old('bobot_tugas', 30) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bobot UTS (%)</label>
                            <input type="number" name="bobot_uts" id="bobotUts"
                                class="form-control @error('bobot_uts') is-invalid @enderror"
                                min="0" max="100" step="0.01"
                                value="{{ old('bobot_uts', 30) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bobot UAS (%)</label>
                            <input type="number" name="bobot_uas" id="bobotUas"
                                class="form-control @error('bobot_uas') is-invalid @enderror"
                                min="0" max="100" step="0.01"
                                value="{{ old('bobot_uas', 40) }}" required>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="small">Total Bobot: </span>
                        <span id="totalBobot" class="fw-bold">70%</span>
                        <span id="bobotWarning" class="text-danger small ms-2 d-none">⚠ Harus 100%!</span>
                    </div>
                </div>
            </div>

            <!-- Nilai Tugas -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-tasks me-2"></i>Nilai Tugas</span>
                    <button type="button" class="btn btn-sm btn-light" id="btnTambahTugas">
                        <i class="fas fa-plus me-1"></i>Tambah Tugas
                    </button>
                </div>
                <div class="card-body">
                    <div id="tugasContainer">
                        <div class="tugas-item row g-2 align-items-end" id="tugas-1">
                            <div class="col-md-5">
                                <label class="form-label small">Nama Tugas</label>
                                <input type="text" name="nama_tugas[]" class="form-control form-control-sm" placeholder="Tugas 1">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Nilai (0-100) <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_tugas[]" class="form-control form-control-sm nilai-tugas-input"
                                    min="0" max="100" step="0.01" placeholder="0 - 100" required>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-tugas" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small">
                        Rata-rata tugas: <strong id="rataRataTugas">-</strong>
                    </div>
                </div>
            </div>

            <!-- Nilai UTS & UAS -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-pen-nib me-2"></i>Nilai UTS & UAS</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nilai UTS (0-100) <span class="text-danger">*</span></label>
                            <input type="number" name="nilai_uts" id="nilaiUts"
                                class="form-control @error('nilai_uts') is-invalid @enderror"
                                min="0" max="100" step="0.01"
                                value="{{ old('nilai_uts') }}" placeholder="0 - 100" required>
                            @error('nilai_uts')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nilai UAS (0-100) <span class="text-danger">*</span></label>
                            <input type="number" name="nilai_uas" id="nilaiUas"
                                class="form-control @error('nilai_uas') is-invalid @enderror"
                                min="0" max="100" step="0.01"
                                value="{{ old('nilai_uas') }}" placeholder="0 - 100" required>
                            @error('nilai_uas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Preview -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 80px">
                <div class="card-header"><i class="fas fa-calculator me-2"></i>Preview Nilai Akhir</div>
                <div class="card-body">
                    <div id="hasil-preview" class="text-center mb-3">
                        <div class="small mb-1">Nilai Akhir</div>
                        <div style="font-size:3rem; font-weight:900" id="previewNilaiAngka">-</div>
                        <div style="font-size:1.5rem; font-weight:700; background:rgba(255,255,255,.2); border-radius:8px; padding: .2rem 1rem; display:inline-block" id="previewNilaiHuruf">-</div>
                    </div>
                    <table class="table table-sm table-borderless small">
                        <tr>
                            <td>Rata Tugas</td><td>:</td>
                            <td class="fw-semibold" id="prevRata">-</td>
                        </tr>
                        <tr>
                            <td>Kontribusi Tugas</td><td>:</td>
                            <td class="fw-semibold" id="prevKontribTugas">-</td>
                        </tr>
                        <tr>
                            <td>Kontribusi UTS</td><td>:</td>
                            <td class="fw-semibold" id="prevKontribUts">-</td>
                        </tr>
                        <tr>
                            <td>Kontribusi UAS</td><td>:</td>
                            <td class="fw-semibold" id="prevKontribUas">-</td>
                        </tr>
                    </table>

                    <div class="mt-3 small text-muted border-top pt-3">
                        <strong>Tabel Konversi Nilai:</strong>
                        <table class="table table-sm mt-1">
                            <tr><td>85 – 100</td><td><span class="badge badge-A">A</span></td></tr>
                            <tr><td>80 – &lt;85</td><td><span class="badge badge-Bp">B+</span></td></tr>
                            <tr><td>75 – &lt;80</td><td><span class="badge badge-B">B</span></td></tr>
                            <tr><td>70 – &lt;75</td><td><span class="badge badge-Cp">C+</span></td></tr>
                            <tr><td>61 – &lt;70</td><td><span class="badge badge-C">C</span></td></tr>
                            <tr><td>50 – 60</td><td><span class="badge badge-D">D</span></td></tr>
                            <tr><td>&lt;50</td><td><span class="badge badge-E">E</span></td></tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Simpan Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let tugasCount = 1;

// Tambah baris tugas
document.getElementById('btnTambahTugas').addEventListener('click', function () {
    tugasCount++;
    const container = document.getElementById('tugasContainer');
    const div = document.createElement('div');
    div.className = 'tugas-item row g-2 align-items-end';
    div.id = 'tugas-' + tugasCount;
    div.innerHTML = `
        <div class="col-md-5">
            <label class="form-label small">Nama Tugas</label>
            <input type="text" name="nama_tugas[]" class="form-control form-control-sm" placeholder="Tugas ${tugasCount}">
        </div>
        <div class="col-md-5">
            <label class="form-label small">Nilai (0-100) <span class="text-danger">*</span></label>
            <input type="number" name="nilai_tugas[]" class="form-control form-control-sm nilai-tugas-input"
                min="0" max="100" step="0.01" placeholder="0 - 100" required>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-tugas" onclick="hapusTugas('tugas-${tugasCount}')">
                <i class="fas fa-trash"></i>
            </button>
        </div>`;
    container.appendChild(div);
    bindInputEvents();
    hitungPreview();
    updateHapusButtons();
});

function hapusTugas(id) {
    document.getElementById(id).remove();
    hitungPreview();
    updateHapusButtons();
}

function updateHapusButtons() {
    const items = document.querySelectorAll('.tugas-item');
    document.querySelectorAll('.btn-hapus-tugas').forEach((btn, i) => {
        btn.disabled = items.length <= 1;
    });
}

function getNilaiTugas() {
    return Array.from(document.querySelectorAll('.nilai-tugas-input'))
        .map(i => parseFloat(i.value) || 0);
}

function hitungPreview() {
    const tugas = getNilaiTugas();
    const rata  = tugas.length ? tugas.reduce((a, b) => a + b, 0) / tugas.length : 0;
    const uts   = parseFloat(document.getElementById('nilaiUts').value) || 0;
    const uas   = parseFloat(document.getElementById('nilaiUas').value) || 0;
    const bt    = (parseFloat(document.getElementById('bobotTugas').value) || 0) / 100;
    const buts  = (parseFloat(document.getElementById('bobotUts').value) || 0) / 100;
    const buas  = (parseFloat(document.getElementById('bobotUas').value) || 0) / 100;

    const kontribTugas = bt * rata;
    const kontribUts   = buts * uts;
    const kontribUas   = buas * uas;
    let nilaiAkhir     = Math.min(kontribTugas + kontribUts + kontribUas, 100);

    document.getElementById('rataRataTugas').textContent = rata.toFixed(2);
    document.getElementById('prevRata').textContent       = rata.toFixed(2);
    document.getElementById('prevKontribTugas').textContent = kontribTugas.toFixed(2);
    document.getElementById('prevKontribUts').textContent   = kontribUts.toFixed(2);
    document.getElementById('prevKontribUas').textContent   = kontribUas.toFixed(2);
    document.getElementById('previewNilaiAngka').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('previewNilaiHuruf').textContent = konversiHuruf(nilaiAkhir);

    // Bobot total
    const totalBobot = (bt + buts + buas) * 100;
    document.getElementById('totalBobot').textContent = totalBobot.toFixed(2) + '%';
    const warn = document.getElementById('bobotWarning');
    warn.classList.toggle('d-none', Math.abs(totalBobot - 100) < 0.01);
}

function konversiHuruf(n) {
    if (n >= 85) return 'A';
    if (n >= 80) return 'B+';
    if (n >= 75) return 'B';
    if (n >= 70) return 'C+';
    if (n >= 61) return 'C';
    if (n >= 50) return 'D';
    return 'E';
}

function bindInputEvents() {
    document.querySelectorAll('.nilai-tugas-input, #nilaiUts, #nilaiUas, #bobotTugas, #bobotUts, #bobotUas')
        .forEach(el => { el.oninput = hitungPreview; });
}

// Auto-isi bobot dari mata kuliah
document.getElementById('selectMK').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (opt.value) {
        document.getElementById('bobotTugas').value = opt.dataset.bobotTugas;
        document.getElementById('bobotUts').value   = opt.dataset.bobotUts;
        document.getElementById('bobotUas').value   = opt.dataset.bobotUas;
        hitungPreview();
    }
});

bindInputEvents();
hitungPreview();
</script>
@endpush