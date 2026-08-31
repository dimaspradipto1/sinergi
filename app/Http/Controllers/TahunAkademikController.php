<?php

namespace App\Http\Controllers;

use App\DataTables\TahunAkademikDataTable;
use App\Http\Requests\TahunAkademikRequest;
use App\Models\TahunAkademik;
use RealRashid\SweetAlert\Facades\Alert;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TahunAkademikDataTable $dataTable)
    {
        return $dataTable->render('pages.tahun-akademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tahun-akademik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAkademikRequest $request)
    {
        TahunAkademik::create($request->validated());

        Alert::success('Berhasil', 'Data tahun akademik berhasil ditambahkan.');

        return redirect()->route('tahun-akademik.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);

        return view('pages.tahun-akademik.edit', compact('tahunAkademik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAkademikRequest $request, string $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);

        $tahunAkademik->update($request->validated());

        Alert::success('Berhasil', 'Data tahun akademik berhasil diperbarui.');

        return redirect()->route('tahun-akademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);

        $tahunAkademik->delete();

        Alert::success('Berhasil', 'Data tahun akademik berhasil dihapus.');

        return redirect()->route('tahun-akademik.index');
    }
}
