<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard
     */
    public function index()
    {
        return view('layouts.dashboard.index');
    }
}

