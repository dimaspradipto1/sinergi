<?php

namespace App\Http\Controllers;

use App\DataTables\KelulusanDataTable;
use App\Http\Requests\KelulusanRequest;
use App\Models\Kelulusan;
use App\Models\Mahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class KelulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KelulusanDataTable $dataTable)
    {
        return $dataTable->render('pages.data-kelulusan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $predikatList = ['Dengan Pujian (Cumlaude)', 'Sangat Memuaskan', 'Memuaskan', 'Cukup'];

        return view('pages.data-kelulusan.create', compact('mahasiswa', 'predikatList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelulusanRequest $request)
    {
        Kelulusan::create($request->validated());

        Alert::success('Berhasil', 'Data kelulusan mahasiswa berhasil disimpan.');

        return redirect()->route('data-kelulusan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelulusan = Kelulusan::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $predikatList = ['Dengan Pujian (Cumlaude)', 'Sangat Memuaskan', 'Memuaskan', 'Cukup'];

        return view('pages.data-kelulusan.edit', compact('kelulusan', 'mahasiswa', 'predikatList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelulusanRequest $request, string $id)
    {
        $kelulusan = Kelulusan::findOrFail($id);
        $kelulusan->update($request->validated());

        Alert::success('Berhasil', 'Data kelulusan mahasiswa berhasil diperbarui.');

        return redirect()->route('data-kelulusan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelulusan = Kelulusan::findOrFail($id);
        $kelulusan->delete();

        Alert::success('Berhasil', 'Data kelulusan mahasiswa berhasil dihapus.');

        return redirect()->route('data-kelulusan.index');
    }
}
