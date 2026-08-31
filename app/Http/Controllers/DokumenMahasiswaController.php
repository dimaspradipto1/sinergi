<?php

namespace App\Http\Controllers;

use App\DataTables\DokumenMahasiswaDataTable;
use App\Http\Requests\DokumenMahasiswaRequest;
use App\Models\DokumenMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DokumenMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DokumenMahasiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.dokumen-mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $jenisDokumenList = [
            'Surat Keterangan Disabilitas / Medis',
            'Hasil Asesmen Psikologis',
            'Kartu Tanda Penduduk (KTP)',
            'Kartu Keluarga (KK)',
            'Ijazah / Transkrip Nilai',
            'Surat Rekomendasi / Pendampingan',
            'Sertifikat Prestasi / Pelatihan',
            'Dokumen Lainnya'
        ];

        return view('pages.dokumen-mahasiswa.create', compact('mahasiswa', 'jenisDokumenList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenMahasiswaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-mahasiswa', 'public');
        }

        DokumenMahasiswa::create($data);

        Alert::success('Berhasil', 'Dokumen mahasiswa berhasil diunggah.');

        return redirect()->route('dokumen-mahasiswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $jenisDokumenList = [
            'Surat Keterangan Disabilitas / Medis',
            'Hasil Asesmen Psikologis',
            'Kartu Tanda Penduduk (KTP)',
            'Kartu Keluarga (KK)',
            'Ijazah / Transkrip Nilai',
            'Surat Rekomendasi / Pendampingan',
            'Sertifikat Prestasi / Pelatihan',
            'Dokumen Lainnya'
        ];

        return view('pages.dokumen-mahasiswa.edit', compact('dokumen', 'mahasiswa', 'jenisDokumenList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DokumenMahasiswaRequest $request, string $id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('file_dokumen')) {
            if ($dokumen->file_dokumen && Storage::disk('public')->exists($dokumen->file_dokumen)) {
                Storage::disk('public')->delete($dokumen->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-mahasiswa', 'public');
        }

        $dokumen->update($data);

        Alert::success('Berhasil', 'Dokumen mahasiswa berhasil diperbarui.');

        return redirect()->route('dokumen-mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($id);

        if ($dokumen->file_dokumen && Storage::disk('public')->exists($dokumen->file_dokumen)) {
            Storage::disk('public')->delete($dokumen->file_dokumen);
        }

        $dokumen->delete();

        Alert::success('Berhasil', 'Dokumen mahasiswa berhasil dihapus.');

        return redirect()->route('dokumen-mahasiswa.index');
    }
}
