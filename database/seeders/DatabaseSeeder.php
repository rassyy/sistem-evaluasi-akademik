<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\NilaiTugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key sementara agar truncate aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        NilaiTugas::truncate();
        Nilai::truncate();
        MataKuliah::truncate();
        Mahasiswa::truncate();
        Dosen::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            AdminSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            MataKuliahSeeder::class,
            NilaiSeeder::class,
        ]);

        $this->command->info('✅ Semua data berhasil di-seed!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@evaluasi.ac.id', 'password'],
                ['Dosen 1', 'andi.saputra@evaluasi.ac.id', 'nidn-dosen1'],
                ['Dosen 2', 'budi.hartono@evaluasi.ac.id', 'nidn-dosen2'],
                ['Mahasiswa', 'rasya@student.ac.id', 'password'],
                ['Mahasiswa', '2024001@student.ac.id', '2024001'],
            ]
        );
    }
}


/* ════════════════════════════════════════════════════════════════
   ADMIN SEEDER
════════════════════════════════════════════════════════════════ */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@evaluasi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->command->info('  → Admin created');
    }
}


/* ════════════════════════════════════════════════════════════════
   DOSEN SEEDER
════════════════════════════════════════════════════════════════ */
class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nidn' => '0011223301',
                'nama' => 'Dr. Andi Saputra, M.Kom',
                'email' => 'andi.saputra@evaluasi.ac.id',
                'program_studi' => 'Informatika',
            ],
            [
                'nidn' => '0022334402',
                'nama' => 'Budi Hartono, S.T., M.T.',
                'email' => 'budi.hartono@evaluasi.ac.id',
                'program_studi' => 'Informatika',
            ],
            [
                'nidn' => '0033445503',
                'nama' => 'Dr. Citra Dewi, M.Cs.',
                'email' => 'citra.dewi@evaluasi.ac.id',
                'program_studi' => 'Sistem Informasi',
            ],
            [
                'nidn' => '0044556604',
                'nama' => 'Dedi Firmansyah, M.Kom',
                'email' => 'dedi.firmansyah@evaluasi.ac.id',
                'program_studi' => 'Sistem Informasi',
            ],
            [
                'nidn' => '0055667705',
                'nama' => 'Dr. Eka Rahayu, M.Si.',
                'email' => 'eka.rahayu@evaluasi.ac.id',
                'program_studi' => 'Teknik Komputer',
            ],
        ];

        foreach ($data as $d) {
            $user = User::create([
                'name' => $d['nama'],
                'email' => $d['email'],
                'password' => Hash::make($d['nidn']),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $d['nidn'],
                'nama' => $d['nama'],
                'email' => $d['email'],
                'program_studi' => $d['program_studi'],
            ]);
        }

        $this->command->info('  → 5 Dosen created');
    }
}


/* ════════════════════════════════════════════════════════════════
   MAHASISWA SEEDER
════════════════════════════════════════════════════════════════ */
class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Akun khusus Muhammad Rasya ─────────────────────
        $rasya = User::create([
            'name' => 'Muhammad Rasya',
            'email' => 'rasya@student.ac.id',
            'password' => Hash::make('password'),   // password: password
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $rasya->id,
            'nim' => '2024000',
            'nama' => 'Muhammad Rasya',
            'program_studi' => 'Informatika',
        ]);

        // ── 2. 20 mahasiswa acak ───────────────────────────────
        $namaList = [
            'Ahmad Fauzi',
            'Budi Santoso',
            'Candra Wijaya',
            'Dewi Rahayu',
            'Eko Prasetyo',
            'Fitri Handayani',
            'Gilang Ramadhan',
            'Hana Pertiwi',
            'Irfan Maulana',
            'Joko Susilo',
            'Kartika Sari',
            'Lukman Hakim',
            'Maya Indah',
            'Nanda Pratama',
            'Olivia Santika',
            'Pandu Wicaksono',
            'Qori Ramadhani',
            'Rina Kusuma',
            'Sandi Nugroho',
            'Tika Wulandari',
        ];

        $prodiList = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];

        foreach ($namaList as $idx => $nama) {
            $nim = '2024' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => $nama,
                'email' => $nim . '@student.ac.id',
                'password' => Hash::make($nim),
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $nim,
                'nama' => $nama,
                'program_studi' => $prodiList[$idx % 3],
            ]);
        }

        $this->command->info('  → 21 Mahasiswa created (termasuk Muhammad Rasya)');
    }
}


