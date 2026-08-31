<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelulusanRequest extends FormRequest
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
            'mahasiswa_id'        => ['required', 'exists:mahasiswas,id'],
            'nomor_sk_yudisium'   => ['required', 'string', 'max:100'],
            'tanggal_sk_yudisium' => ['required', 'date'],
            'tanggal_lulus'       => ['required', 'date'],
            'ipk_kelulusan'       => ['required', 'numeric', 'min:0', 'max:4'],
            'predikat'            => ['required', 'string', 'max:100'],
            'judul_tugas_akhir'   => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'        => 'Mahasiswa wajib dipilih.',
            'nomor_sk_yudisium.required'   => 'Nomor SK Yudisium wajib diisi.',
            'tanggal_sk_yudisium.required' => 'Tanggal SK Yudisium wajib diisi.',
            'tanggal_lulus.required'       => 'Tanggal kelulusan wajib diisi.',
            'ipk_kelulusan.required'       => 'IPK kelulusan wajib diisi.',
            'ipk_kelulusan.numeric'        => 'IPK harus berupa bilangan angka.',
            'predikat.required'            => 'Predikat kelulusan wajib dipilih/diisi.',
        ];
    }
}
