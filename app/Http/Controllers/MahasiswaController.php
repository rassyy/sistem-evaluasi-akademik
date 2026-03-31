<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('user')->latest()->paginate(15);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:100',
            'program_studi' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['nim'] . '@student.ac.id',
                'password' => Hash::make($validated['nim']),
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'program_studi' => $validated['program_studi'] ?? null,
            ]);
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan. Password default: NIM.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'program_studi' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {
            $mahasiswa->update($validated);

            if ($mahasiswa->user) {
                $mahasiswa->user->update(['name' => $validated['nama']]);
            }
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::transaction(function () use ($mahasiswa) {
            $mahasiswa->user?->delete();
            $mahasiswa->delete();
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    // ── Import Excel ────────────────────────────────────────────────
    public function importForm()
    {
        return view('mahasiswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new MahasiswaImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();
        $msg = "Import selesai. Berhasil: {$import->importedCount}, Dilewati (duplikat): {$import->skippedCount}.";

        if ($failures->count() > 0) {
            $errors = $failures->map(fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors()))->implode(' | ');
            return redirect()->route('mahasiswa.index')
                ->with('warning', $msg . " Validasi gagal: {$errors}");
        }

        return redirect()->route('mahasiswa.index')->with('success', $msg);
    }
}