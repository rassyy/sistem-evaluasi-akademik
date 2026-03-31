<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nilai extends Model
{
    protected $fillable = [
        'mata_kuliah_id',
        'mahasiswa_id',
        'rata_rata_tugas',
        'nilai_uts',
        'nilai_uas',
        'bobot_tugas',
        'bobot_uts',
        'bobot_uas',
        'nilai_akhir',
        'nilai_huruf',
        'semester',
        'tahun_ajaran',
    ];

    protected $casts = [
        'rata_rata_tugas' => 'float',
        'nilai_uts' => 'float',
        'nilai_uas' => 'float',
        'bobot_tugas' => 'float',
        'bobot_uts' => 'float',
        'bobot_uas' => 'float',
        'nilai_akhir' => 'float',
    ];

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function nilaiTugas(): HasMany
    {
        return $this->hasMany(NilaiTugas::class, 'nilai_id');
    }

    /**
     * Hitung nilai akhir dari komponen-komponen nilai
     */
    public static function hitungNilaiAkhir(float $rataTugasNilai, float $nilaiUts, float $nilaiUas, float $bobotTugas, float $bobotUts, float $bobotUas): float
    {
        // Konversi bobot dari persen ke desimal
        $bt = $bobotTugas / 100;
        $buts = $bobotUts / 100;
        $buas = $bobotUas / 100;

        $nilaiAkhir = ($bt * $rataTugasNilai) + ($buts * $nilaiUts) + ($buas * $nilaiUas);

        // Batasi maksimum 100
        return min($nilaiAkhir, 100);
    }

    /**
     * Konversi nilai angka ke huruf
     */
    public static function konversiHuruf(float $nilaiAkhir): string
    {
        return match (true) {
            $nilaiAkhir >= 85 => 'A',
            $nilaiAkhir >= 80 => 'B+',
            $nilaiAkhir >= 75 => 'B',
            $nilaiAkhir >= 70 => 'C+',
            $nilaiAkhir >= 61 => 'C',
            $nilaiAkhir >= 50 => 'D',
            default => 'E',
        };
    }
}