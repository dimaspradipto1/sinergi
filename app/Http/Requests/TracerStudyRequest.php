<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TracerStudyRequest extends FormRequest
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
            'alumni_id'        => ['required', 'exists:alumnis,id'],
            'tahun_survey'     => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'status_pekerjaan' => ['required', 'string', 'max:150'],
            'waktu_tunggu'     => ['required', 'integer', 'min:0', 'max:120'],
            'relevansi_bidang' => ['required', 'integer', 'min:0', 'max:100'],
            'pendapatan'       => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'alumni_id.required'        => 'Data alumni wajib dipilih.',
            'tahun_survey.required'     => 'Tahun survey wajib diisi.',
            'status_pekerjaan.required' => 'Status pekerjaan saat ini wajib dipilih.',
            'waktu_tunggu.required'     => 'Masa tunggu kerja wajib diisi dalam bulan.',
            'relevansi_bidang.required' => 'Relevansi bidang studi (0-100%) wajib diisi.',
            'pendapatan.required'       => 'Range pendapatan per bulan wajib dipilih.',
        ];
    }
}