/* ════════════════════════════════════════════════════════════════
   MATA KULIAH SEEDER
════════════════════════════════════════════════════════════════ */
class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua dosen berdasarkan NIDN
        $dosens = Dosen::pluck('id', 'nidn');

        $mataKuliahs = [
            // Dosen 1 – Dr. Andi Saputra
            [
                'dosen_id' => $dosens['0011223301'],
                'kode_matakuliah' => 'IF2401',
                'nama_matakuliah' => 'Pemrograman Web',
                'sks' => 3,
                'bobot_tugas' => 30,
                'bobot_uts' => 30,
                'bobot_uas' => 40,
            ],
            [
                'dosen_id' => $dosens['0011223301'],
                'kode_matakuliah' => 'IF2402',
                'nama_matakuliah' => 'Pemrograman Mobile',
                'sks' => 3,
                'bobot_tugas' => 25,
                'bobot_uts' => 35,
                'bobot_uas' => 40,
            ],

            // Dosen 2 – Budi Hartono
            [
                'dosen_id' => $dosens['0022334402'],
                'kode_matakuliah' => 'IF2403',
                'nama_matakuliah' => 'Basis Data',
                'sks' => 3,
                'bobot_tugas' => 25,
                'bobot_uts' => 35,
                'bobot_uas' => 40,
            ],
            [
                'dosen_id' => $dosens['0022334402'],
                'kode_matakuliah' => 'IF2404',
                'nama_matakuliah' => 'Algoritma & Struktur Data',
                'sks' => 4,
                'bobot_tugas' => 20,
                'bobot_uts' => 40,
                'bobot_uas' => 40,
            ],

            // Dosen 3 – Dr. Citra Dewi
            [
                'dosen_id' => $dosens['0033445503'],
                'kode_matakuliah' => 'SI2401',
                'nama_matakuliah' => 'Analisis & Perancangan Sistem',
                'sks' => 3,
                'bobot_tugas' => 30,
                'bobot_uts' => 30,
                'bobot_uas' => 40,
            ],
            [
                'dosen_id' => $dosens['0033445503'],
                'kode_matakuliah' => 'SI2402',
                'nama_matakuliah' => 'Manajemen Proyek IT',
                'sks' => 2,
                'bobot_tugas' => 40,
                'bobot_uts' => 25,
                'bobot_uas' => 35,
            ],

            // Dosen 4 – Dedi Firmansyah
            [
                'dosen_id' => $dosens['0044556604'],
                'kode_matakuliah' => 'SI2403',
                'nama_matakuliah' => 'Keamanan Sistem Informasi',
                'sks' => 3,
                'bobot_tugas' => 30,
                'bobot_uts' => 30,
                'bobot_uas' => 40,
            ],

            // Dosen 5 – Dr. Eka Rahayu
            [
                'dosen_id' => $dosens['0055667705'],
                'kode_matakuliah' => 'TK2401',
                'nama_matakuliah' => 'Jaringan Komputer',
                'sks' => 3,
                'bobot_tugas' => 25,
                'bobot_uts' => 35,
                'bobot_uas' => 40,
            ],
            [
                'dosen_id' => $dosens['0055667705'],
                'kode_matakuliah' => 'TK2402',
                'nama_matakuliah' => 'Arsitektur & Organisasi Komputer',
                'sks' => 3,
                'bobot_tugas' => 20,
                'bobot_uts' => 40,
                'bobot_uas' => 40,
            ],
        ];

        foreach ($mataKuliahs as $mk) {
            MataKuliah::create(array_merge($mk, ['created_at' => now(), 'updated_at' => now()]));
        }

        $this->command->info('  → 9 Mata Kuliah created');
    }
}


/* ════════════════════════════════════════════════════════════════
   NILAI SEEDER
   – Buat nilai untuk Muhammad Rasya (semua matkul, nilai bagus)
   – Buat nilai acak untuk 10 mahasiswa pertama di 4 matkul
════════════════════════════════════════════════════════════════ */
class NilaiSeeder extends Seeder
{
    // Konversi angka → huruf (sesuai aturan aplikasi)
    private function huruf(float $n): string
    {
        return match (true) {
            $n >= 85 => 'A',
            $n >= 80 => 'B+',
            $n >= 75 => 'B',
            $n >= 70 => 'C+',
            $n >= 61 => 'C',
            $n >= 50 => 'D',
            default => 'E',
        };
    }

