<?php

namespace App\Http\Controllers;

use App\DataTables\TracerStudyDataTable;
use App\Http\Requests\TracerStudyRequest;
use App\Models\Alumni;
use App\Models\TracerStudy;
use RealRashid\SweetAlert\Facades\Alert;

class TracerStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TracerStudyDataTable $dataTable)
    {
        return $dataTable->render('pages.tracer-study.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumni = Alumni::with('mahasiswa')->get();
        $statusList = [
            'Bekerja (Full-Time / Penuh Waktu)',
            'Bekerja (Part-Time / Paruh Waktu)',
            'Wirausaha / Mandiri / Freelancer',
            'Melanjutkan Studi (S2 / Kursus Profesi)',
            'Sedang Mencari Pekerjaan',
            'Belum Memungkinkan Bekerja',
        ];
        $pendapatanList = [
            '< Rp 3.000.000',
            'Rp 3.000.000 - Rp 5.000.000',
            'Rp 5.000.000 - Rp 10.000.000',
            '> Rp 10.000.000',
        ];

        return view('pages.tracer-study.create', compact('alumni', 'statusList', 'pendapatanList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TracerStudyRequest $request)
    {
        TracerStudy::create($request->validated());

        Alert::success('Berhasil', 'Data tracer study alumni berhasil disimpan.');

        return redirect()->route('tracer-study.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tracerStudy = TracerStudy::findOrFail($id);
        $alumni = Alumni::with('mahasiswa')->get();
        $statusList = [
            'Bekerja (Full-Time / Penuh Waktu)',
            'Bekerja (Part-Time / Paruh Waktu)',
            'Wirausaha / Mandiri / Freelancer',
            'Melanjutkan Studi (S2 / Kursus Profesi)',
            'Sedang Mencari Pekerjaan',
            'Belum Memungkinkan Bekerja',
        ];
        $pendapatanList = [
            '< Rp 3.000.000',
            'Rp 3.000.000 - Rp 5.000.000',
            'Rp 5.000.000 - Rp 10.000.000',
            '> Rp 10.000.000',
        ];

        return view('pages.tracer-study.edit', compact('tracerStudy', 'alumni', 'statusList', 'pendapatanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TracerStudyRequest $request, string $id)
    {
        $tracerStudy = TracerStudy::findOrFail($id);
        $tracerStudy->update($request->validated());

        Alert::success('Berhasil', 'Data tracer study alumni berhasil diperbarui.');

        return redirect()->route('tracer-study.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tracerStudy = TracerStudy::findOrFail($id);
        $tracerStudy->delete();

        Alert::success('Berhasil', 'Data tracer study alumni berhasil dihapus.');

        return redirect()->route('tracer-study.index');
    }
}
