<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'bobot_tugas',
        'bobot_uts',
        'bobot_uas',
    ];

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'mata_kuliah_id');
    }
}