    // Hitung nilai akhir & simpan ke DB
    private function buatNilai(
        int $mhsId,
        int $mkId,
        array $tugasArr,      // array nilai tugas
        float $nilaiUts,
        float $nilaiUas,
        float $bobotTugas,
        float $bobotUts,
        float $bobotUas,
        string $semester,
        string $tahunAjaran
    ): void {
        $rataTugas = count($tugasArr) > 0
            ? array_sum($tugasArr) / count($tugasArr)
            : 0;

        $nilaiAkhir = min(
            ($bobotTugas / 100 * $rataTugas)
            + ($bobotUts / 100 * $nilaiUts)
            + ($bobotUas / 100 * $nilaiUas),
            100
        );

        $nilai = Nilai::create([
            'mata_kuliah_id' => $mkId,
            'mahasiswa_id' => $mhsId,
            'rata_rata_tugas' => round($rataTugas, 2),
            'nilai_uts' => $nilaiUts,
            'nilai_uas' => $nilaiUas,
            'bobot_tugas' => $bobotTugas,
            'bobot_uts' => $bobotUts,
            'bobot_uas' => $bobotUas,
            'nilai_akhir' => round($nilaiAkhir, 2),
            'nilai_huruf' => $this->huruf($nilaiAkhir),
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran,
        ]);

        foreach ($tugasArr as $i => $nt) {
            NilaiTugas::create([
                'nilai_id' => $nilai->id,
                'nama_tugas' => 'Tugas ' . ($i + 1),
                'nilai' => $nt,
            ]);
        }
    }

    public function run(): void
    {
        $rasya = Mahasiswa::where('nim', '2024000')->first();
        $matkuls = MataKuliah::all()->keyBy('kode_matakuliah');

        // ── Nilai Muhammad Rasya (nilai bagus, semua matkul) ──
        $rasyaNilai = [
            'IF2401' => [[88, 85, 90], 86, 89, 30, 30, 40],
            'IF2402' => [[80, 84, 78], 83, 87, 25, 35, 40],
            'IF2403' => [[90, 88], 85, 92, 25, 35, 40],
            'IF2404' => [[75, 80], 88, 85, 20, 40, 40],
            'SI2401' => [[92, 95, 88], 80, 88, 30, 30, 40],
            'SI2402' => [[85, 87, 90], 82, 86, 40, 25, 35],
            'SI2403' => [[78, 82], 79, 85, 30, 30, 40],
            'TK2401' => [[88, 91], 84, 90, 25, 35, 40],
            'TK2402' => [[72, 76], 80, 83, 20, 40, 40],
        ];

        foreach ($rasyaNilai as $kode => $v) {
            if (!isset($matkuls[$kode]))
                continue;
            $mk = $matkuls[$kode];
            $this->buatNilai(
                $rasya->id,
                $mk->id,
                $v[0],          // array tugas
                $v[1],          // uts
                $v[2],          // uas
                $v[3],          // bobot tugas
                $v[4],          // bobot uts
                $v[5],          // bobot uas
                'Ganjil',
                '2024/2025'
            );
        }

        // ── Nilai 10 mahasiswa lain di 4 matkul ──────────────
        $mhsList = Mahasiswa::where('nim', '!=', '2024000')
            ->orderBy('id')
            ->take(10)
            ->get();

        $mkSample = MataKuliah::whereIn('kode_matakuliah', ['IF2401', 'IF2403', 'SI2401', 'TK2401'])
            ->get();

        foreach ($mhsList as $mhs) {
            foreach ($mkSample as $mk) {
                // Nilai acak realistis (50–98)
                $t1 = rand(55, 98);
                $t2 = rand(55, 98);
                $uts = rand(50, 95);
                $uas = rand(50, 98);

                $this->buatNilai(
                    $mhs->id,
                    $mk->id,
                    [$t1, $t2],
                    $uts,
                    $uas,
                    $mk->bobot_tugas,
                    $mk->bobot_uts,
                    $mk->bobot_uas,
                    'Ganjil',
                    '2024/2025'
                );
            }
        }

        $this->command->info('  → Nilai Rasya (9 matkul) + Nilai 10 mhs lain (4 matkul) created');
    }
}