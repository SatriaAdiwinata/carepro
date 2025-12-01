<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin.
     * Route: GET /backoffice/dashboard (admin.dashboard)
     */
    public function index()
    {
        // Logika untuk mengambil data ringkasan (misalnya, jumlah user, lowongan aktif, dll.)
        $totalUsers = 1200; // Contoh data statis
        $totalJobs = 150;   // Contoh data statis

        return view('admin.dashboard', compact('totalUsers', 'totalJobs'));
    }
}