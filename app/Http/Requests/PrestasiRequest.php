<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mahasiswa_id'  => ['required', 'exists:mahasiswas,id'],
            'nama_prestasi' => ['required', 'string', 'max:255'],
            'tingkat'       => ['required', 'string', 'max:100'],
            'tahun'         => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'  => 'Mahasiswa wajib dipilih.',
            'nama_prestasi.required' => 'Nama prestasi wajib diisi.',
            'tingkat.required'       => 'Tingkat prestasi wajib dipilih/diisi.',
            'tahun.required'         => 'Tahun perolehan prestasi wajib diisi.',
            'tahun.digits'           => 'Tahun harus berupa 4 digit angka (contoh: ' . date('Y') . ').',
        ];
    }
}
