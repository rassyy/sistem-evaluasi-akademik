<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NilaiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Nilai::with(['mataKuliah', 'mahasiswa', 'nilaiTugas']);

        if (!empty($this->filters['mata_kuliah_id'])) {
            $query->where('mata_kuliah_id', $this->filters['mata_kuliah_id']);
        }

        if (!empty($this->filters['semester'])) {
            $query->where('semester', $this->filters['semester']);
        }

        if (!empty($this->filters['tahun_ajaran'])) {
            $query->where('tahun_ajaran', $this->filters['tahun_ajaran']);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama Mahasiswa',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Semester',
            'Tahun Ajaran',
            'Rata-rata Tugas',
            'Nilai UTS',
            'Nilai UAS',
            'Bobot Tugas (%)',
            'Bobot UTS (%)',
            'Bobot UAS (%)',
            'Nilai Akhir',
            'Nilai Huruf',
        ];
    }

    public function map($nilai): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $nilai->mahasiswa->nim ?? '-',
            $nilai->mahasiswa->nama ?? '-',
            $nilai->mataKuliah->kode_matakuliah ?? '-',
            $nilai->mataKuliah->nama_matakuliah ?? '-',
            $nilai->semester ?? '-',
            $nilai->tahun_ajaran ?? '-',
            $nilai->rata_rata_tugas,
            $nilai->nilai_uts,
            $nilai->nilai_uas,
            $nilai->bobot_tugas,
            $nilai->bobot_uts,
            $nilai->bobot_uas,
            $nilai->nilai_akhir,
            $nilai->nilai_huruf,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Style baris header (baris 1)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Nilai Mahasiswa';
    }
}
