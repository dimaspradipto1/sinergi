<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataKuliahRequest extends FormRequest
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
            'kode_matkul' => ['required', 'string', 'max:50'],
            'nama_matkul' => ['required', 'string', 'max:255'],
            'sks'         => ['required', 'integer', 'min:1', 'max:10'],
            'semester'    => ['required', 'integer', 'min:1', 'max:14'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kode_matkul.required' => 'Kode mata kuliah wajib diisi.',
            'nama_matkul.required' => 'Nama mata kuliah wajib diisi.',
            'sks.required'         => 'Bobot SKS wajib diisi.',
            'sks.integer'          => 'SKS harus berupa angka.',
            'semester.required'    => 'Semester wajib diisi.',
            'semester.integer'     => 'Semester harus berupa angka.',
        ];
    }
}
