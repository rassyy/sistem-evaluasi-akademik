<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhsController extends Controller
{
    /**
     * Halaman KHS: mahasiswa hanya melihat nilainya sendiri.
     */
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;

        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan untuk akun ini.');
        }

        $nilais = $mahasiswa->nilais()
            ->with('mataKuliah')
            ->latest()
            ->paginate(20);

        return view('khs.index', compact('mahasiswa', 'nilais'));
    }
}