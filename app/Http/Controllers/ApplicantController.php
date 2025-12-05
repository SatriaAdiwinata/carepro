<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran; // Asumsi model Lamaran sudah dibuat

class ApplicantController extends Controller
{
    /**
     * Menampilkan daftar lamaran yang diajukan oleh pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil ID Pelamar yang sedang login
        // Asumsi relasi pengguna-pelamar sudah ada, dan tabel 'pelamar' memiliki 'pengguna_id'
        // Jika Anda menggunakan Model 'User' Laravel, pastikan ada relasi ke Model 'Pelamar'
        $penggunaId = Auth::id();

        // Cari Pelamar berdasarkan pengguna_id. Asumsi Model Pelamar sudah ada.
        $pelamar = \App\Models\Pelamar::where('pengguna_id', $penggunaId)->first();
        
        if (!$pelamar) {
            // Handle jika pengguna bukan pelamar (meskipun sudah di-middleware) atau data pelamar belum ada.
            return view('pengguna.lamaran_saya', ['lamarans' => collect([]), 'total' => 0]);
        }

        // 2. Ambil semua data Lamaran berdasarkan pelamar_id
        // Model Lamaran harus memiliki relasi dengan Model Lowongan (untuk detail posisi & perusahaan)
        $lamarans = Lamaran::where('pelamar_id', $pelamar->id)
                           // Load relasi ke Lowongan dan Perusahaan (jika ada relasi Lowongan -> Perusahaan)
                           ->with('lowongan.perusahaan') 
                           ->orderBy('created_at', 'desc')
                           ->get();

        $totalLamaran = $lamarans->count();

        // 3. Kirim data ke View
        return view('pengguna.lamaran_saya', [
            'lamarans' => $lamarans,
            'total' => $totalLamaran,
        ]);
    }
}