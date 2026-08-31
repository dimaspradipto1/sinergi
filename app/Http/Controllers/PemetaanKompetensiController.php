<?php

namespace App\Http\Controllers;

use App\Models\AsesmenMahasiswa;
use App\Models\InstrumenAsesmen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class PemetaanKompetensiController extends Controller
{
    /**
     * Display a listing of the competency mapping analytics.
     */
    public function index()
    {
        $totalAsesmen = AsesmenMahasiswa::count();
        $totalMahasiswaTerasesmen = AsesmenMahasiswa::distinct('mahasiswa_id')->count('mahasiswa_id');
        $totalInstrumen = InstrumenAsesmen::count();

        // Rata-rata skor per instrumen
        $skorPerInstrumen = AsesmenMahasiswa::join('instrumen_asesmens', 'asesmen_mahasiswas.instrumen_asesmen_id', '=', 'instrumen_asesmens.id')
            ->select('instrumen_asesmens.nama_instrumen', DB::raw('AVG(asesmen_mahasiswas.nilai_total) as rata_rata'), DB::raw('COUNT(asesmen_mahasiswas.id) as total_peserta'))
            ->groupBy('instrumen_asesmens.nama_instrumen')
            ->get();

        // Distribusi kategori
        $kategoriDistribusi = AsesmenMahasiswa::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Daftar asesmen terbaru
        $riwayatAsesmen = AsesmenMahasiswa::with(['mahasiswa.programStudi', 'instrumenAsesmen'])
            ->latest('tanggal')
            ->limit(10)
            ->get();

        return view('pages.pemetaan-kompetensi.index', compact(
            'totalAsesmen',
            'totalMahasiswaTerasesmen',
            'totalInstrumen',
            'skorPerInstrumen',
            'kategoriDistribusi',
            'riwayatAsesmen'
        ));
    }
}
