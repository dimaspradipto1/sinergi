<?php

namespace App\Http\Controllers;

use App\DataTables\SertifikasiDataTable;
use App\Http\Requests\SertifikasiRequest;
use App\Models\Mahasiswa;
use App\Models\Sertifikasi;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SertifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SertifikasiDataTable $dataTable)
    {
        return $dataTable->render('pages.sertifikasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.sertifikasi.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SertifikasiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('sertifikasi_files', 'public');
        }

        Sertifikasi::create($data);

        Alert::success('Berhasil', 'Sertifikasi mahasiswa berhasil ditambahkan.');

        return redirect()->route('sertifikasi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        return view('pages.sertifikasi.edit', compact('sertifikasi', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SertifikasiRequest $request, string $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($sertifikasi->file && Storage::disk('public')->exists($sertifikasi->file)) {
                Storage::disk('public')->delete($sertifikasi->file);
            }
            $data['file'] = $request->file('file')->store('sertifikasi_files', 'public');
        }

        $sertifikasi->update($data);

        Alert::success('Berhasil', 'Sertifikasi mahasiswa berhasil diperbarui.');

        return redirect()->route('sertifikasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);

        if ($sertifikasi->file && Storage::disk('public')->exists($sertifikasi->file)) {
            Storage::disk('public')->delete($sertifikasi->file);
        }

        $sertifikasi->delete();

        Alert::success('Berhasil', 'Sertifikasi mahasiswa berhasil dihapus.');

        return redirect()->route('sertifikasi.index');
    }
}
