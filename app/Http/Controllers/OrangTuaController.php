<?php

namespace App\Http\Controllers;

use App\DataTables\OrangTuaDataTable;
use App\Http\Requests\OrangTuaRequest;
use App\Models\Mahasiswa;
use App\Models\OrangTua;
use RealRashid\SweetAlert\Facades\Alert;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrangTuaDataTable $dataTable)
    {
        return $dataTable->render('pages.orang-tua.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $pendidikanList = ['SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3', 'Tidak Sekolah'];
        $penghasilanList = ['< Rp 1.000.000', 'Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', 'Rp 5.000.000 - Rp 10.000.000', '> Rp 10.000.000', 'Tidak Berpenghasilan'];

        return view('pages.orang-tua.create', compact('mahasiswa', 'pendidikanList', 'penghasilanList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrangTuaRequest $request)
    {
        OrangTua::create($request->validated());

        Alert::success('Berhasil', 'Data orang tua/wali berhasil ditambahkan.');

        return redirect()->route('orang-tua.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orangTua = OrangTua::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $pendidikanList = ['SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3', 'Tidak Sekolah'];
        $penghasilanList = ['< Rp 1.000.000', 'Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', 'Rp 5.000.000 - Rp 10.000.000', '> Rp 10.000.000', 'Tidak Berpenghasilan'];

        return view('pages.orang-tua.edit', compact('orangTua', 'mahasiswa', 'pendidikanList', 'penghasilanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrangTuaRequest $request, string $id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $orangTua->update($request->validated());

        Alert::success('Berhasil', 'Data orang tua/wali berhasil diperbarui.');

        return redirect()->route('orang-tua.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $orangTua->delete();

        Alert::success('Berhasil', 'Data orang tua/wali berhasil dihapus.');

        return redirect()->route('orang-tua.index');
    }
}
