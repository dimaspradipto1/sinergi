<?php

namespace App\Http\Controllers;

use App\DataTables\PrestasiDataTable;
use App\Http\Requests\PrestasiRequest;
use App\Models\Mahasiswa;
use App\Models\Prestasi;
use RealRashid\SweetAlert\Facades\Alert;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PrestasiDataTable $dataTable)
    {
        return $dataTable->render('pages.prestasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $tingkatList = ['Internasional', 'Nasional', 'Provinsi', 'Kota / Kabupaten', 'Universitas', 'Fakultas / Prodi'];

        return view('pages.prestasi.create', compact('mahasiswa', 'tingkatList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrestasiRequest $request)
    {
        Prestasi::create($request->validated());

        Alert::success('Berhasil', 'Prestasi mahasiswa berhasil ditambahkan.');

        return redirect()->route('prestasi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $tingkatList = ['Internasional', 'Nasional', 'Provinsi', 'Kota / Kabupaten', 'Universitas', 'Fakultas / Prodi'];

        return view('pages.prestasi.edit', compact('prestasi', 'mahasiswa', 'tingkatList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrestasiRequest $request, string $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($request->validated());

        Alert::success('Berhasil', 'Prestasi mahasiswa berhasil diperbarui.');

        return redirect()->route('prestasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();

        Alert::success('Berhasil', 'Prestasi mahasiswa berhasil dihapus.');

        return redirect()->route('prestasi.index');
    }
}
