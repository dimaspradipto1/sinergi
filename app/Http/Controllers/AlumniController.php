<?php

namespace App\Http\Controllers;

use App\DataTables\AlumniDataTable;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;
use App\Models\Mahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AlumniDataTable $dataTable)
    {
        return $dataTable->render('pages.alumni.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.alumni.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlumniRequest $request)
    {
        Alumni::create($request->validated());

        Alert::success('Berhasil', 'Data alumni berhasil ditambahkan.');

        return redirect()->route('alumni.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alumni = Alumni::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.alumni.edit', compact('alumni', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumniRequest $request, string $id)
    {
        $alumni = Alumni::findOrFail($id);

        $alumni->update($request->validated());

        Alert::success('Berhasil', 'Data alumni berhasil diperbarui.');

        return redirect()->route('alumni.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumni = Alumni::findOrFail($id);

        $alumni->delete();

        Alert::success('Berhasil', 'Data alumni berhasil dihapus.');

        return redirect()->route('alumni.index');
    }
}
