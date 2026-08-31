<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiMahasiswaRequest extends FormRequest
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
            'krs_id'         => ['required', 'exists:krs,id'],
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
            'nilai_angka'    => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_huruf'    => ['nullable', 'string', 'max:5'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'krs_id.required'         => 'Data KRS wajib dipilih.',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'nilai_angka.required'    => 'Nilai angka wajib diisi.',
            'nilai_angka.numeric'     => 'Nilai angka harus berupa bilangan numerik.',
            'nilai_angka.min'         => 'Nilai minimal 0.',
            'nilai_angka.max'         => 'Nilai maksimal 100.',
        ];
    }
}
