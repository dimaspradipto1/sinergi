<?php

namespace App\Http\Controllers;

use App\DataTables\WisudaDataTable;
use App\Http\Requests\WisudaRequest;
use App\Models\Mahasiswa;
use App\Models\Wisuda;
use RealRashid\SweetAlert\Facades\Alert;

class WisudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WisudaDataTable $dataTable)
    {
        return $dataTable->render('pages.wisuda.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.wisuda.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WisudaRequest $request)
    {
        Wisuda::create($request->validated());

        Alert::success('Berhasil', 'Data wisuda mahasiswa berhasil disimpan.');

        return redirect()->route('wisuda.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.wisuda.edit', compact('wisuda', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WisudaRequest $request, string $id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->update($request->validated());

        Alert::success('Berhasil', 'Data wisuda mahasiswa berhasil diperbarui.');

        return redirect()->route('wisuda.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->delete();

        Alert::success('Berhasil', 'Data wisuda mahasiswa berhasil dihapus.');

        return redirect()->route('wisuda.index');
    }
}
