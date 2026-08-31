<?php

namespace App\Http\Controllers;

use App\DataTables\HasilAsesmenDataTable;
use App\Models\AsesmenMahasiswa;

class HasilAsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HasilAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.hasil-asesmen.index');
    }

    /**
     * Display the specified resource (Rapor Asesmen).
     */
    public function show(string $id)
    {
        $asesmen = AsesmenMahasiswa::with([
            'mahasiswa.programStudi.fakultas',
            'mahasiswa.tahunAkademik',
            'mahasiswa.kebutuhanInklusifs',
            'instrumenAsesmen',
            'jawabanAsesmens.pertanyaanAsesmen'
        ])->findOrFail($id);

        return view('pages.hasil-asesmen.show', compact('asesmen'));
    }
}
