<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NilaiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Nilai::with(['mataKuliah', 'mahasiswa']);

        if (!empty($this->filters['mata_kuliah_id'])) {
            $query->where('mata_kuliah_id', $this->filters['mata_kuliah_id']);
        }
        if (!empty($this->filters['semester'])) {
            $query->where('semester', $this->filters['semester']);
        }
        if (!empty($this->filters['tahun_ajaran'])) {
            $query->where('tahun_ajaran', $this->filters['tahun_ajaran']);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'NIM',
            'Nama Mahasiswa',
            'Nilai Tugas (Rata-rata)',
            'Bobot Tugas (%)',
            'Nilai UTS',
            'Bobot UTS (%)',
            'Nilai UAS',
            'Bobot UAS (%)',
            'Nilai Akhir',
            'Nilai Huruf',
            'Semester',
            'Tahun Ajaran',
        ];
    }

    public function map($nilai): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $nilai->mataKuliah->kode_matakuliah ?? '-',
            $nilai->mataKuliah->nama_matakuliah ?? '-',
            $nilai->mahasiswa->nim ?? '-',
            $nilai->mahasiswa->nama ?? '-',
            $nilai->rata_rata_tugas,
            $nilai->bobot_tugas . '%',
            $nilai->nilai_uts,
            $nilai->bobot_uts . '%',
            $nilai->nilai_uas,
            $nilai->bobot_uas . '%',
            $nilai->nilai_akhir,
            $nilai->nilai_huruf,
            $nilai->semester ?? '-',
            $nilai->tahun_ajaran ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A5F'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}