<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Seeder;


class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@evaluasi.ac.id',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Dosen contoh + user-nya
        $userDosen = User::create([
            'name' => 'Dr. Prabasy Rochim, M.Kom',
            'email' => 'budi.prasetyo@evaluasi.ac.id',
            'password' => '123456',
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $userDosen->id,
            'nidn' => '0012345601',
            'nama' => 'Dr. Prabasy Rochim, M.Kom',
            'email' => $userDosen->email,
            'program_studi' => 'Informatika',
        ]);
    }
}