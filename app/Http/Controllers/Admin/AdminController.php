<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Doctor; // Pastikan Anda mengimpor Model Dokter Anda

/**
 * Class AdminController
 * Controller ini menangani logika dan view untuk halaman admin yang bersifat umum 
 * atau tidak masuk dalam modul Resource Controller (Jobs, Users, Companies, dll.).
 */
class AdminController extends Controller
{
    /**
     * Menampilkan halaman manajemen Data Dokter.
     * Rute: GET /backoffice/data-dokter (admin.data_dokter)
     *
     * @return \Illuminate\View\View
     */
    public function dataDokter()
    {
        // 1. Logika Pengambilan Data
        // $doctors = Doctor::orderBy('name')->paginate(10); 
        
        // 2. Mengirimkan Data ke View
        return view('admin.data_dokter', [
            // 'doctors' => $doctors, 
        ]);
    }

    /**
     * Menyimpan data Dokter baru.
     * Rute: POST /backoffice/data-dokter
     */
    public function storeDokter(Request $request)
    {
        // Logika validasi dan penyimpanan Dokter baru ke database
        // Doctor::create($request->validated());
        
        return redirect()->route('admin.data_dokter')->with('success', 'Data Dokter berhasil ditambahkan.');
    }
    
    /**
     * Memperbarui data Dokter tertentu.
     * Rute: PUT/PATCH /backoffice/data-dokter/{id}
     */
    public function updateDokter(Request $request, string $id)
    {
        // Logika validasi dan pembaruan data Dokter
        // $doctor = Doctor::findOrFail($id);
        // $doctor->update($request->validated());

        return redirect()->route('admin.data_dokter')->with('success', 'Data Dokter berhasil diperbarui.');
    }
    
    /**
     * Menghapus data Dokter tertentu.
     * Rute: DELETE /backoffice/data-dokter/{id}
     */
    public function destroyDokter(string $id)
    {
        // Logika penghapusan data Dokter
        // Doctor::destroy($id);

        return redirect()->route('admin.data_dokter')->with('success', 'Data Dokter berhasil dihapus.');
    }
}