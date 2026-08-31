<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenMahasiswaRequest extends FormRequest
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
        $isFileRequired = $this->isMethod('POST') ? 'required' : 'nullable';

        return [
            'mahasiswa_id'  => ['required', 'exists:mahasiswas,id'],
            'nama_dokumen'  => ['required', 'string', 'max:255'],
            'jenis_dokumen' => ['required', 'string', 'max:100'],
            'nomor_dokumen' => ['nullable', 'string', 'max:100'],
            'file_dokumen'  => [$isFileRequired, 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'keterangan'    => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'  => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'    => 'Mahasiswa yang dipilih tidak valid.',
            'nama_dokumen.required'  => 'Nama dokumen wajib diisi.',
            'jenis_dokumen.required' => 'Jenis dokumen wajib dipilih.',
            'file_dokumen.required'  => 'Berkas dokumen wajib diunggah.',
            'file_dokumen.file'      => 'Berkas yang diunggah harus berupa file yang valid.',
            'file_dokumen.mimes'     => 'Format berkas harus berupa PDF, JPG, JPEG, PNG, atau WEBP.',
            'file_dokumen.max'       => 'Ukuran berkas maksimal 5MB.',
        ];
    }
}
