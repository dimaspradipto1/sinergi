<?php

namespace App\Http\Controllers;

use App\DataTables\PerusahaanDataTable;
use App\Http\Requests\PerusahaanRequest;
use App\Models\Perusahaan;
use RealRashid\SweetAlert\Facades\Alert;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PerusahaanDataTable $dataTable)
    {
        return $dataTable->render('pages.perusahaan-mitra.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangList = [
            'Teknologi Informasi & Software',
            'Pendidikan & Pelatihan',
            'Perbankan & Lembaga Keuangan',
            'BUMN & Instansi Pemerintah',
            'Industri Kreatif & Desain',
            'Kesehatan & Farmasi',
            'Manufaktur & Logistik',
            'Lembaga Non-Profit / NGO Inklusif',
        ];

        return view('pages.perusahaan-mitra.create', compact('bidangList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerusahaanRequest $request)
    {
        Perusahaan::create($request->validated());

        Alert::success('Berhasil', 'Mitra perusahaan berhasil ditambahkan.');

        return redirect()->route('perusahaan-mitra.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $bidangList = [
            'Teknologi Informasi & Software',
            'Pendidikan & Pelatihan',
            'Perbankan & Lembaga Keuangan',
            'BUMN & Instansi Pemerintah',
            'Industri Kreatif & Desain',
            'Kesehatan & Farmasi',
            'Manufaktur & Logistik',
            'Lembaga Non-Profit / NGO Inklusif',
        ];

        return view('pages.perusahaan-mitra.edit', compact('perusahaan', 'bidangList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerusahaanRequest $request, string $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->validated());

        Alert::success('Berhasil', 'Data mitra perusahaan berhasil diperbarui.');

        return redirect()->route('perusahaan-mitra.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        Alert::success('Berhasil', 'Data mitra perusahaan berhasil dihapus.');

        return redirect()->route('perusahaan-mitra.index');
    }
}
