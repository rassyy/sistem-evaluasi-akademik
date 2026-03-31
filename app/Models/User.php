<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ── Helpers role ───────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    // ── Relasi ─────────────────────────────────────────────
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }
}