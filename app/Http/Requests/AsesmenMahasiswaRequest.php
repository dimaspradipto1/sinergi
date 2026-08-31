<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsesmenMahasiswaRequest extends FormRequest
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
            'mahasiswa_id'         => ['required', 'exists:mahasiswas,id'],
            'instrumen_asesmen_id' => ['required', 'exists:instrumen_asesmens,id'],
            'tanggal'              => ['required', 'date'],
            'jawaban'              => ['nullable', 'array'],
            'skor'                 => ['nullable', 'array'],
            'catatan_asesor'       => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'         => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'           => 'Mahasiswa yang dipilih tidak valid.',
            'instrumen_asesmen_id.required' => 'Instrumen asesmen wajib dipilih.',
            'instrumen_asesmen_id.exists'   => 'Instrumen asesmen yang dipilih tidak valid.',
            'tanggal.required'              => 'Tanggal pelaksanaan asesmen wajib diisi.',
            'tanggal.date'                  => 'Format tanggal tidak valid.',
        ];
    }
}
