@extends('layouts.app')

@section('title', 'Edit Nilai')

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
    <h4 class="fw-bold" style="color:var(--primary)"><i class="fas fa-edit me-2"></i>Edit Nilai Mahasiswa</h4>
    <a href="{{ route('nilai.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<form action="{{ route('nilai.update', $nilai->id) }}" method="POST" id="formNilai">
    @csrf @method('PUT')

    <div class="row g-4">
        <div class="col-md-8">
            <!-- Data Akademik -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-info-circle me-2"></i>Data Akademik</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mata Kuliah</label>
                            <select name="mata_kuliah_id" class="form-select @error('mata_kuliah_id') is-invalid @enderror" id="selectMK">
                                @foreach($mataKuliahs as $mk)
                                    <option value="{{ $mk->id }}"
                                        data-bobot-tugas="{{ $mk->bobot_tugas }}"
                                        data-bobot-uts="{{ $mk->bobot_uts }}"
                                        data-bobot-uas="{{ $mk->bobot_uas }}"
                                        {{ $nilai->mata_kuliah_id == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mahasiswa</label>
                            <select name="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror">
                                @foreach($mahasiswas as $mhs)
                                    <option value="{{ $mhs->id }}" {{ $nilai->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                        {{ $mhs->nim }} - {{ $mhs->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Ganjil" {{ $nilai->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ $nilai->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control"
                                value="{{ $nilai->tahun_ajaran }}" placeholder="2024/2025">
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
                                class="form-control" min="0" max="100" step="0.01"
                                value="{{ $nilai->bobot_tugas }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bobot UTS (%)</label>
                            <input type="number" name="bobot_uts" id="bobotUts"
                                class="form-control" min="0" max="100" step="0.01"
                                value="{{ $nilai->bobot_uts }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bobot UAS (%)</label>
                            <input type="number" name="bobot_uas" id="bobotUas"
                                class="form-control" min="0" max="100" step="0.01"
                                value="{{ $nilai->bobot_uas }}" required>
                        </div>
                    </div>
                    <div class="mt-2 small">
                        Total Bobot: <strong id="totalBobot">{{ $nilai->bobot_tugas + $nilai->bobot_uts + $nilai->bobot_uas }}%</strong>
                        <span id="bobotWarning" class="text-danger ms-2 d-none">⚠ Harus 100%!</span>
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
                        @foreach($nilai->nilaiTugas as $i => $nt)
                        <div class="tugas-item row g-2 align-items-end" id="tugas-{{ $i+1 }}">
                            <div class="col-md-5">
                                <label class="form-label small">Nama Tugas</label>
                                <input type="text" name="nama_tugas[]" class="form-control form-control-sm"
                                    value="{{ $nt->nama_tugas }}" placeholder="Tugas {{ $i+1 }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small">Nilai</label>
                                <input type="number" name="nilai_tugas[]" class="form-control form-control-sm nilai-tugas-input"
                                    min="0" max="100" step="0.01" value="{{ $nt->nilai }}" required>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-tugas"
                                    onclick="hapusTugas('tugas-{{ $i+1 }}')" {{ $loop->first ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-2 text-muted small">Rata-rata: <strong id="rataRataTugas">{{ $nilai->rata_rata_tugas }}</strong></div>
                </div>
            </div>

            <!-- UTS & UAS -->
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-pen-nib me-2"></i>Nilai UTS & UAS</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nilai UTS</label>
                            <input type="number" name="nilai_uts" id="nilaiUts"
                                class="form-control" min="0" max="100" step="0.01"
                                value="{{ $nilai->nilai_uts }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nilai UAS</label>
                            <input type="number" name="nilai_uas" id="nilaiUas"
                                class="form-control" min="0" max="100" step="0.01"
                                value="{{ $nilai->nilai_uas }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 80px">
                <div class="card-header"><i class="fas fa-calculator me-2"></i>Preview Nilai Akhir</div>
                <div class="card-body">
                    <div id="hasil-preview" class="text-center mb-3">
                        <div class="small mb-1">Nilai Akhir</div>
                        <div style="font-size:3rem; font-weight:900" id="previewNilaiAngka">{{ $nilai->nilai_akhir }}</div>
                        <div style="font-size:1.5rem; font-weight:700; background:rgba(255,255,255,.2); border-radius:8px; padding:.2rem 1rem; display:inline-block" id="previewNilaiHuruf">{{ $nilai->nilai_huruf }}</div>
                    </div>
                    <table class="table table-sm table-borderless small">
                        <tr><td>Rata Tugas</td><td>:</td><td class="fw-semibold" id="prevRata">{{ $nilai->rata_rata_tugas }}</td></tr>
                        <tr><td>Kontribusi Tugas</td><td>:</td><td class="fw-semibold" id="prevKontribTugas">-</td></tr>
                        <tr><td>Kontribusi UTS</td><td>:</td><td class="fw-semibold" id="prevKontribUts">-</td></tr>
                        <tr><td>Kontribusi UAS</td><td>:</td><td class="fw-semibold" id="prevKontribUas">-</td></tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let tugasCount = {{ $nilai->nilaiTugas->count() }};

document.getElementById('btnTambahTugas').addEventListener('click', function () {
    tugasCount++;
    const container = document.getElementById('tugasContainer');
    const div = document.createElement('div');
    div.className = 'tugas-item row g-2 align-items-end';
    div.id = 'tugas-' + tugasCount;
    div.innerHTML = `
        <div class="col-md-5">
            <input type="text" name="nama_tugas[]" class="form-control form-control-sm" placeholder="Tugas ${tugasCount}">
        </div>
        <div class="col-md-5">
            <input type="number" name="nilai_tugas[]" class="form-control form-control-sm nilai-tugas-input"
                min="0" max="100" step="0.01" placeholder="0-100" required>
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusTugas('tugas-${tugasCount}')">
                <i class="fas fa-trash"></i>
            </button>
        </div>`;
    container.appendChild(div);
    bindInputEvents();
    hitungPreview();
});

function hapusTugas(id) {
    if (document.querySelectorAll('.tugas-item').length <= 1) return;
    document.getElementById(id).remove();
    hitungPreview();
}

function hitungPreview() {
    const tugas = Array.from(document.querySelectorAll('.nilai-tugas-input')).map(i => parseFloat(i.value) || 0);
    const rata  = tugas.length ? tugas.reduce((a, b) => a + b, 0) / tugas.length : 0;
    const uts   = parseFloat(document.getElementById('nilaiUts').value) || 0;
    const uas   = parseFloat(document.getElementById('nilaiUas').value) || 0;
    const bt    = (parseFloat(document.getElementById('bobotTugas').value) || 0) / 100;
    const buts  = (parseFloat(document.getElementById('bobotUts').value) || 0) / 100;
    const buas  = (parseFloat(document.getElementById('bobotUas').value) || 0) / 100;

    const kontribTugas = bt * rata;
    const kontribUts   = buts * uts;
    const kontribUas   = buas * uas;
    const nilaiAkhir   = Math.min(kontribTugas + kontribUts + kontribUas, 100);

    document.getElementById('rataRataTugas').textContent     = rata.toFixed(2);
    document.getElementById('prevRata').textContent          = rata.toFixed(2);
    document.getElementById('prevKontribTugas').textContent  = kontribTugas.toFixed(2);
    document.getElementById('prevKontribUts').textContent    = kontribUts.toFixed(2);
    document.getElementById('prevKontribUas').textContent    = kontribUas.toFixed(2);
    document.getElementById('previewNilaiAngka').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('previewNilaiHuruf').textContent = konversiHuruf(nilaiAkhir);

    const totalBobot = (bt + buts + buas) * 100;
    document.getElementById('totalBobot').textContent = totalBobot.toFixed(2) + '%';
    document.getElementById('bobotWarning').classList.toggle('d-none', Math.abs(totalBobot - 100) < 0.01);
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

bindInputEvents();
hitungPreview();
</script>
@endpush