<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenLulusanRequest extends FormRequest
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
            'mahasiswa_id'      => ['required', 'exists:mahasiswas,id'],
            'jenis_dokumen'     => ['required', 'string', 'max:150'],
            'nomor_dokumen'     => ['required', 'string', 'max:150'],
            'tanggal_terbit'    => ['required', 'date'],
            'file'              => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'status_verifikasi' => ['required', 'in:Terverifikasi,Menunggu Verifikasi,Ditolak'],
            'keterangan'        => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required'      => 'Mahasiswa wajib dipilih.',
            'jenis_dokumen.required'     => 'Jenis dokumen kelulusan wajib dipilih/diisi.',
            'nomor_dokumen.required'     => 'Nomor dokumen wajib diisi.',
            'tanggal_terbit.required'    => 'Tanggal terbit dokumen wajib diisi.',
            'status_verifikasi.required' => 'Status verifikasi dokumen wajib dipilih.',
            'file.mimes'                 => 'Format berkas harus PDF, JPG, JPEG, atau PNG.',
            'file.max'                   => 'Ukuran berkas maksimal 10MB.',
        ];
    }
}
