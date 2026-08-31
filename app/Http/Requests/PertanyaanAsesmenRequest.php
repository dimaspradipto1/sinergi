<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PertanyaanAsesmenRequest extends FormRequest
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
            'instrumen_asesmen_id' => ['required', 'exists:instrumen_asesmens,id'],
            'pertanyaan'           => ['required', 'string'],
            'tipe_jawaban'         => ['required', 'string', 'max:100'],
            'bobot'                => ['required', 'integer', 'min:1'],
            'pilihan_jawaban'      => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'instrumen_asesmen_id.required' => 'Instrumen asesmen wajib dipilih.',
            'instrumen_asesmen_id.exists'   => 'Instrumen asesmen yang dipilih tidak valid.',
            'pertanyaan.required'           => 'Teks pertanyaan wajib diisi.',
            'tipe_jawaban.required'         => 'Tipe jawaban wajib dipilih.',
            'bobot.required'                => 'Bobot pertanyaan wajib diisi.',
            'bobot.integer'                 => 'Bobot harus berupa angka bulat minimal 1.',
        ];
    }
}
