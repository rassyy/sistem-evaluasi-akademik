<?php

namespace App\Http\Controllers;

use App\Exports\NilaiExport;
use App\Http\Requests\NilaiRequest;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\NilaiTugas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['mataKuliah', 'mahasiswa', 'nilaiTugas']);

        if (auth()->user()->isDosen()) {
            $dosenId = auth()->user()->dosen?->id;
            $query->whereHas('mataKuliah', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            });
        }
        // Filter
        if ($request->filled('mata_kuliah_id')) {
            $query->where('mata_kuliah_id', $request->mata_kuliah_id);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->filled('search')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nim', 'like', "%{$request->search}%")
                    ->orWhere('nama', 'like', "%{$request->search}%");
            });
        }

        $nilais = $query->latest()->paginate(15)->withQueryString();
        $mataKuliahs = MataKuliah::all();

        return view('nilai.index', compact('nilais', 'mataKuliahs'));
    }

    // Dalam create() — filter matkul hanya yang diampunya
    public function create()
    {
        $user = auth()->user();

        $mataKuliahs = $user->isDosen()
            ? MataKuliah::where('dosen_id', $user->dosen?->id)->get()
            : MataKuliah::all();

        $mahasiswas = Mahasiswa::all();
        return view('nilai.create', compact('mataKuliahs', 'mahasiswas'));
    }

    public function store(NilaiRequest $request)
    {
        $data = $request->validated();

        // Hitung rata-rata tugas
        $nilaiTugasArr = array_map('floatval', $data['nilai_tugas']);
        $rataTugas = count($nilaiTugasArr) > 0
            ? array_sum($nilaiTugasArr) / count($nilaiTugasArr)
            : 0;

        // Hitung nilai akhir
        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $rataTugas,
            (float) $data['nilai_uts'],
            (float) $data['nilai_uas'],
            (float) $data['bobot_tugas'],
            (float) $data['bobot_uts'],
            (float) $data['bobot_uas']
        );

        // Konversi ke huruf
        $nilaiHuruf = Nilai::konversiHuruf($nilaiAkhir);

        // Simpan data nilai utama
        $nilai = Nilai::create([
            'mata_kuliah_id' => $data['mata_kuliah_id'],
            'mahasiswa_id' => $data['mahasiswa_id'],
            'rata_rata_tugas' => round($rataTugas, 2),
            'nilai_uts' => $data['nilai_uts'],
            'nilai_uas' => $data['nilai_uas'],
            'bobot_tugas' => $data['bobot_tugas'],
            'bobot_uts' => $data['bobot_uts'],
            'bobot_uas' => $data['bobot_uas'],
            'nilai_akhir' => round($nilaiAkhir, 2),
            'nilai_huruf' => $nilaiHuruf,
            'semester' => $data['semester'] ?? null,
            'tahun_ajaran' => $data['tahun_ajaran'] ?? null,
        ]);

        // Simpan detail nilai tugas
        foreach ($data['nilai_tugas'] as $index => $nt) {
            NilaiTugas::create([
                'nilai_id' => $nilai->id,
                'nama_tugas' => $data['nama_tugas'][$index] ?? ('Tugas ' . ($index + 1)),
                'nilai' => $nt,
            ]);
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function show(Nilai $nilai)
    {
        $nilai->load(['mataKuliah', 'mahasiswa', 'nilaiTugas']);
        return view('nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai)
    {
        $nilai->load(['mataKuliah', 'mahasiswa', 'nilaiTugas']);
        $mataKuliahs = MataKuliah::all();
        $mahasiswas = Mahasiswa::all();
        return view('nilai.edit', compact('nilai', 'mataKuliahs', 'mahasiswas'));
    }

    public function update(NilaiRequest $request, Nilai $nilai)
    {
        $data = $request->validated();

        // Hitung rata-rata tugas
        $nilaiTugasArr = array_map('floatval', $data['nilai_tugas']);
        $rataTugas = count($nilaiTugasArr) > 0
            ? array_sum($nilaiTugasArr) / count($nilaiTugasArr)
            : 0;

        // Hitung nilai akhir
        $nilaiAkhir = Nilai::hitungNilaiAkhir(
            $rataTugas,
            (float) $data['nilai_uts'],
            (float) $data['nilai_uas'],
            (float) $data['bobot_tugas'],
            (float) $data['bobot_uts'],
            (float) $data['bobot_uas']
        );

        $nilaiHuruf = Nilai::konversiHuruf($nilaiAkhir);

        // Update nilai utama
        $nilai->update([
            'mata_kuliah_id' => $data['mata_kuliah_id'],
            'mahasiswa_id' => $data['mahasiswa_id'],
            'rata_rata_tugas' => round($rataTugas, 2),
            'nilai_uts' => $data['nilai_uts'],
            'nilai_uas' => $data['nilai_uas'],
            'bobot_tugas' => $data['bobot_tugas'],
            'bobot_uts' => $data['bobot_uts'],
            'bobot_uas' => $data['bobot_uas'],
            'nilai_akhir' => round($nilaiAkhir, 2),
            'nilai_huruf' => $nilaiHuruf,
            'semester' => $data['semester'] ?? null,
            'tahun_ajaran' => $data['tahun_ajaran'] ?? null,
        ]);

        // Hapus detail tugas lama, simpan yang baru
        $nilai->nilaiTugas()->delete();
        foreach ($data['nilai_tugas'] as $index => $nt) {
            NilaiTugas::create([
                'nilai_id' => $nilai->id,
                'nama_tugas' => $data['nama_tugas'][$index] ?? ('Tugas ' . ($index + 1)),
                'nilai' => $nt,
            ]);
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['mata_kuliah_id', 'semester', 'tahun_ajaran']);
        $filename = 'nilai_mahasiswa_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new NilaiExport($filters), $filename);
    }
}