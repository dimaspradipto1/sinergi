<?php

namespace App\Http\Controllers;

use App\DataTables\NilaiMahasiswaDataTable;
use App\Http\Requests\NilaiMahasiswaRequest;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class NilaiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NilaiMahasiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.nilai-mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $krsList = Krs::with('mahasiswa')->orderBy('id', 'desc')->get();
        $mataKuliah = MataKuliah::orderBy('nama_matkul', 'asc')->get();

        return view('pages.nilai-mahasiswa.create', compact('krsList', 'mataKuliah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NilaiMahasiswaRequest $request)
    {
        $nilaiAngka = (float) $request->nilai_angka;
        $nilaiHuruf = $request->filled('nilai_huruf') ? strtoupper($request->nilai_huruf) : $this->konversiHuruf($nilaiAngka);

        NilaiMahasiswa::updateOrCreate(
            [
                'krs_id'         => $request->krs_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
            ],
            [
                'nilai_angka'    => $nilaiAngka,
                'nilai_huruf'    => $nilaiHuruf,
            ]
        );

        Alert::success('Berhasil', 'Nilai mahasiswa berhasil disimpan.');

        return redirect()->route('nilai-mahasiswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nilai = NilaiMahasiswa::with(['krs.mahasiswa', 'mataKuliah'])->findOrFail($id);
        $krsList = Krs::with('mahasiswa')->get();
        $mataKuliah = MataKuliah::orderBy('nama_matkul', 'asc')->get();

        return view('pages.nilai-mahasiswa.edit', compact('nilai', 'krsList', 'mataKuliah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiMahasiswaRequest $request, string $id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);

        $nilaiAngka = (float) $request->nilai_angka;
        $nilaiHuruf = $request->filled('nilai_huruf') ? strtoupper($request->nilai_huruf) : $this->konversiHuruf($nilaiAngka);

        $nilai->update([
            'krs_id'         => $request->krs_id,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'nilai_angka'    => $nilaiAngka,
            'nilai_huruf'    => $nilaiHuruf,
        ]);

        Alert::success('Berhasil', 'Nilai mahasiswa berhasil diperbarui.');

        return redirect()->route('nilai-mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $nilai->delete();

        Alert::success('Berhasil', 'Nilai mahasiswa berhasil dihapus.');

        return redirect()->route('nilai-mahasiswa.index');
    }

    /**
     * Helper konversi nilai angka ke huruf standar akademik
     */
    private function konversiHuruf(float $angka): string
    {
        if ($angka >= 85) return 'A';
        if ($angka >= 75) return 'B+';
        if ($angka >= 65) return 'B';
        if ($angka >= 55) return 'C+';
        if ($angka >= 45) return 'C';
        if ($angka >= 30) return 'D';
        return 'E';
    }
}
