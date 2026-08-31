<?php

namespace App\Http\Controllers;

use App\DataTables\MataKuliahDataTable;
use App\Http\Requests\MataKuliahRequest;
use App\Models\MataKuliah;
use RealRashid\SweetAlert\Facades\Alert;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MataKuliahDataTable $dataTable)
    {
        return $dataTable->render('pages.mata-kuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mata-kuliah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MataKuliahRequest $request)
    {
        MataKuliah::create($request->validated());

        Alert::success('Berhasil', 'Mata kuliah berhasil ditambahkan.');

        return redirect()->route('mata-kuliah.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);

        return view('pages.mata-kuliah.edit', compact('mataKuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MataKuliahRequest $request, string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->update($request->validated());

        Alert::success('Berhasil', 'Mata kuliah berhasil diperbarui.');

        return redirect()->route('mata-kuliah.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->delete();

        Alert::success('Berhasil', 'Mata kuliah berhasil dihapus.');

        return redirect()->route('mata-kuliah.index');
    }
}
