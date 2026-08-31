<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AsesmenMahasiswa;
use App\Models\DokumenMahasiswa;
use App\Models\KebutuhanInklusif;
use App\Models\Kelulusan;
use App\Models\Mahasiswa;
use App\Models\MahasiswaBaru;
use App\Models\Perusahaan;
use App\Models\Prestasi;
use App\Models\TracerStudy;
use App\Models\User;
use App\Models\Wisuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard dengan data statistik dinamis multi-role.
     */
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role ?? 'admin');

        // Metrik Utama Mahasiswa & Inklusif
        $totalMahasiswa = Mahasiswa::count();
        $totalMaba = MahasiswaBaru::count();
        $totalMahasiswaLaki = Mahasiswa::where('jenis_kelamin', 'like', 'L%')->count();
        $totalMahasiswaPerempuan = Mahasiswa::where('jenis_kelamin', 'like', 'P%')->count();
        $totalKebutuhanInklusif = KebutuhanInklusif::count();
        $totalDokumen = DokumenMahasiswa::count();

        // Metrik Asesmen & Kompetensi
        $totalAsesmen = AsesmenMahasiswa::count();
        $avgSkorAsesmen = $totalAsesmen > 0 ? round(AsesmenMahasiswa::avg('nilai_total'), 1) : 0;
        $totalAsesmenMandiri = AsesmenMahasiswa::where(function ($q) {
            $q->where('kategori', 'like', '%sangat%')
              ->orWhere('kategori', 'like', '%tinggi%')
              ->orWhere('kategori', 'like', '%mahir%')
              ->orWhere('nilai_total', '>=', 80);
        })->count();

        // Metrik Kelulusan, Alumni, dan Prestasi
        $totalKelulusan = Kelulusan::count();
        $avgIpkKelulusan = $totalKelulusan > 0 ? round(Kelulusan::avg('ipk_kelulusan'), 2) : 0.00;
        $totalWisuda = Wisuda::count();
        $totalAlumni = Alumni::count();
        $totalPrestasi = Prestasi::count();

        // Metrik Pelacakan Karir & Mitra Perusahaan
        $totalTracer = TracerStudy::count();
        $totalPerusahaan = Perusahaan::count();
        $avgMasaTunggu = $totalTracer > 0 ? round(TracerStudy::avg('waktu_tunggu'), 1) : 0;
        $avgRelevansiKerja = $totalTracer > 0 ? round(TracerStudy::avg('relevansi_bidang'), 1) : 0;

        // Metrik Sistem & Pengguna
        $totalUsers = User::count();
        $countSuperadmin = User::where('role', 'superadmin')->count();
        $countAdmin = User::where('role', 'admin')->count();
        $countPimpinan = User::where('role', 'pimpinan')->count();

        // Sebaran Ragam Disabilitas / Kategori Inklusif (Chart 1)
        $disabilitasRaw = KebutuhanInklusif::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori')
            ->toArray();

        // Jika data sebaran kosong, sediakan kategori standar inklusi PLD
        if (empty($disabilitasRaw)) {
            $disabilitasDistribution = [
                'Sensorik Netra' => 0,
                'Sensorik Rungu' => 0,
                'Fisik / Daksa'  => 0,
                'Intelektual'    => 0,
                'Mental / Psikososial' => 0,
                'Autisme / ADHD' => 0,
            ];
        } else {
            $disabilitasDistribution = $disabilitasRaw;
        }

        // Distribusi Status Pekerjaan Alumni (Chart 2)
        $statusPekerjaanRaw = TracerStudy::selectRaw('status_pekerjaan, COUNT(*) as count')
            ->groupBy('status_pekerjaan')
            ->pluck('count', 'status_pekerjaan')
            ->toArray();

        // Aktivitas Terbaru (Asesmen & MABA)
        $recentAsesmens = AsesmenMahasiswa::with(['mahasiswa.programStudi', 'instrumenAsesmen'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $recentMabas = MahasiswaBaru::with('programStudi.fakultas')
            ->latest('created_at')
            ->take(5)
            ->get();

        $recentPerusahaans = Perusahaan::withCount('karierAlumnis')
            ->latest('created_at')
            ->take(5)
            ->get();

        $recentPrestasis = Prestasi::with('mahasiswa')
            ->latest('created_at')
            ->take(4)
            ->get();

        return view('layouts.dashboard.index', compact(
            'user',
            'role',
            'totalMahasiswa',
            'totalMaba',
            'totalMahasiswaLaki',
            'totalMahasiswaPerempuan',
            'totalKebutuhanInklusif',
            'totalDokumen',
            'totalAsesmen',
            'avgSkorAsesmen',
            'totalAsesmenMandiri',
            'totalKelulusan',
            'avgIpkKelulusan',
            'totalWisuda',
            'totalAlumni',
            'totalPrestasi',
            'totalTracer',
            'totalPerusahaan',
            'avgMasaTunggu',
            'avgRelevansiKerja',
            'totalUsers',
            'countSuperadmin',
            'countAdmin',
            'countPimpinan',
            'disabilitasDistribution',
            'statusPekerjaanRaw',
            'recentAsesmens',
            'recentMabas',
            'recentPerusahaans',
            'recentPrestasis'
        ));
    }
}
