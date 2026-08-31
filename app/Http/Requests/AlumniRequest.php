<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumniRequest extends FormRequest
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
        $alumniId = $this->route('alumni');

        return [
            'mahasiswa_id'          => [
                'required',
                'exists:mahasiswas,id',
                Rule::unique('alumnis', 'mahasiswa_id')->ignore($alumniId),
            ],
            'tahun_lulus'           => ['required', 'digits:4', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'email_aktif'           => ['nullable', 'email', 'max:255'],
            'no_hp_aktif'           => ['nullable', 'string', 'max:25'],
            'alamat_terbaru'        => ['nullable', 'string'],
            'pekerjaan_sekarang'    => ['nullable', 'string', 'max:255'],
            'instansi_tempat_kerja' => ['nullable', 'string', 'max:255'],
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
            'mahasiswa_id.unique'   => 'Mahasiswa ini sudah terdaftar dalam data alumni.',
            'tahun_lulus.required'  => 'Tahun kelulusan wajib diisi.',
            'tahun_lulus.digits'    => 'Tahun kelulusan harus berupa 4 digit angka (contoh: 2024).',
            'email_aktif.email'     => 'Format alamat email tidak valid.',
        ];
    }
}
