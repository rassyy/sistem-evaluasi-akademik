<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class MahasiswaImport implements
    ToCollection,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    // Statistik untuk ditampilkan setelah import
    public int $importedCount = 0;
    public int $skippedCount = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nim = trim((string) $row['nim']);

            // Lewati baris jika NIM sudah ada
            if (Mahasiswa::where('nim', $nim)->exists()) {
                $this->skippedCount++;
                continue;
            }

            DB::transaction(function () use ($row, $nim) {
                // 1. Buat akun user dengan password = NIM
                $user = User::create([
                    'name' => trim($row['nama']),
                    'email' => $nim . '@student.ac.id',
                    'password' => Hash::make($nim),
                    'role' => 'mahasiswa',
                ]);

                // 2. Buat data mahasiswa & hubungkan ke user
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'nama' => trim($row['nama']),
                    'program_studi' => trim($row['program_studi'] ?? ''),
                ]);
            });

            $this->importedCount++;
        }
    }

    public function rules(): array
    {
        return [
            'nim' => ['required', 'string'],
            'nama' => ['required', 'string'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nim.required' => 'Kolom NIM wajib diisi.',
            'nama.required' => 'Kolom Nama wajib diisi.',
        ];
    }
}