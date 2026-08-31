<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class LaporanAkademikController extends Controller
{
    /**
     * Display filtered Akademik & IPK report.
     */
    public function index(Request $request)
    {
        $tahunAkademikList = TahunAkademik::orderBy('tahun_akademik', 'desc')->get();
        $programStudiList = ProgramStudi::orderBy('program_studi', 'asc')->get();

        $query = Mahasiswa::with(['programStudi.fakultas', 'krs.nilaiMahasiswas.mataKuliah', 'prestasis', 'sertifikasis']);

        if ($request->filled('program_studi_id')) {
            $query->where('program_studi_id', $request->program_studi_id);
        }

        if ($request->filled('tahun_akademik_id')) {
            $query->where('tahun_akademik_id', $request->tahun_akademik_id);
        }

        $allMahasiswa = $query->orderBy('nama', 'asc')->get();

        $rekapAkademik = [];
        $totalIpk = 0;
        $countIpk = 0;
        $totalCumlaude = 0;
        $totalSangatMemuaskan = 0;

        foreach ($allMahasiswa as $mhs) {
            $totalBobotSks = 0;
            $totalSks = 0;

            foreach ($mhs->krs as $krs) {
                if ($request->filled('tahun_akademik') && $krs->tahun_akademik != $request->tahun_akademik) {
                    continue;
                }
                if ($request->filled('semester') && $krs->semester != $request->semester) {
                    continue;
                }

                foreach ($krs->nilaiMahasiswas as $nilai) {
                    $sks = $nilai->mataKuliah->sks ?? 0;
                    $bobot = $nilai->bobot;
                    $totalBobotSks += ($sks * $bobot);
                    $totalSks += $sks;
                }
            }

            $ipk = $totalSks > 0 ? round($totalBobotSks / $totalSks, 2) : 0.00;

            if ($ipk > 0) {
                $totalIpk += $ipk;
                $countIpk++;

                if ($ipk >= 3.50) {
                    $totalCumlaude++;
                } elseif ($ipk >= 3.00) {
                    $totalSangatMemuaskan++;
                }
            }

            $rekapAkademik[] = [
                'mahasiswa'       => $mhs,
                'total_sks'       => $totalSks,
                'ipk'             => $ipk,
                'total_prestasi'  => $mhs->prestasis->count(),
                'total_sertifikat'=> $mhs->sertifikasis->count(),
            ];
        }

        $avgIpk = $countIpk > 0 ? round($totalIpk / $countIpk, 2) : 0.00;
        $totalMahasiswa = count($rekapAkademik);

        return view('pages.laporan.akademik.index', compact(
            'tahunAkademikList',
            'programStudiList',
            'rekapAkademik',
            'totalMahasiswa',
            'avgIpk',
            'totalCumlaude',
            'totalSangatMemuaskan'
        ));
    }
}
