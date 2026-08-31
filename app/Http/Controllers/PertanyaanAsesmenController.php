<?php

namespace App\Http\Controllers;

use App\DataTables\PertanyaanAsesmenDataTable;
use App\Http\Requests\PertanyaanAsesmenRequest;
use App\Models\InstrumenAsesmen;
use App\Models\PertanyaanAsesmen;
use RealRashid\SweetAlert\Facades\Alert;

class PertanyaanAsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PertanyaanAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.pertanyaan-asesmen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instrumen = InstrumenAsesmen::where('status', 'Aktif')->orderBy('nama_instrumen', 'asc')->get();
        $tipeJawabanList = [
            'Skala Likert (1 - 5)',
            'Skala Likert (1 - 4)',
            'Pilihan Ganda (A, B, C, D, E)',
            'Ya / Tidak (Boolean)',
            'Esai / Jawaban Terbuka'
        ];

        return view('pages.pertanyaan-asesmen.create', compact('instrumen', 'tipeJawabanList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PertanyaanAsesmenRequest $request)
    {
        PertanyaanAsesmen::create($request->validated());

        Alert::success('Berhasil', 'Pertanyaan asesmen berhasil ditambahkan.');

        return redirect()->route('pertanyaan-asesmen.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pertanyaan = PertanyaanAsesmen::findOrFail($id);
        $instrumen = InstrumenAsesmen::orderBy('nama_instrumen', 'asc')->get();
        $tipeJawabanList = [
            'Skala Likert (1 - 5)',
            'Skala Likert (1 - 4)',
            'Pilihan Ganda (A, B, C, D, E)',
            'Ya / Tidak (Boolean)',
            'Esai / Jawaban Terbuka'
        ];

        return view('pages.pertanyaan-asesmen.edit', compact('pertanyaan', 'instrumen', 'tipeJawabanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PertanyaanAsesmenRequest $request, string $id)
    {
        $pertanyaan = PertanyaanAsesmen::findOrFail($id);

        $pertanyaan->update($request->validated());

        Alert::success('Berhasil', 'Pertanyaan asesmen berhasil diperbarui.');

        return redirect()->route('pertanyaan-asesmen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pertanyaan = PertanyaanAsesmen::findOrFail($id);

        $pertanyaan->delete();

        Alert::success('Berhasil', 'Pertanyaan asesmen berhasil dihapus.');

        return redirect()->route('pertanyaan-asesmen.index');
    }
}
