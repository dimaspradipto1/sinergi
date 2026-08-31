<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TahunAkademikRequest extends FormRequest
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
        $tahunAkademikId = $this->route('tahun_akademik');

        return [
            'tahun_akademik' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tahun_akademiks', 'tahun_akademik')->ignore($tahunAkademikId),
            ],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.string'   => 'Tahun akademik harus berupa teks.',
            'tahun_akademik.max'      => 'Tahun akademik maksimal 255 karakter.',
            'tahun_akademik.unique'   => 'Tahun akademik sudah terdaftar.',
        ];
    }
}
