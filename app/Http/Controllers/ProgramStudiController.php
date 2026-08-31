<?php

namespace App\Http\Controllers;

use App\DataTables\ProgramStudiDataTable;
use App\Http\Requests\ProgramStudiRequest;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use RealRashid\SweetAlert\Facades\Alert;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProgramStudiDataTable $dataTable)
    {
        return $dataTable->render('pages.program-studi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();

        return view('pages.program-studi.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgramStudiRequest $request)
    {
        ProgramStudi::create($request->validated());

        Alert::success('Berhasil', 'Data program studi berhasil ditambahkan.');

        return redirect()->route('program-studi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();

        return view('pages.program-studi.edit', compact('programStudi', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgramStudiRequest $request, string $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);

        $programStudi->update($request->validated());

        Alert::success('Berhasil', 'Data program studi berhasil diperbarui.');

        return redirect()->route('program-studi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);

        $programStudi->delete();

        Alert::success('Berhasil', 'Data program studi berhasil dihapus.');

        return redirect()->route('program-studi.index');
    }
}
