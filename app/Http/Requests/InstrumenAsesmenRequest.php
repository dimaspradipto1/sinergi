<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumenAsesmenRequest extends FormRequest
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
            'nama_instrumen' => ['required', 'string', 'max:255'],
            'kategori'       => ['required', 'string', 'max:100'],
            'deskripsi'      => ['nullable', 'string'],
            'status'         => ['required', 'in:Aktif,Nonaktif'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_instrumen.required' => 'Nama instrumen asesmen wajib diisi.',
            'kategori.required'       => 'Kategori instrumen wajib dipilih.',
            'status.required'         => 'Status instrumen wajib dipilih.',
            'status.in'               => 'Status harus berupa Aktif atau Nonaktif.',
        ];
    }
}
