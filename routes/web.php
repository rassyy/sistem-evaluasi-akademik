<?php

use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('nilai.index');
});

// Mata Kuliah
Route::resource('mata-kuliah', MataKuliahController::class)->except(['show']);

// Nilai Mahasiswa
Route::resource('nilai', NilaiController::class);
Route::get('nilai-export', [NilaiController::class, 'export'])->name('nilai.export');
