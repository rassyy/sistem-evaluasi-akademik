<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'nilai_tugas' => 'required|array|min:1',
            'nilai_tugas.*' => 'required|numeric|min:0|max:100',
            'nama_tugas' => 'nullable|array',
            'nama_tugas.*' => 'nullable|string|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
            'bobot_tugas' => 'required|numeric|min:0|max:100',
            'bobot_uts' => 'required|numeric|min:0|max:100',
            'bobot_uas' => 'required|numeric|min:0|max:100',
            'semester' => 'nullable|string|max:20',
            'tahun_ajaran' => 'nullable|string|max:10',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $bobotTugas = (float) $this->input('bobot_tugas', 0);
            $bobotUts = (float) $this->input('bobot_uts', 0);
            $bobotUas = (float) $this->input('bobot_uas', 0);
            $total = $bobotTugas + $bobotUts + $bobotUas;

            if (abs($total - 100) > 0.01) {
                $validator->errors()->add('bobot_tugas', "Total bobot harus 100%. Saat ini: {$total}%");
            }
        });
    }

    public function messages(): array
    {
        return [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'nilai_tugas.required' => 'Minimal 1 nilai tugas harus diinput.',
            'nilai_tugas.*.required' => 'Nilai tugas tidak boleh kosong.',
            'nilai_tugas.*.numeric' => 'Nilai tugas harus berupa angka.',
            'nilai_tugas.*.min' => 'Nilai tugas minimal 0.',
            'nilai_tugas.*.max' => 'Nilai tugas maksimal 100.',
            'nilai_uts.required' => 'Nilai UTS wajib diisi.',
            'nilai_uts.numeric' => 'Nilai UTS harus berupa angka.',
            'nilai_uas.required' => 'Nilai UAS wajib diisi.',
            'nilai_uas.numeric' => 'Nilai UAS harus berupa angka.',
            'bobot_tugas.required' => 'Bobot tugas wajib diisi.',
            'bobot_uts.required' => 'Bobot UTS wajib diisi.',
            'bobot_uas.required' => 'Bobot UAS wajib diisi.',
        ];
    }
}