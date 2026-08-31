<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KrsRequest extends FormRequest
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
            'mahasiswa_id'   => ['required', 'exists:mahasiswas,id'],
            'tahun_akademik' => ['required', 'string', 'max:50'],
            'semester'       => ['required', 'integer', 'min:1', 'max:14'],
            'mata_kuliah_id' => ['nullable', 'array'],
            'mata_kuliah_id.*' => ['exists:mata_kuliahs,id'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'   => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'     => 'Mahasiswa yang dipilih tidak valid.',
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'semester.required'       => 'Semester wajib diisi.',
            'semester.integer'        => 'Semester harus berupa angka.',
        ];
    }
}
