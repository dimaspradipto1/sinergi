<?php

namespace App\Http\Controllers;

use App\DataTables\KebutuhanInklusifDataTable;
use App\Http\Requests\KebutuhanInklusifRequest;
use App\Models\KebutuhanInklusif;
use App\Models\Mahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class KebutuhanInklusifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KebutuhanInklusifDataTable $dataTable)
    {
        return $dataTable->render('pages.kebutuhan-inklusif.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $kategoriList = [
            'Disabilitas Sensorik (Netra / Rungu / Wicara)',
            'Disabilitas Fisik / Motorik (Daksa / Mobilitas)',
            'Disabilitas Intelektual / Kesulitan Belajar',
            'Disabilitas Mental / Psikososial (Autisme, ADHD, Bipolar, dll)',
            'Disabilitas Ganda / Kombinasi',
            'Kebutuhan Khusus Lainnya'
        ];

        return view('pages.kebutuhan-inklusif.create', compact('mahasiswa', 'kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KebutuhanInklusifRequest $request)
    {
        KebutuhanInklusif::create($request->validated());

        Alert::success('Berhasil', 'Data kebutuhan inklusif berhasil ditambahkan.');

        return redirect()->route('kebutuhan-inklusif.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kebutuhan = KebutuhanInklusif::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $kategoriList = [
            'Disabilitas Sensorik (Netra / Rungu / Wicara)',
            'Disabilitas Fisik / Motorik (Daksa / Mobilitas)',
            'Disabilitas Intelektual / Kesulitan Belajar',
            'Disabilitas Mental / Psikososial (Autisme, ADHD, Bipolar, dll)',
            'Disabilitas Ganda / Kombinasi',
            'Kebutuhan Khusus Lainnya'
        ];

        return view('pages.kebutuhan-inklusif.edit', compact('kebutuhan', 'mahasiswa', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KebutuhanInklusifRequest $request, string $id)
    {
        $kebutuhan = KebutuhanInklusif::findOrFail($id);

        $kebutuhan->update($request->validated());

        Alert::success('Berhasil', 'Data kebutuhan inklusif berhasil diperbarui.');

        return redirect()->route('kebutuhan-inklusif.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kebutuhan = KebutuhanInklusif::findOrFail($id);

        $kebutuhan->delete();

        Alert::success('Berhasil', 'Data kebutuhan inklusif berhasil dihapus.');

        return redirect()->route('kebutuhan-inklusif.index');
    }
}
