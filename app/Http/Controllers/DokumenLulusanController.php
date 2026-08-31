<?php

namespace App\Http\Controllers;

use App\DataTables\DokumenLulusanDataTable;
use App\Http\Requests\DokumenLulusanRequest;
use App\Models\DokumenLulusan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DokumenLulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DokumenLulusanDataTable $dataTable)
    {
        return $dataTable->render('pages.dokumen-lulusan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $jenisList = ['Ijazah Digital', 'Transkrip Nilai Digital', 'SKPI Digital (Surat Keterangan Pendamping Ijazah)', 'SKL (Surat Keterangan Lulus)', 'Sertifikat Kompetensi'];

        return view('pages.dokumen-lulusan.create', compact('mahasiswa', 'jenisList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenLulusanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('dokumen_lulusan_files', 'public');
        }

        DokumenLulusan::create($data);

        Alert::success('Berhasil', 'Dokumen kelulusan berhasil ditambahkan.');

        return redirect()->route('dokumen-lulusan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokumen = DokumenLulusan::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $jenisList = ['Ijazah Digital', 'Transkrip Nilai Digital', 'SKPI Digital (Surat Keterangan Pendamping Ijazah)', 'SKL (Surat Keterangan Lulus)', 'Sertifikat Kompetensi'];

        return view('pages.dokumen-lulusan.edit', compact('dokumen', 'mahasiswa', 'jenisList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DokumenLulusanRequest $request, string $id)
    {
        $dokumen = DokumenLulusan::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
                Storage::disk('public')->delete($dokumen->file);
            }
            $data['file'] = $request->file('file')->store('dokumen_lulusan_files', 'public');
        }

        $dokumen->update($data);

        Alert::success('Berhasil', 'Dokumen kelulusan berhasil diperbarui.');

        return redirect()->route('dokumen-lulusan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = DokumenLulusan::findOrFail($id);

        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        $dokumen->delete();

        Alert::success('Berhasil', 'Dokumen kelulusan berhasil dihapus.');

        return redirect()->route('dokumen-lulusan.index');
    }
}
