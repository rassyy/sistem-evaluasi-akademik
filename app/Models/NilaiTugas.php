<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiTugas extends Model
{
    protected $table = 'nilai_tugas';

    protected $fillable = [
        'nilai_id',
        'nama_tugas',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'float',
    ];

    public function nilai(): BelongsTo
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }
}
