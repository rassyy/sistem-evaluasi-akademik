<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::latest()->paginate(10);
        return view('mata-kuliah.index', compact('mataKuliahs'));
    }

    public function create()
    {
        return view('mata-kuliah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_matakuliah' => 'required|string|max:20|unique:mata_kuliahs',
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'bobot_tugas' => 'required|numeric|min:0|max:100',
            'bobot_uts' => 'required|numeric|min:0|max:100',
            'bobot_uas' => 'required|numeric|min:0|max:100',
        ]);

        $total = $validated['bobot_tugas'] + $validated['bobot_uts'] + $validated['bobot_uas'];
        if (abs($total - 100) > 0.01) {
            return back()->withInput()->withErrors(['bobot_tugas' => "Total bobot harus 100%. Saat ini: {$total}%"]);
        }

        MataKuliah::create($validated);
        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('mata-kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_matakuliah' => 'required|string|max:20|unique:mata_kuliahs,kode_matakuliah,' . $mataKuliah->id,
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'bobot_tugas' => 'required|numeric|min:0|max:100',
            'bobot_uts' => 'required|numeric|min:0|max:100',
            'bobot_uas' => 'required|numeric|min:0|max:100',
        ]);

        $total = $validated['bobot_tugas'] + $validated['bobot_uts'] + $validated['bobot_uas'];
        if (abs($total - 100) > 0.01) {
            return back()->withInput()->withErrors(['bobot_tugas' => "Total bobot harus 100%. Saat ini: {$total}%"]);
        }

        $mataKuliah->update($validated);
        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}