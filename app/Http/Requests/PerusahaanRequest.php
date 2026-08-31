<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerusahaanRequest extends FormRequest
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
            'nama_perusahaan' => ['required', 'string', 'max:200'],
            'bidang'          => ['required', 'string', 'max:150'],
            'alamat'          => ['nullable', 'string'],
            'kontak'          => ['nullable', 'string', 'max:150'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_perusahaan.required' => 'Nama perusahaan / instansi wajib diisi.',
            'bidang.required'          => 'Bidang industri / sektor usaha wajib diisi.',
        ];
    }
}
