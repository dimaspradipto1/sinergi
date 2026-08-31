<?php

namespace App\Http\Controllers;

use App\DataTables\KrsDataTable;
use App\Http\Requests\KrsRequest;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiMahasiswa;
use App\Models\Semester;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KrsDataTable $dataTable)
    {
        return $dataTable->render('pages.krs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('tahun_akademik', 'desc')->get();
        $semesters = Semester::orderBy('semester', 'asc')->get();
        $mataKuliah = MataKuliah::orderBy('semester', 'asc')->orderBy('nama_matkul', 'asc')->get();

        return view('pages.krs.create', compact('mahasiswa', 'tahunAkademik', 'semesters', 'mataKuliah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KrsRequest $request)
    {
        DB::transaction(function () use ($request) {
            $krs = Krs::create([
                'mahasiswa_id'   => $request->mahasiswa_id,
                'tahun_akademik' => $request->tahun_akademik,
                'semester'       => $request->semester,
            ]);

            $matkulIds = $request->input('mata_kuliah_id', []);
            foreach ($matkulIds as $matkulId) {
                NilaiMahasiswa::create([
                    'krs_id'         => $krs->id,
                    'mata_kuliah_id' => $matkulId,
                    'nilai_angka'    => 0,
                    'nilai_huruf'    => 'E',
                ]);
            }
        });

        Alert::success('Berhasil', 'KRS Mahasiswa berhasil disimpan.');

        return redirect()->route('krs.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $krs = Krs::with('nilaiMahasiswas')->findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $tahunAkademik = TahunAkademik::orderBy('tahun_akademik', 'desc')->get();
        $semesters = Semester::orderBy('semester', 'asc')->get();
        $mataKuliah = MataKuliah::orderBy('semester', 'asc')->orderBy('nama_matkul', 'asc')->get();
        $selectedMatkulIds = $krs->nilaiMahasiswas->pluck('mata_kuliah_id')->toArray();

        return view('pages.krs.edit', compact('krs', 'mahasiswa', 'tahunAkademik', 'semesters', 'mataKuliah', 'selectedMatkulIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KrsRequest $request, string $id)
    {
        $krs = Krs::findOrFail($id);

        DB::transaction(function () use ($krs, $request) {
            $krs->update([
                'mahasiswa_id'   => $request->mahasiswa_id,
                'tahun_akademik' => $request->tahun_akademik,
                'semester'       => $request->semester,
            ]);

            $matkulIds = $request->input('mata_kuliah_id', []);
            $currentNilai = $krs->nilaiMahasiswas->keyBy('mata_kuliah_id');

            // Hapus yang tidak dipilih lagi
            foreach ($currentNilai as $matkulId => $nilaiItem) {
                if (!in_array($matkulId, $matkulIds)) {
                    $nilaiItem->delete();
                }
            }

            // Tambah matkul baru yang belum ada
            foreach ($matkulIds as $matkulId) {
                if (!isset($currentNilai[$matkulId])) {
                    NilaiMahasiswa::create([
                        'krs_id'         => $krs->id,
                        'mata_kuliah_id' => $matkulId,
                        'nilai_angka'    => 0,
                        'nilai_huruf'    => 'E',
                    ]);
                }
            }
        });

        Alert::success('Berhasil', 'KRS Mahasiswa berhasil diperbarui.');

        return redirect()->route('krs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $krs = Krs::findOrFail($id);
        $krs->delete();

        Alert::success('Berhasil', 'KRS Mahasiswa berhasil dihapus.');

        return redirect()->route('krs.index');
    }
}
