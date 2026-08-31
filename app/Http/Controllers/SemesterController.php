<?php

namespace App\Http\Controllers;

use App\DataTables\SemesterDataTable;
use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use RealRashid\SweetAlert\Facades\Alert;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SemesterDataTable $dataTable)
    {
        return $dataTable->render('pages.semester.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SemesterRequest $request)
    {
        Semester::create($request->validated());

        Alert::success('Berhasil', 'Data semester berhasil ditambahkan.');

        return redirect()->route('semester.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $semester = Semester::findOrFail($id);

        return view('pages.semester.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterRequest $request, string $id)
    {
        $semester = Semester::findOrFail($id);

        $semester->update($request->validated());

        Alert::success('Berhasil', 'Data semester berhasil diperbarui.');

        return redirect()->route('semester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $semester = Semester::findOrFail($id);

        $semester->delete();

        Alert::success('Berhasil', 'Data semester berhasil dihapus.');

        return redirect()->route('semester.index');
    }
}
