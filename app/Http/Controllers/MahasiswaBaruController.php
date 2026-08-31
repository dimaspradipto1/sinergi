<?php

namespace App\Http\Controllers;

use App\DataTables\MahasiswaBaruDataTable;
use App\Http\Requests\MahasiswaBaruRequest;
use App\Models\MahasiswaBaru;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaBaruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MahasiswaBaruDataTable $dataTable)
    {
        return $dataTable->render('pages.mahasiswa-baru.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::orderBy('program_studi', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('id', 'desc')->get();
        $jalurList = ['SNBP', 'SNBT', 'Mandiri Reguler', 'Prestasi Akademik / Non-Akademik', 'Beasiswa KIP-K', 'Kemitraan'];
        $gelombangList = ['Gelombang 1', 'Gelombang 2', 'Gelombang 3', 'Gelombang Khusus'];
        $kelulusanList = ['Diterima', 'Cadangan', 'Proses Seleksi', 'Tidak Lulus'];
        $registrasiList = ['Belum Registrasi', 'Registrasi Ulang', 'Batal / Mengundurkan Diri'];

        return view('pages.mahasiswa-baru.create', compact('programStudi', 'tahunAkademik', 'jalurList', 'gelombangList', 'kelulusanList', 'registrasiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaBaruRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa-baru', 'public');
        }

        MahasiswaBaru::create($data);

        Alert::success('Berhasil', 'Data mahasiswa baru berhasil ditambahkan.');

        return redirect()->route('mahasiswa-baru.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maba = MahasiswaBaru::findOrFail($id);
        $programStudi = ProgramStudi::orderBy('program_studi', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('id', 'desc')->get();
        $jalurList = ['SNBP', 'SNBT', 'Mandiri Reguler', 'Prestasi Akademik / Non-Akademik', 'Beasiswa KIP-K', 'Kemitraan'];
        $gelombangList = ['Gelombang 1', 'Gelombang 2', 'Gelombang 3', 'Gelombang Khusus'];
        $kelulusanList = ['Diterima', 'Cadangan', 'Proses Seleksi', 'Tidak Lulus'];
        $registrasiList = ['Belum Registrasi', 'Registrasi Ulang', 'Batal / Mengundurkan Diri'];

        return view('pages.mahasiswa-baru.edit', compact('maba', 'programStudi', 'tahunAkademik', 'jalurList', 'gelombangList', 'kelulusanList', 'registrasiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MahasiswaBaruRequest $request, string $id)
    {
        $maba = MahasiswaBaru::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($maba->foto && Storage::disk('public')->exists($maba->foto)) {
                Storage::disk('public')->delete($maba->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa-baru', 'public');
        }

        $maba->update($data);

        Alert::success('Berhasil', 'Data mahasiswa baru berhasil diperbarui.');

        return redirect()->route('mahasiswa-baru.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maba = MahasiswaBaru::findOrFail($id);

        if ($maba->foto && Storage::disk('public')->exists($maba->foto)) {
            Storage::disk('public')->delete($maba->foto);
        }

        $maba->delete();

        Alert::success('Berhasil', 'Data mahasiswa baru berhasil dihapus.');

        return redirect()->route('mahasiswa-baru.index');
    }
}
