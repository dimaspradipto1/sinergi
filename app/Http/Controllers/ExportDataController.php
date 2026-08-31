<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AsesmenMahasiswa;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Perusahaan;
use App\Models\TracerStudy;
use App\Models\Wisuda;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportDataController extends Controller
{
    /**
     * Display Export Center Hub.
     */
    public function index()
    {
        $countMahasiswa = Mahasiswa::count();
        $countNilai = NilaiMahasiswa::count();
        $countAsesmen = AsesmenMahasiswa::count();
        $countAlumni = Alumni::count();
        $countTracer = TracerStudy::count();
        $countWisuda = Wisuda::count();
        $countPerusahaan = Perusahaan::count();

        return view('pages.laporan.export.index', compact(
            'countMahasiswa',
            'countNilai',
            'countAsesmen',
            'countAlumni',
            'countTracer',
            'countWisuda',
            'countPerusahaan'
        ));
    }

    /**
     * Export entity data to CSV stream.
     */
    public function export(Request $request, string $type)
    {
        $filename = "export_{$type}_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () use ($type) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Indonesian characters and Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            switch ($type) {
                case 'mahasiswa':
                    fputcsv($file, ['No', 'NIM', 'Nama Mahasiswa', 'Jenis Kelamin', 'Program Studi', 'Fakultas', 'Tahun Angkatan', 'Status MABA', 'No HP', 'Email']);
                    $data = Mahasiswa::with(['programStudi.fakultas', 'tahunAkademik'])->get();
                    foreach ($data as $index => $mhs) {
                        fputcsv($file, [
                            $index + 1,
                            $mhs->nim,
                            $mhs->nama,
                            $mhs->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                            $mhs->programStudi->program_studi ?? '-',
                            $mhs->programStudi->fakultas->nama_fakultas ?? '-',
                            $mhs->tahunAkademik->tahun_akademik ?? '-',
                            $mhs->status_maba,
                            $mhs->no_hp,
                            $mhs->email,
                        ]);
                    }
                    break;

                case 'alumni':
                    fputcsv($file, ['No', 'NIM', 'Nama Alumni', 'Program Studi', 'Tahun Lulus', 'Pekerjaan Sekarang', 'Instansi Tempat Kerja', 'No HP', 'Email']);
                    $data = Alumni::with(['mahasiswa.programStudi'])->get();
                    foreach ($data as $index => $alm) {
                        fputcsv($file, [
                            $index + 1,
                            $alm->mahasiswa->nim ?? '-',
                            $alm->mahasiswa->nama ?? '-',
                            $alm->mahasiswa->programStudi->program_studi ?? '-',
                            $alm->tahun_lulus,
                            $alm->pekerjaan_sekarang ?? '-',
                            $alm->instansi_tempat_kerja ?? '-',
                            $alm->no_hp_aktif ?? '-',
                            $alm->email_aktif ?? '-',
                        ]);
                    }
                    break;

                case 'tracer':
                    fputcsv($file, ['No', 'NIM', 'Nama Alumni', 'Program Studi', 'Tahun Survey', 'Status Pekerjaan', 'Masa Tunggu (Bulan)', 'Relevansi Bidang (%)', 'Pendapatan']);
                    $data = TracerStudy::with(['alumni.mahasiswa.programStudi'])->get();
                    foreach ($data as $index => $tr) {
                        fputcsv($file, [
                            $index + 1,
                            $tr->alumni->mahasiswa->nim ?? '-',
                            $tr->alumni->mahasiswa->nama ?? '-',
                            $tr->alumni->mahasiswa->programStudi->program_studi ?? '-',
                            $tr->tahun_survey,
                            $tr->status_pekerjaan,
                            $tr->waktu_tunggu,
                            $tr->relevansi_bidang,
                            $tr->pendapatan,
                        ]);
                    }
                    break;

                case 'asesmen':
                    fputcsv($file, ['No', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Instrumen Asesmen', 'Tanggal Asesmen', 'Nilai Total', 'Kategori', 'Catatan Asesor']);
                    $data = AsesmenMahasiswa::with(['mahasiswa.programStudi', 'instrumenAsesmen'])->get();
                    foreach ($data as $index => $as) {
                        fputcsv($file, [
                            $index + 1,
                            $as->mahasiswa->nim ?? '-',
                            $as->mahasiswa->nama ?? '-',
                            $as->mahasiswa->programStudi->program_studi ?? '-',
                            $as->instrumenAsesmen->nama_instrumen ?? '-',
                            $as->tanggal ? $as->tanggal->format('d/m/Y') : '-',
                            $as->nilai_total,
                            $as->kategori,
                            $as->catatan_asesor,
                        ]);
                    }
                    break;

                default:
                    fputcsv($file, ['Status', 'Data type not recognized']);
                    break;
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
