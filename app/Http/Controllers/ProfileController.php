<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna (pelamar atau perusahaan).
     * Menggunakan resources/views/profil/pelamar.blade.php
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->peran === 'pelamar') {
            // Asumsi relasi di model User/Pengguna bernama 'pelamar'
            $data = $user->pelamar; 
            return view('profil.pelamar', compact('user', 'data'));
        } elseif ($user->peran === 'perusahaan') {
            // Asumsi relasi di model User/Pengguna bernama 'perusahaan'
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
        $user = $request->user();
        
        if ($user->peran !== 'pelamar') {
            return redirect()->route('profil.show')->with('error', 'Anda tidak diizinkan mengakses halaman ini.');
        }

        // Ambil data pelamar terkait
        // Catatan: Jika relasi 'pelamar' bisa null, pastikan model Pelamar juga dibuatkan
        // Atau buat instance baru jika belum ada (sesuaikan dengan implementasi Anda)
        $data = $user->pelamar; 

        return view('profil.edit', compact('user', 'data'));
    }

    /**
     * Menyimpan (Update) perubahan profil pengguna.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        // Asumsi Pelamar memiliki relasi di Model User/Pengguna
        $pelamar = $user->pelamar; 

        // 1. Validasi Data
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:50'],
            'tiktok' => ['nullable', 'string', 'max:50'], 
            'profile_photo' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg'], 
        ];

        $validatedData = $request->validate($rules);

        // 2. Update Data User (Nama)
        $user->nama = $validatedData['nama'];
        
        // 3. Handle Foto Profil (Disimpan di tabel pengguna)
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            // Simpan file ke storage/app/public/profile-photos
            $path = $file->storePublicly('profile-photos', 'public'); 

            // Hapus foto lama dari storage jika ada
            if ($user->profile_photo_path) {
                // Hati-hati: Pastikan kolom profile_photo_path sudah di-migrate!
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Update path foto baru di tabel users/pengguna
            $user->profile_photo_path = $path; 
        }
        
        $user->save();

        // 4. Update Data Pelamar (Instagram & TikTok)
        if ($pelamar) {
            $pelamar->instagram = $validatedData['instagram'] ?? null;
            $pelamar->tiktok = $validatedData['tiktok'] ?? null;
            $pelamar->save();
        }

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui!');
    }
}