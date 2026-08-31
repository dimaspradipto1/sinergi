<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KebutuhanInklusifRequest extends FormRequest
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
            'mahasiswa_id'      => ['required', 'exists:mahasiswas,id'],
            'kebutuhan'         => ['required', 'string', 'max:255'],
            'kategori'          => ['required', 'string', 'max:100'],
            'deskripsi'         => ['nullable', 'string'],
            'layanan_pendukung' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'   => 'Mahasiswa yang dipilih tidak valid.',
            'kebutuhan.required'    => 'Kebutuhan khusus / ragam disabilitas wajib diisi.',
            'kategori.required'     => 'Kategori disabilitas wajib dipilih.',
        ];
    }
}
