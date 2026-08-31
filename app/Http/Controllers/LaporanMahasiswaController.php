<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class LaporanMahasiswaController extends Controller
{
    /**
     * Display filtered Mahasiswa report.
     */
    public function index(Request $request)
    {
        $tahunAkademik = TahunAkademik::orderBy('tahun_akademik', 'desc')->get();
        $fakultas = Fakultas::orderBy('fakultas', 'asc')->get();
        $programStudi = ProgramStudi::orderBy('program_studi', 'asc')->get();

        $query = Mahasiswa::with(['programStudi.fakultas', 'tahunAkademik', 'kebutuhanInklusif', 'orangTua']);

        if ($request->filled('tahun_akademik_id')) {
            $query->where('tahun_akademik_id', $request->tahun_akademik_id);
        }

        if ($request->filled('program_studi_id')) {
            $query->where('program_studi_id', $request->program_studi_id);
        } elseif ($request->filled('fakultas_id')) {
            $query->whereHas('programStudi', function ($q) use ($request) {
                $q->where('fakultas_id', $request->fakultas_id);
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('status_maba')) {
            $query->where('status_maba', $request->status_maba);
        }

        $mahasiswaList = $query->orderBy('nama', 'asc')->get();

        // Rekapitulasi Statistik
        $totalMahasiswa = $mahasiswaList->count();
        $totalLaki = $mahasiswaList->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = $mahasiswaList->where('jenis_kelamin', 'P')->count();
        $totalMaba = $mahasiswaList->where('status_maba', 'Ya')->count();

        return view('pages.laporan.mahasiswa.index', compact(
            'tahunAkademik',
            'fakultas',
            'programStudi',
            'mahasiswaList',
            'totalMahasiswa',
            'totalLaki',
            'totalPerempuan',
            'totalMaba'
        ));
    }
}
