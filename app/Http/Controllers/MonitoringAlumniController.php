<?php

namespace App\Http\Controllers;

use App\DataTables\MonitoringAlumniDataTable;
use App\Models\Alumni;
use App\Models\TracerStudy;

class MonitoringAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MonitoringAlumniDataTable $dataTable)
    {
        $totalAlumni = Alumni::count();
        $totalSudahTracer = TracerStudy::distinct('alumni_id')->count('alumni_id');
        $persenTracer = $totalAlumni > 0 ? round(($totalSudahTracer / $totalAlumni) * 100, 1) : 0;
        $totalBelumTracer = max(0, $totalAlumni - $totalSudahTracer);

        return $dataTable->render('pages.monitoring-alumni.index', compact(
            'totalAlumni',
            'totalSudahTracer',
            'persenTracer',
            'totalBelumTracer'
        ));
    }
}
