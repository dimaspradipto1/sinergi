<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
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
        $semesterId = $this->route('semester');

        return [
            'semester' => [
                'required',
                'string',
                'max:255',
                Rule::unique('semesters', 'semester')->ignore($semesterId),
            ],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'semester.required' => 'Nama semester wajib diisi.',
            'semester.string'   => 'Nama semester harus berupa teks.',
            'semester.max'      => 'Nama semester maksimal 255 karakter.',
            'semester.unique'   => 'Semester sudah terdaftar.',
        ];
    }
}
