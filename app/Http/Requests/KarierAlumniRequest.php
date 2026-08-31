<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KarierAlumniRequest extends FormRequest
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
            'alumni_id'      => ['required', 'exists:alumnis,id'],
            'perusahaan_id' => ['required', 'exists:perusahaans,id'],
            'jabatan'        => ['required', 'string', 'max:150'],
            'tanggal_mulai'  => ['required', 'date'],
            'status_kerja'   => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'alumni_id.required'      => 'Alumni wajib dipilih.',
            'perusahaan_id.required' => 'Perusahaan / instansi mitra wajib dipilih.',
            'jabatan.required'        => 'Jabatan / posisi kerja wajib diisi.',
            'tanggal_mulai.required'  => 'Tanggal mulai bekerja wajib diisi.',
            'status_kerja.required'   => 'Status hubungan kerja wajib dipilih.',
        ];
    }
}
