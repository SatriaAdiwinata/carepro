<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Menampilkan daftar semua lowongan.
     * Route: GET /backoffice/jobs (admin.jobs.index)
     */
    public function index()
    {
        return view('admin.jobs.index');
    }
    
    // ... (Metode create, store, edit, update, destroy memiliki struktur yang sama dengan UserController) ...
    // Anda bisa menyalin dan memodifikasi metode dari UserController di atas, 
    // hanya perlu mengganti 'users' menjadi 'jobs'.
    
    public function create()
    {
        return view('admin.jobs.create');
    }
    
    public function store(Request $request)
    {
        // Logika menyimpan lowongan
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dipublikasi.');
    }
    
    public function edit(string $id)
    {
        return view('admin.jobs.edit', ['jobId' => $id]);
    }

    public function update(Request $request, string $id)
    {
        // Logika update lowongan
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // Logika hapus lowongan
        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}