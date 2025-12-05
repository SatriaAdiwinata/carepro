<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Menampilkan daftar semua perusahaan.
     * Route: GET /backoffice/companies (admin.companies.index)
     */
    public function index()
    {
        return view('admin.companies.index');
    }

    /**
     * Menampilkan detail perusahaan.
     * Route: GET /backoffice/companies/{id} (admin.companies.show)
     */
    public function show($id)
    {
        // Sementara return view dengan data dummy
        return view('admin.companies.show');
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        // Logika menyimpan data perusahaan
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        return view('admin.companies.edit', ['companyId' => $id]);
    }
    
    public function update(Request $request, string $id)
    {
        // Logika update data perusahaan
        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // Logika hapus data perusahaan
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}