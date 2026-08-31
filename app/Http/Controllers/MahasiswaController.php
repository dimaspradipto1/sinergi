<?php

namespace App\Http\Controllers;

use App\DataTables\MahasiswaDataTable;
use App\Http\Requests\MahasiswaRequest;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MahasiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::orderBy('program_studi', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('id', 'desc')->get();
        $statusList = ['Aktif', 'Cuti', 'Lulus', 'Drop Out', 'Mengundurkan Diri'];
        $jalurMasukList = ['SNBP', 'SNBT', 'Mandiri', 'Beasiswa', 'Prestasi', 'Pindahan / Alih Jenjang'];

        return view('pages.mahasiswa.create', compact('programStudi', 'tahunAkademik', 'statusList', 'jalurMasukList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        Mahasiswa::create($data);

        Alert::success('Berhasil', 'Data mahasiswa berhasil ditambahkan.');

        return redirect()->route('mahasiswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $programStudi = ProgramStudi::orderBy('program_studi', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('id', 'desc')->get();
        $statusList = ['Aktif', 'Cuti', 'Lulus', 'Drop Out', 'Mengundurkan Diri'];
        $jalurMasukList = ['SNBP', 'SNBT', 'Mandiri', 'Beasiswa', 'Prestasi', 'Pindahan / Alih Jenjang'];

        return view('pages.mahasiswa.edit', compact('mahasiswa', 'programStudi', 'tahunAkademik', 'statusList', 'jalurMasukList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaRequest $request, string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($data);

        Alert::success('Berhasil', 'Data mahasiswa berhasil diperbarui.');

        return redirect()->route('mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }

        $mahasiswa->delete();

        Alert::success('Berhasil', 'Data mahasiswa berhasil dihapus.');

        return redirect()->route('mahasiswa.index');
    }
}
