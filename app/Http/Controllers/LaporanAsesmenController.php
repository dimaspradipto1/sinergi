<?php

namespace App\Http\Controllers;

use App\Models\AsesmenMahasiswa;
use App\Models\InstrumenAsesmen;
use Illuminate\Http\Request;

class LaporanAsesmenController extends Controller
{
    /**
     * Display filtered Asesmen Kompetensi report.
     */
    public function index(Request $request)
    {
        $instrumenList = InstrumenAsesmen::orderBy('nama_instrumen', 'asc')->get();

        $query = AsesmenMahasiswa::with(['mahasiswa.programStudi', 'instrumenAsesmen', 'jawabanAsesmens.pertanyaanAsesmen']);

        if ($request->filled('instrumen_asesmen_id')) {
            $query->where('instrumen_asesmen_id', $request->instrumen_asesmen_id);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $asesmenList = $query->orderBy('tanggal', 'desc')->get();

        $totalAsesmen = $asesmenList->count();
        $avgSkor = $totalAsesmen > 0 ? round($asesmenList->avg('nilai_total'), 1) : 0;
        $totalTinggi = $asesmenList->filter(function ($a) {
            $kat = strtolower($a->kategori ?? '');
            return str_contains($kat, 'sangat') || str_contains($kat, 'tinggi') || str_contains($kat, 'mahir') || $a->nilai_total >= 80;
        })->count();

        return view('pages.laporan.asesmen.index', compact(
            'instrumenList',
            'asesmenList',
            'totalAsesmen',
            'avgSkor',
            'totalTinggi'
        ));
    }
}
