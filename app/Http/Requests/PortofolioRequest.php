<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortofolioRequest extends FormRequest
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
            'mahasiswa_id' => ['required', 'exists:mahasiswas,id'],
            'judul'        => ['required', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'max:100'],
            'deskripsi'    => ['nullable', 'string'],
            'file'         => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,zip,rar', 'max:10240'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'judul.required'        => 'Judul portofolio wajib diisi.',
            'kategori.required'     => 'Kategori portofolio wajib dipilih/diisi.',
            'file.mimes'            => 'Format berkas harus PDF, Gambar, ZIP, atau RAR.',
            'file.max'              => 'Ukuran berkas maksimal 10MB.',
        ];
    }
}
