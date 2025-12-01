<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman index laporan.
     * Route: GET /backoffice/reports (admin.reports)
     */
    public function index()
    {
        return view('admin.reports'); // <-- Menampilkan resources/views/admin/reports.blade.php
    }
    
    // Di sini Anda dapat menambahkan metode seperti generateJobReport() atau downloadUserExcel().
}