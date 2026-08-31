<?php

namespace App\Http\Controllers;

use App\DataTables\InstrumenAsesmenDataTable;
use App\Http\Requests\InstrumenAsesmenRequest;
use App\Models\InstrumenAsesmen;
use RealRashid\SweetAlert\Facades\Alert;

class InstrumenAsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InstrumenAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.instrumen-asesmen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriList = ['Soft Skill', 'Leadership', 'Digital Skill', 'Bahasa Asing', 'Hard Skill / Teknis', 'Kompetensi Dasar'];

        return view('pages.instrumen-asesmen.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstrumenAsesmenRequest $request)
    {
        InstrumenAsesmen::create($request->validated());

        Alert::success('Berhasil', 'Instrumen asesmen berhasil ditambahkan.');

        return redirect()->route('instrumen-asesmen.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instrumen = InstrumenAsesmen::findOrFail($id);
        $kategoriList = ['Soft Skill', 'Leadership', 'Digital Skill', 'Bahasa Asing', 'Hard Skill / Teknis', 'Kompetensi Dasar'];

        return view('pages.instrumen-asesmen.edit', compact('instrumen', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstrumenAsesmenRequest $request, string $id)
    {
        $instrumen = InstrumenAsesmen::findOrFail($id);

        $instrumen->update($request->validated());

        Alert::success('Berhasil', 'Instrumen asesmen berhasil diperbarui.');

        return redirect()->route('instrumen-asesmen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instrumen = InstrumenAsesmen::findOrFail($id);

        $instrumen->delete();

        Alert::success('Berhasil', 'Instrumen asesmen berhasil dihapus.');

        return redirect()->route('instrumen-asesmen.index');
    }
}
