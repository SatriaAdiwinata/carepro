<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import untuk validasi
use App\Models\Pengguna; // <-- IMPOR MODEL ANDA DI SINI. GANTI 'Pengguna' jika nama Model Anda 'User'

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna (pelamar atau perusahaan).
     * Menggunakan resources/views/profil/pelamar.blade.php atau perusahaan.blade.php
     */
    public function show()
    {
        /** @var Pengguna $user */ // <-- PHPDoc untuk mengidentifikasi $user sebagai Model Pengguna
        $user = Auth::user();

        if ($user->peran === 'pelamar') {
            // Asumsi relasi di model User/Pengguna bernama 'pelamar'
            $user->load('pelamar'); // <-- Error 'Undefined method load' hilang
            $data = $user->pelamar; 
            // View 'pelamar' telah disesuaikan agar hanya menampilkan field yang ada di DB.
            return view('profil.pelamar', compact('user', 'data'));
        } elseif ($user->peran === 'perusahaan') {
            // Asumsi relasi di model User/Pengguna bernama 'perusahaan'
            $user->load('perusahaan'); // <-- Error 'Undefined method load' hilang
            $data = $user->perusahaan; 
            return view('profil.perusahaan', compact('user', 'data'));
        }
        
        return redirect()->back()->with('error', 'Halaman profil tidak tersedia.');
    }

    /**
     * Menampilkan formulir untuk mengedit profil pengguna (pelamar).
     * Menggunakan resources/views/profil/edit.blade.php
     */
    public function edit(Request $request)
    {
        /** @var Pengguna $user */ // <-- PHPDoc ditambahkan
        $user = $request->user();
        
        if ($user->peran !== 'pelamar') {
            return redirect()->route('profil.show')->with('error', 'Anda tidak diizinkan mengedit profil ini.');
        }

        // Load relasi pelamar untuk mendapatkan data tambahan
        $user->load('pelamar');
        $pelamar = $user->pelamar;

        if (!$pelamar) {
             return redirect()->route('profil.show')->with('error', 'Data pelamar tidak ditemukan.');
        }

        return view('profil.edit', compact('user', 'pelamar'));
    }

    /**
     * Memperbarui data profil pengguna (pelamar).
     */
    public function update(Request $request)
    {
        /** @var Pengguna $user */ // <-- PHPDoc ditambahkan
        $user = Auth::user();

        if ($user->peran !== 'pelamar') {
            return redirect()->route('profil.show')->with('error', 'Akses ditolak.');
        }

        $pelamar = $user->pelamar;
        if (!$pelamar) {
            return redirect()->route('profil.show')->with('error', 'Data pelamar tidak ditemukan.');
        }
        
        // --- 1. Aturan Validasi (HANYA MENGGUNAKAN KOLOM YANG ADA DI DB) ---
        $rules = [
            // Data Pengguna (pengguna)
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('pengguna')->ignore($user->id)],
            'profile_photo' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'], 

            // Data Pelamar (pelamar) - KOLOM YANG ADA DI DB
            'no_hp' => ['nullable', 'string', 'max:20'], 
            'alamat' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:50'],
            'tiktok' => ['nullable', 'string', 'max:50'], 
        ];

        $validatedData = $request->validate($rules);

        // 2. Update Data User (Nama, Email)
        $user->nama = $validatedData['nama'];
        $user->email = $validatedData['email'];
        
        // 3. Handle Foto Profil
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $path = $file->storePublicly('profile-photos', 'public'); 

            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $path; 
        }
        
        $user->save(); // <-- Error 'Undefined method save' hilang

        // 4. Update Data Pelamar (Tabel pelamar)
        $pelamar->no_hp = $validatedData['no_hp'] ?? null;
        $pelamar->alamat = $validatedData['alamat'] ?? null;
        $pelamar->instagram = $validatedData['instagram'] ?? null;
        $pelamar->tiktok = $validatedData['tiktok'] ?? null;

        $pelamar->save();

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui!');
    }
}