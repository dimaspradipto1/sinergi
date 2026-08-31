<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WisudaRequest extends FormRequest
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
            'mahasiswa_id'            => ['required', 'exists:mahasiswas,id'],
            'periode_wisuda'          => ['required', 'string', 'max:150'],
            'tanggal_wisuda'          => ['required', 'date'],
            'nomor_kursi'             => ['nullable', 'string', 'max:50'],
            'status_kehadiran'        => ['required', 'in:Terdaftar,Hadir,Tidak Hadir'],
            'kebutuhan_khusus_wisuda' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'     => 'Mahasiswa wajib dipilih.',
            'periode_wisuda.required'   => 'Periode wisuda wajib diisi.',
            'tanggal_wisuda.required'   => 'Tanggal pelaksanaan wisuda wajib diisi.',
            'status_kehadiran.required' => 'Status kehadiran wajib dipilih.',
        ];
    }
}
