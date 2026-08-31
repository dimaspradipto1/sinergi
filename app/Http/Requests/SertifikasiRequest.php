<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SertifikasiRequest extends FormRequest
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
            'mahasiswa_id'    => ['required', 'exists:mahasiswas,id'],
            'nama_sertifikat' => ['required', 'string', 'max:255'],
            'lembaga'         => ['required', 'string', 'max:255'],
            'tahun'           => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'file'            => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'    => 'Mahasiswa wajib dipilih.',
            'nama_sertifikat.required' => 'Nama sertifikat wajib diisi.',
            'lembaga.required'         => 'Lembaga penerbit sertifikat wajib diisi.',
            'tahun.required'           => 'Tahun penerbitan wajib diisi.',
            'tahun.digits'             => 'Tahun harus berupa 4 digit angka.',
            'file.mimes'               => 'Format berkas harus PDF, JPG, JPEG, atau PNG.',
            'file.max'                 => 'Ukuran berkas maksimal 5MB.',
        ];
    }
}
