<?php

namespace App\Http\Controllers;

use App\DataTables\PenggunaDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PenggunaDataTable $dataTable)
    {
        return $dataTable->render('pages.pengguna.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:superadmin,admin,pimpinan'],
        ], [
            'name.required'     => 'Nama pengguna wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role yang dipilih tidak valid.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        Alert::success('Berhasil', 'Data pengguna baru berhasil ditambahkan.');

        return redirect()->route('pengguna.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('pages.pengguna.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:superadmin,admin,pimpinan'],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'name.required'  => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan oleh pengguna lain.',
            'role.required'  => 'Role wajib dipilih.',
            'role.in'        => 'Role yang dipilih tidak valid.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);

        $userData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        // Jika password diisi, gunakan password baru. Jika kosong, tetap gunakan password lama.
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        Alert::success('Berhasil', 'Data pengguna berhasil diperbarui.');

        return redirect()->route('pengguna.index');
    }

    /**
     * Update password pengguna secara khusus.
     */
    public function updatePassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => ['required', 'string', 'min:6'],
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min'      => 'Password baru minimal 6 karakter.',
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Alert::success('Berhasil', 'Password pengguna "' . $user->name . '" berhasil diperbarui.');

        return redirect()->route('pengguna.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Mencegah user menghapus akunnya sendiri
        if (Auth::id() == $user->id) {
            Alert::error('Gagal', 'Anda tidak dapat menghapus akun sendiri saat sedang login.');
            return redirect()->route('pengguna.index');
        }

        $user->delete();

        Alert::success('Berhasil', 'Data pengguna berhasil dihapus.');

        return redirect()->route('pengguna.index');
    }
}
