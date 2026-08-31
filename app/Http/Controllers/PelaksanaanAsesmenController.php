<?php

namespace App\Http\Controllers;

use App\DataTables\PelaksanaanAsesmenDataTable;
use App\Http\Requests\AsesmenMahasiswaRequest;
use App\Models\AsesmenMahasiswa;
use App\Models\InstrumenAsesmen;
use App\Models\JawabanAsesmen;
use App\Models\Mahasiswa;
use App\Models\PertanyaanAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PelaksanaanAsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PelaksanaanAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.pelaksanaan-asesmen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $instrumen = InstrumenAsesmen::with('pertanyaanAsesmens')->where('status', 'Aktif')->orderBy('nama_instrumen', 'asc')->get();

        return view('pages.pelaksanaan-asesmen.create', compact('mahasiswa', 'instrumen'));
    }

    /**
     * Helper endpoint AJAX untuk mengambil daftar pertanyaan berdasarkan instrumen.
     */
    public function getPertanyaan(Request $request)
    {
        $instrumenId = $request->get('instrumen_id');
        $pertanyaan = PertanyaanAsesmen::where('instrumen_asesmen_id', $instrumenId)->orderBy('id', 'asc')->get();

        return response()->json($pertanyaan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsesmenMahasiswaRequest $request)
    {
        $skorArray = $request->input('skor', []);
        $jawabanArray = $request->input('jawaban', []);

        $totalSkor = count($skorArray) > 0 ? array_sum($skorArray) : 0;

        // Tentukan Kategori Otomatis berdasarkan skor
        $kategori = $this->hitungKategori($totalSkor, count($skorArray));

        DB::transaction(function () use ($request, $totalSkor, $kategori, $jawabanArray, $skorArray) {
            $asesmen = AsesmenMahasiswa::create([
                'mahasiswa_id'         => $request->mahasiswa_id,
                'instrumen_asesmen_id' => $request->instrumen_asesmen_id,
                'tanggal'              => $request->tanggal,
                'nilai_total'          => $totalSkor,
                'kategori'             => $kategori,
                'catatan_asesor'       => $request->catatan_asesor,
            ]);

            foreach ($skorArray as $pertanyaanId => $skorVal) {
                JawabanAsesmen::create([
                    'asesmen_mahasiswa_id'  => $asesmen->id,
                    'pertanyaan_asesmen_id' => $pertanyaanId,
                    'jawaban'               => $jawabanArray[$pertanyaanId] ?? null,
                    'skor'                  => (int) $skorVal,
                ]);
            }
        });

        Alert::success('Berhasil', 'Pelaksanaan asesmen kompetensi berhasil disimpan.');

        return redirect()->route('pelaksanaan-asesmen.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asesmen = AsesmenMahasiswa::with(['mahasiswa', 'instrumenAsesmen', 'jawabanAsesmens.pertanyaanAsesmen'])->findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $instrumen = InstrumenAsesmen::where('status', 'Aktif')->orderBy('nama_instrumen', 'asc')->get();
        $pertanyaan = PertanyaanAsesmen::where('instrumen_asesmen_id', $asesmen->instrumen_asesmen_id)->get();

        $jawabanMap = $asesmen->jawabanAsesmens->keyBy('pertanyaan_asesmen_id');

        return view('pages.pelaksanaan-asesmen.edit', compact('asesmen', 'mahasiswa', 'instrumen', 'pertanyaan', 'jawabanMap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsesmenMahasiswaRequest $request, string $id)
    {
        $asesmen = AsesmenMahasiswa::findOrFail($id);

        $skorArray = $request->input('skor', []);
        $jawabanArray = $request->input('jawaban', []);
        $totalSkor = count($skorArray) > 0 ? array_sum($skorArray) : 0;
        $kategori = $this->hitungKategori($totalSkor, count($skorArray));

        DB::transaction(function () use ($asesmen, $request, $totalSkor, $kategori, $jawabanArray, $skorArray) {
            $asesmen->update([
                'mahasiswa_id'         => $request->mahasiswa_id,
                'instrumen_asesmen_id' => $request->instrumen_asesmen_id,
                'tanggal'              => $request->tanggal,
                'nilai_total'          => $totalSkor,
                'kategori'             => $kategori,
                'catatan_asesor'       => $request->catatan_asesor,
            ]);

            // Hapus jawaban lama dan simpan jawaban baru
            $asesmen->jawabanAsesmens()->delete();

            foreach ($skorArray as $pertanyaanId => $skorVal) {
                JawabanAsesmen::create([
                    'asesmen_mahasiswa_id'  => $asesmen->id,
                    'pertanyaan_asesmen_id' => $pertanyaanId,
                    'jawaban'               => $jawabanArray[$pertanyaanId] ?? null,
                    'skor'                  => (int) $skorVal,
                ]);
            }
        });

        Alert::success('Berhasil', 'Data pelaksanaan asesmen berhasil diperbarui.');

        return redirect()->route('pelaksanaan-asesmen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asesmen = AsesmenMahasiswa::findOrFail($id);
        $asesmen->delete();

        Alert::success('Berhasil', 'Data asesmen mahasiswa berhasil dihapus.');

        return redirect()->route('pelaksanaan-asesmen.index');
    }

    /**
     * Helper penetapan kategori capaian kompetensi
     */
    private function hitungKategori(float $totalSkor, int $jumlahSoal): string
    {
        if ($jumlahSoal === 0) {
            return 'Belum Dinilai';
        }

        // Rata-rata atau persentase basis
        $rataRata = $totalSkor / $jumlahSoal;

        if ($rataRata >= 4.5 || $totalSkor >= 85) {
            return 'Sangat Kompeten (Mahir)';
        } elseif ($rataRata >= 3.5 || $totalSkor >= 70) {
            return 'Kompeten (Baik)';
        } elseif ($rataRata >= 2.5 || $totalSkor >= 55) {
            return 'Cukup Kompeten';
        } else {
            return 'Perlu Pendampingan Khusus';
        }
    }
}
