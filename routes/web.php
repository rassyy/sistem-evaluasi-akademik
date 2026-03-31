<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\KhsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;


// ── Redirect root berdasarkan role ─────────────────────────────────
Route::get('/', function () {
    if (!auth()->check())
        return redirect()->route('login');

    return match (auth()->user()->role) {
        'admin' => redirect()->route('nilai.index'),
        'dosen' => redirect()->route('nilai.index'),
        'mahasiswa' => redirect()->route('khs.index'),
        default => redirect()->route('login'),
    };
})->middleware('auth');

// ── Routes Breeze (login, register, dll) ───────────────────────────
require __DIR__ . '/auth.php';

// ── Admin only ─────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Master Dosen
    Route::resource('dosen', DosenController::class)->except(['show']);

    // Master Mahasiswa (CRUD + Import)
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);
    Route::get('mahasiswa-import', [MahasiswaController::class, 'importForm'])->name('mahasiswa.import.form');
    Route::post('mahasiswa-import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');

    // Master Mata Kuliah — hanya admin yang bisa CRUD penuh
    Route::resource('mata-kuliah', MataKuliahController::class)->except(['show']);
});

// ── Admin & Dosen ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,dosen'])->group(function () {

    // Nilai (CRUD + export)
    Route::resource('nilai', NilaiController::class);
    Route::get('nilai-export', [NilaiController::class, 'export'])->name('nilai.export');
});

// ── Mahasiswa only ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('khs', [KhsController::class, 'index'])->name('khs.index');
});