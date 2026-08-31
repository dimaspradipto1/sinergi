<?php

namespace App\Http\Controllers;

use App\DataTables\IpIpkDataTable;
use App\Models\Mahasiswa;

class IpIpkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IpIpkDataTable $dataTable)
    {
        return $dataTable->render('pages.ip-ipk.index');
    }

    /**
     * Display the specified resource (Transkrip Nilai & Rekap IP/IPK).
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::with([
            'programStudi.fakultas',
            'tahunAkademik',
            'krs' => function ($query) {
                $query->orderBy('semester', 'asc');
            },
            'krs.nilaiMahasiswas.mataKuliah'
        ])->findOrFail($id);

        $rekapSemester = [];
        $totalSksKumulatif = 0;
        $totalMutuKumulatif = 0;

        foreach ($mahasiswa->krs as $krsItem) {
            $sksSemester = 0;
            $mutuSemester = 0;

            foreach ($krsItem->nilaiMahasiswas as $nilai) {
                if ($nilai->mataKuliah) {
                    $sks = $nilai->mataKuliah->sks;
                    $bobot = $nilai->bobot;
                    $sksSemester += $sks;
                    $mutuSemester += ($sks * $bobot);
                }
            }

            $ips = $sksSemester > 0 ? round($mutuSemester / $sksSemester, 2) : 0.00;
            $totalSksKumulatif += $sksSemester;
            $totalMutuKumulatif += $mutuSemester;

            $rekapSemester[] = [
                'krs'           => $krsItem,
                'sks_semester'  => $sksSemester,
                'mutu_semester' => $mutuSemester,
                'ips'           => $ips,
            ];
        }

        $ipk = $totalSksKumulatif > 0 ? round($totalMutuKumulatif / $totalSksKumulatif, 2) : 0.00;

        return view('pages.ip-ipk.show', compact('mahasiswa', 'rekapSemester', 'totalSksKumulatif', 'ipk'));
    }
}
