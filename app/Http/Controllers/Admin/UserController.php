<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna; // Pastikan Model Pengguna Anda diimpor

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna KECUALI peran 'admin' dengan fungsi pencarian.
     * Route: GET /backoffice/users (admin.users.index)
     */
    public function index(Request $request)
    {
        // Ambil query pencarian dari URL
        $search = $request->query('search');

        // Mulai query dengan mengecualikan peran 'admin'
        $query = Pengguna::where('peran', '!=', 'admin'); 

        // Terapkan filter pencarian jika ada query
        if ($search) {
            $query->where(function ($q) use ($search) {
                // Cari data yang mengandung string $search di kolom 'nama' ATAU 'email'
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Dapatkan hasil dengan paginasi dan pertahankan query search di link paginasi
        $users = $query->paginate(10)->appends($request->query()); 
        
        // Mengirim variabel $users ke view
        return view('admin.users.index', compact('users')); 
    }

    /**
     * Menampilkan formulir untuk membuat pengguna baru.
     * Route: GET /backoffice/users/create (admin.users.create)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     * Route: POST /backoffice/users (admin.users.store)
     */
    public function store(Request $request)
    {
        // TODO: Implementasi logika validasi dan penyimpanan
        // Pengguna::create($request->all());
        
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail pengguna (mode Lihat Saja).
     * Route: GET /backoffice/users/{user}/edit (admin.users.edit)
     */
    public function edit(string $id)
    {
        // Mengambil data pengguna dari database berdasarkan ID
        $user = Pengguna::findOrFail($id); 
        
        // Mengirim data pengguna ($user) ke view edit.blade.php
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Method ini tetap ada untuk memenuhi Resource Controller,
     * tetapi tidak akan digunakan jika halaman edit hanya mode Lihat Saja.
     * Route: PUT/PATCH /backoffice/users/{user} (admin.users.update)
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implementasi logika pembaruan data
        
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna tertentu dari database.
     * Route: DELETE /backoffice/users/{user} (admin.users.destroy)
     */
    public function destroy(string $id)
    {
        // TODO: Implementasi logika penghapusan
        // Pengguna::destroy($id); 
        
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}