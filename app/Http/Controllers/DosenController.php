<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::with('user')->latest()->paginate(15);
        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|max:20|unique:dosens,nidn',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'program_studi' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['nidn']), // default password = NIDN
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'program_studi' => $validated['program_studi'] ?? null,
            ]);
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan. Password default: NIDN.');
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|max:20|unique:dosens,nidn,' . $dosen->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->user_id,
            'program_studi' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated, $dosen) {
            $dosen->update([
                'nidn' => $validated['nidn'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'program_studi' => $validated['program_studi'] ?? null,
            ]);

            if ($dosen->user) {
                $dosen->user->update([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ]);
            }
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        DB::transaction(function () use ($dosen) {
            // Hapus user terkait (soft delete opsional)
            $dosen->user?->delete();
            $dosen->delete();
        });

        return redirect()->route('dosen.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}