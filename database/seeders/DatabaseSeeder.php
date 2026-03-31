<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Mata kuliah contoh
        MataKuliah::insert([
            ['kode_matakuliah' => 'IF2401', 'nama_matakuliah' => 'Pemrograman Web', 'sks' => 3, 'bobot_tugas' => 30, 'bobot_uts' => 30, 'bobot_uas' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['kode_matakuliah' => 'IF2402', 'nama_matakuliah' => 'Basis Data', 'sks' => 3, 'bobot_tugas' => 25, 'bobot_uts' => 35, 'bobot_uas' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['kode_matakuliah' => 'IF2403', 'nama_matakuliah' => 'Algoritma & Struktur Data', 'sks' => 4, 'bobot_tugas' => 20, 'bobot_uts' => 40, 'bobot_uas' => 40, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Mahasiswa contoh
        Mahasiswa::insert([
            ['nim' => '2210001', 'nama' => 'Muhammad Rasy', 'program_studi' => 'Informatika', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2210002', 'nama' => 'Jesse Pinkman', 'program_studi' => 'Informatika', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2210003', 'nama' => 'Walter White', 'program_studi' => 'Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '2210004', 'nama' => 'Saul Goodman', 'program_studi' => 'Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}