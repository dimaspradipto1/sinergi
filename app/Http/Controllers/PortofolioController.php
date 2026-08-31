<?php

namespace App\Http\Controllers;

use App\DataTables\PortofolioDataTable;
use App\Http\Requests\PortofolioRequest;
use App\Models\Mahasiswa;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PortofolioDataTable $dataTable)
    {
        return $dataTable->render('pages.portofolio.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $kategoriList = ['Karya Inovasi', 'Desain & Media', 'Karya Tulis / Riset', 'Teknologi & Aplikasi', 'Seni & Musik', 'Kewirausahaan', 'Pengabdian / Inklusif'];

        return view('pages.portofolio.create', compact('mahasiswa', 'kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PortofolioRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('portofolio_files', 'public');
        }

        Portofolio::create($data);

        Alert::success('Berhasil', 'Portofolio mahasiswa berhasil ditambahkan.');

        return redirect()->route('portofolio.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        $kategoriList = ['Karya Inovasi', 'Desain & Media', 'Karya Tulis / Riset', 'Teknologi & Aplikasi', 'Seni & Musik', 'Kewirausahaan', 'Pengabdian / Inklusif'];

        return view('pages.portofolio.edit', compact('portofolio', 'mahasiswa', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PortofolioRequest $request, string $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($portofolio->file && Storage::disk('public')->exists($portofolio->file)) {
                Storage::disk('public')->delete($portofolio->file);
            }
            $data['file'] = $request->file('file')->store('portofolio_files', 'public');
        }

        $portofolio->update($data);

        Alert::success('Berhasil', 'Portofolio mahasiswa berhasil diperbarui.');

        return redirect()->route('portofolio.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portofolio = Portofolio::findOrFail($id);

        if ($portofolio->file && Storage::disk('public')->exists($portofolio->file)) {
            Storage::disk('public')->delete($portofolio->file);
        }

        $portofolio->delete();

        Alert::success('Berhasil', 'Portofolio mahasiswa berhasil dihapus.');

        return redirect()->route('portofolio.index');
    }
}
