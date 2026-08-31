<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrangTuaRequest extends FormRequest
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
        $orangTuaId = $this->route('orang_tua');

        return [
            'mahasiswa_id'          => [
                'required',
                'exists:mahasiswas,id',
                Rule::unique('orang_tuas', 'mahasiswa_id')->ignore($orangTuaId),
            ],
            'nama_ayah'             => ['nullable', 'string', 'max:255'],
            'pekerjaan_ayah'        => ['nullable', 'string', 'max:255'],
            'pendidikan_ayah'       => ['nullable', 'string', 'max:100'],
            'nama_ibu'              => ['nullable', 'string', 'max:255'],
            'pekerjaan_ibu'         => ['nullable', 'string', 'max:255'],
            'pendidikan_ibu'        => ['nullable', 'string', 'max:100'],
            'nama_wali'             => ['nullable', 'string', 'max:255'],
            'pekerjaan_wali'        => ['nullable', 'string', 'max:255'],
            'no_hp'                 => ['nullable', 'string', 'max:25'],
            'alamat'                => ['nullable', 'string'],
            'penghasilan_orang_tua' => ['nullable', 'string', 'max:100'],
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
            'mahasiswa_id.unique'   => 'Data orang tua/wali untuk mahasiswa ini sudah terdaftar.',
        ];
    }
}
