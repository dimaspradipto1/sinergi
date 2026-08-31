<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramStudiRequest extends FormRequest
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
        $prodiId = $this->route('program_studi') ?? $this->route('program_study');

        return [
            'fakultas_id'   => ['required', 'exists:fakultas,id'],
            'program_studi' => [
                'required',
                'string',
                'max:255',
                Rule::unique('program_studis', 'program_studi')
                    ->where('fakultas_id', $this->fakultas_id)
                    ->ignore($prodiId),
            ],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'fakultas_id.required'   => 'Fakultas wajib dipilih.',
            'fakultas_id.exists'     => 'Fakultas yang dipilih tidak valid.',
            'program_studi.required' => 'Nama program studi wajib diisi.',
            'program_studi.string'   => 'Nama program studi harus berupa teks.',
            'program_studi.max'      => 'Nama program studi maksimal 255 karakter.',
            'program_studi.unique'   => 'Program studi sudah terdaftar pada fakultas ini.',
        ];
    }
}
