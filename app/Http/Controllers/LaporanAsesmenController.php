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
        $instrumenList = InstrumenAsesmen::orderBy('nama_asesmen', 'asc')->get();

        $query = AsesmenMahasiswa::with(['mahasiswa.programStudi', 'instrumenAsesmen', 'jawabanAsesmens.pertanyaanAsesmen']);

        if ($request->filled('instrumen_asesmen_id')) {
            $query->where('instrumen_asesmen_id', $request->instrumen_asesmen_id);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_asesmen', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_asesmen', '<=', $request->tanggal_selesai);
        }

        $asesmenList = $query->orderBy('tanggal_asesmen', 'desc')->get();

        $totalAsesmen = $asesmenList->count();
        $avgSkor = $totalAsesmen > 0 ? round($asesmenList->avg('skor_total'), 1) : 0;
        $totalTinggi = $asesmenList->filter(function ($a) {
            return str_contains(strtolower($a->rekomendasi ?? ''), 'tinggi') || $a->skor_total >= 80;
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
