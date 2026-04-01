<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\KhsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROOT — redirect berdasarkan role setelah login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('nilai.index'),
        'dosen' => redirect()->route('nilai.index'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| Breeze auth routes (login, logout, register, password reset, dll)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Master Dosen
    Route::resource('dosen', DosenController::class)->except(['show']);

    // Master Mahasiswa — CRUD + Import
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);
    Route::get('mahasiswa-import', [MahasiswaController::class, 'importForm'])->name('mahasiswa.import.form');
    Route::post('mahasiswa-import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');

    // Master Mata Kuliah
    Route::resource('mata-kuliah', MataKuliahController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| ADMIN + DOSEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,dosen'])->group(function () {

    // Nilai — CRUD + Export
    Route::resource('nilai', NilaiController::class);
    Route::get('nilai-export', [NilaiController::class, 'export'])->name('nilai.export');
});

/*
|--------------------------------------------------------------------------
| MAHASISWA ONLY — Dashboard / KHS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    Route::get('dashboard', [KhsController::class, 'index'])->name('mahasiswa.dashboard');

    // Alias /khs → sama dengan dashboard (opsional, untuk backward compat)
    Route::get('khs', [KhsController::class, 'index'])->name('khs.index');
});