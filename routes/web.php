<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\MahasiswaBaruController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TahunAkademikController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login');
    Route::post('/login', 'loginproses')->name('login.proses');
    Route::get('/loginproses', 'loginproses');
    Route::post('/loginproses', 'loginproses')->name('loginproses');

    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerproses')->name('register.proses');
    Route::get('/registerproses', 'registerproses');
    Route::post('/registerproses', 'registerproses')->name('registerproses');

    Route::post('/logout', 'logout')->name('logout');
    Route::get('/logout', 'logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pendataan
    Route::resource('mahasiswa-baru', MahasiswaBaruController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('orang-tua', OrangTuaController::class);

    // Master Data
    Route::put('/pengguna/{pengguna}/password', [PenggunaController::class, 'updatePassword'])->name('pengguna.password.update');
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('fakultas', FakultasController::class);
    Route::resource('program-studi', ProgramStudiController::class);
    Route::resource('tahun-akademik', TahunAkademikController::class);
    Route::resource('semester', SemesterController::class);
});

