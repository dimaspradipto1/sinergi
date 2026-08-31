<?php

namespace App\Http\Controllers;

use App\DataTables\KarierAlumniDataTable;
use App\Http\Requests\KarierAlumniRequest;
use App\Models\Alumni;
use App\Models\KarierAlumni;
use App\Models\Perusahaan;
use RealRashid\SweetAlert\Facades\Alert;

class KarierAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KarierAlumniDataTable $dataTable)
    {
        return $dataTable->render('pages.riwayat-karier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alumni = Alumni::with('mahasiswa')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        $statusKerjaList = [
            'Karyawan Tetap',
            'Karyawan Kontrak',
            'Freelance / Paruh Waktu',
            'Owner / Founder / Pemilik Usaha',
            'Internship / Magang',
        ];

        return view('pages.riwayat-karier.create', compact('alumni', 'perusahaan', 'statusKerjaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KarierAlumniRequest $request)
    {
        KarierAlumni::create($request->validated());

        Alert::success('Berhasil', 'Data riwayat karier alumni berhasil disimpan.');

        return redirect()->route('riwayat-karier.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karier = KarierAlumni::findOrFail($id);
        $alumni = Alumni::with('mahasiswa')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        $statusKerjaList = [
            'Karyawan Tetap',
            'Karyawan Kontrak',
            'Freelance / Paruh Waktu',
            'Owner / Founder / Pemilik Usaha',
            'Internship / Magang',
        ];

        return view('pages.riwayat-karier.edit', compact('karier', 'alumni', 'perusahaan', 'statusKerjaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KarierAlumniRequest $request, string $id)
    {
        $karier = KarierAlumni::findOrFail($id);
        $karier->update($request->validated());

        Alert::success('Berhasil', 'Data riwayat karier alumni berhasil diperbarui.');

        return redirect()->route('riwayat-karier.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karier = KarierAlumni::findOrFail($id);
        $karier->delete();

        Alert::success('Berhasil', 'Data riwayat karier alumni berhasil dihapus.');

        return redirect()->route('riwayat-karier.index');
    }
}
