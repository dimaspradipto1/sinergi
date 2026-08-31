<?php

namespace App\Http\Controllers;

use App\Models\TracerStudy;
use Illuminate\Http\Request;

class LaporanTracerStudyController extends Controller
{
    /**
     * Display filtered Tracer Study report.
     */
    public function index(Request $request)
    {
        $tahunSurveyList = TracerStudy::distinct()->pluck('tahun_survey')->sortDesc();
        $statusList = [
            'Bekerja (Full-Time / Penuh Waktu)',
            'Bekerja (Part-Time / Paruh Waktu)',
            'Wirausaha / Mandiri / Freelancer',
            'Melanjutkan Studi (S2 / Kursus Profesi)',
            'Sedang Mencari Pekerjaan',
            'Belum Memungkinkan Bekerja',
        ];

        $query = TracerStudy::with(['alumni.mahasiswa.programStudi']);

        if ($request->filled('tahun_survey')) {
            $query->where('tahun_survey', $request->tahun_survey);
        }

        if ($request->filled('status_pekerjaan')) {
            $query->where('status_pekerjaan', $request->status_pekerjaan);
        }

        $tracerList = $query->orderBy('tahun_survey', 'desc')->get();

        $totalResponden = $tracerList->count();
        $avgWaktuTunggu = $totalResponden > 0 ? round($tracerList->avg('waktu_tunggu'), 1) : 0;
        $avgRelevansi = $totalResponden > 0 ? round($tracerList->avg('relevansi_bidang'), 1) : 0;

        return view('pages.laporan.tracer-study.index', compact(
            'tahunSurveyList',
            'statusList',
            'tracerList',
            'totalResponden',
            'avgWaktuTunggu',
            'avgRelevansi'
        ));
    }
}
