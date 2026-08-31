<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FakultasRequest extends FormRequest
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
        $fakultasId = $this->route('fakulta') ?? $this->route('fakultas');

        return [
            'nama_fakultas' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fakultas', 'nama_fakultas')->ignore($fakultasId),
            ],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'nama_fakultas.string'   => 'Nama fakultas harus berupa teks.',
            'nama_fakultas.max'      => 'Nama fakultas maksimal 255 karakter.',
            'nama_fakultas.unique'   => 'Nama fakultas sudah terdaftar.',
        ];
    }
}
