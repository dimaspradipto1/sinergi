<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class LaporanAlumniController extends Controller
{
    /**
     * Display filtered Alumni & Kelulusan report.
     */
    public function index(Request $request)
    {
        $tahunLulusList = Alumni::distinct()->pluck('tahun_lulus')->sortDesc();
        $programStudiList = ProgramStudi::orderBy('program_studi', 'asc')->get();

        $query = Alumni::with(['mahasiswa.programStudi.fakultas', 'mahasiswa.kelulusan', 'tracerStudies', 'karierAlumnis.perusahaan']);

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        if ($request->filled('program_studi_id')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi_id);
            });
        }

        $alumniList = $query->latest('tahun_lulus')->get();

        $totalAlumni = $alumniList->count();
        $totalBekerja = $alumniList->filter(function ($alm) {
            return !empty($alm->pekerjaan_sekarang) || $alm->karierAlumnis->count() > 0;
        })->count();

        $totalTracerTerisi = $alumniList->filter(function ($alm) {
            return $alm->tracerStudies->count() > 0;
        })->count();

        return view('pages.laporan.alumni.index', compact(
            'tahunLulusList',
            'programStudiList',
            'alumniList',
            'totalAlumni',
            'totalBekerja',
            'totalTracerTerisi'
        ));
    }
}
