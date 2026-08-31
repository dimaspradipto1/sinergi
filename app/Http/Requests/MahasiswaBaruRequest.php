<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MahasiswaBaruRequest extends FormRequest
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
        $mabaId = $this->route('mahasiswa_baru');

        return [
            'program_studi_id'  => ['required', 'exists:program_studis,id'],
            'tahun_akademik_id' => ['required', 'exists:tahun_akademiks,id'],
            'no_pendaftaran'    => [
                'required',
                'string',
                'max:50',
                Rule::unique('mahasiswa_barus', 'no_pendaftaran')->ignore($mabaId),
            ],
            'jalur_pendaftaran' => ['required', 'string', 'max:100'],
            'gelombang'         => ['nullable', 'string', 'max:50'],
            'nama_lengkap'      => ['required', 'string', 'max:255'],
            'nik'               => ['nullable', 'string', 'max:30'],
            'jenis_kelamin'     => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'      => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'     => ['nullable', 'date'],
            'email'             => ['nullable', 'email', 'max:255'],
            'no_hp'             => ['nullable', 'string', 'max:20'],
            'asal_sekolah'      => ['nullable', 'string', 'max:255'],
            'alamat'            => ['nullable', 'string'],
            'status_kelulusan'  => ['required', 'in:Diterima,Cadangan,Proses Seleksi,Tidak Lulus'],
            'status_registrasi' => ['required', 'in:Belum Registrasi,Registrasi Ulang,Batal / Mengundurkan Diri'],
            'foto'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'program_studi_id.required'  => 'Pilihan program studi wajib diisi.',
            'program_studi_id.exists'    => 'Program studi tidak valid.',
            'tahun_akademik_id.required' => 'Tahun akademik / angkatan wajib dipilih.',
            'tahun_akademik_id.exists'   => 'Tahun akademik tidak valid.',
            'no_pendaftaran.required'    => 'Nomor pendaftaran wajib diisi.',
            'no_pendaftaran.unique'      => 'Nomor pendaftaran sudah terdaftar.',
            'jalur_pendaftaran.required' => 'Jalur pendaftaran wajib dipilih.',
            'nama_lengkap.required'      => 'Nama lengkap wajib diisi.',
            'jenis_kelamin.required'     => 'Jenis kelamin wajib dipilih.',
            'email.email'                => 'Format email tidak valid.',
            'foto.image'                 => 'Berkas foto harus berupa gambar.',
            'foto.mimes'                 => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'foto.max'                   => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
