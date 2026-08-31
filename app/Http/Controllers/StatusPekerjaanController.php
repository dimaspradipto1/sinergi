<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusPekerjaanController extends Controller
{
    /**
     * Display analytical dashboard for Status Pekerjaan & Tracer Study.
     */
    public function index(Request $request)
    {
        $totalAlumni = Alumni::count();
        $totalTracer = TracerStudy::count();

        // Rata-rata Masa Tunggu & Relevansi
        $avgWaktuTunggu = TracerStudy::avg('waktu_tunggu') ?? 0;
        $avgRelevansi = TracerStudy::avg('relevansi_bidang') ?? 0;

        // Distribusi Status Pekerjaan
        $statusDistribution = TracerStudy::select('status_pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('status_pekerjaan')
            ->pluck('total', 'status_pekerjaan')
            ->toArray();

        // Distribusi Pendapatan
        $pendapatanDistribution = TracerStudy::select('pendapatan', DB::raw('count(*) as total'))
            ->groupBy('pendapatan')
            ->pluck('total', 'pendapatan')
            ->toArray();

        // Recent Tracer Studies
        $recentTracers = TracerStudy::with(['alumni.mahasiswa.programStudi'])
            ->latest()
            ->take(10)
            ->get();

        return view('pages.status-pekerjaan.index', compact(
            'totalAlumni',
            'totalTracer',
            'avgWaktuTunggu',
            'avgRelevansi',
            'statusDistribution',
            'pendapatanDistribution',
            'recentTracers'
        ));
    }
}
