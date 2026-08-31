<?php

namespace App\Http\Controllers;

use App\DataTables\FakultasDataTable;
use App\Http\Requests\FakultasRequest;
use App\Models\Fakultas;
use RealRashid\SweetAlert\Facades\Alert;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FakultasDataTable $dataTable)
    {
        return $dataTable->render('pages.fakultas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.fakultas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FakultasRequest $request)
    {
        Fakultas::create($request->validated());

        Alert::success('Berhasil', 'Data fakultas berhasil ditambahkan.');

        return redirect()->route('fakultas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        return view('pages.fakultas.edit', compact('fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FakultasRequest $request, string $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        $fakultas->update($request->validated());

        Alert::success('Berhasil', 'Data fakultas berhasil diperbarui.');

        return redirect()->route('fakultas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        $fakultas->delete();

        Alert::success('Berhasil', 'Data fakultas berhasil dihapus.');

        return redirect()->route('fakultas.index');
    }
}
