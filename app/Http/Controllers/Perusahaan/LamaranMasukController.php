<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran;
use App\Models\Perusahaan; // Pastikan model ini diimpor
use App\Models\Lowongan; 
use App\Models\Karyawan; // <<< PASTIKAN INI ADA
use Illuminate\Support\Facades\Storage; 

class LamaranMasukController extends Controller
{
    /**
     * Menampilkan daftar lamaran yang masuk untuk lowongan perusahaan yang sedang login.
     * Route: perusahaan.lamaran_masuk.index
     */
    public function index()
    {
        // 1. Dapatkan data Perusahaan dari pengguna yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            // Tangani jika profil perusahaan tidak ditemukan
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data profil perusahaan tidak ditemukan.');
        }

        // PENTING: Ambil nama perusahaan untuk dikirim ke view
        // Diasumsikan kolom nama di tabel perusahaan adalah 'nama'. Sesuaikan jika berbeda (misal: 'nama_perusahaan')
        $namaPerusahaan = $perusahaan->nama; 

        $perusahaanId = $perusahaan->id;

        // 2. Ambil data Lamaran dengan filter
        $lamarans = Lamaran::with('lowongan') 
            ->whereHas('lowongan', function ($query) use ($perusahaanId) {
                // Lowongan.perusahaan_id harus sama dengan ID perusahaan yang login
                $query->where('perusahaan_id', $perusahaanId);
            })
            ->orderBy('created_at', 'desc') 
            ->paginate(10); // Menggunakan pagination

        // 3. Kirim data ke View lamaran-masuk.blade.php
        // TAMBAHKAN 'namaPerusahaan' KE compact()
        return view('perusahaan.lamaran-masuk', compact('lamarans', 'namaPerusahaan'));
    }

    /**
     * Menampilkan detail lamaran tertentu.
     * Route: perusahaan.lamaran_masuk.show
     */
    public function show($id)
    {
        // 1. Ambil data Perusahaan dari pengguna yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->firstOrFail();

        // 2. Ambil Lamaran berdasarkan ID, beserta relasi lowongan
        $lamaran = Lamaran::with('lowongan')->findOrFail($id);

        // 3. Otorisasi: Pastikan lamaran ini milik perusahaan yang sedang login
        if ($lamaran->lowongan->perusahaan_id !== $perusahaan->id) {
             // Jika ID perusahaan tidak cocok, lemparkan 403 Forbidden
             abort(403, 'Anda tidak memiliki akses ke detail lamaran ini.');
        }

        // 4. Kirim data ke View
        $namaPerusahaan = $perusahaan->nama; 
        return view('perusahaan.lamaran-masuk-detail', compact('lamaran', 'namaPerusahaan'));
    }
    
    /**
     * Memperbarui status lamaran (Diterima/Ditolak).
     * Route: perusahaan.lamaran_masuk.update_status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        // Muat lamaran dengan lowongan untuk mendapatkan posisi dan perusahaan_id
        $lamaran = Lamaran::with('lowongan')->findOrFail($id);

        // Otorisasi: Pastikan lamaran ini milik perusahaan yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->firstOrFail();
        
        if ($lamaran->lowongan->perusahaan_id !== $perusahaan->id) {
             return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah status lamaran ini.');
        }

        // --- Logika Utama: Update Status ---
        $lamaran->status = $request->status;
        $lamaran->save();

        // --- Logika Baru: Tambah ke Karyawan jika Diterima ---
        if ($lamaran->status === 'diterima') {
            try {
                $posisiKaryawan = $lamaran->lowongan->posisi; 

                // Buat entri di tabel karyawan
                Karyawan::create([
                    'perusahaan_id' => $perusahaan->id,
                    'lamaran_id' => $lamaran->id, // Tautkan ke Lamaran
                    'nama_karyawan' => $lamaran->nama_lengkap, 
                    'posisi' => $posisiKaryawan, 
                    'tanggal_bergabung' => now()->toDateString(), // Tanggal hari ini
                    'email' => $lamaran->email, 
                    'no_telepon' => $lamaran->no_telepon,
                    
                    // Mengisi kolom detail dari tabel lamaran:
                    'tanggal_lahir' => $lamaran->tanggal_lahir, 
                    'jenis_kelamin' => $lamaran->jenis_kelamin,
                    'alamat' => $lamaran->alamat,
                    'pendidikan_terakhir' => $lamaran->pendidikan_terakhir,
                    'jurusan' => $lamaran->jurusan,
                    'universitas' => $lamaran->universitas,
                    'tahun_lulus' => $lamaran->tahun_lulus,
                    'ipk' => $lamaran->ipk,
                    'status' => 'Aktif', // Nilai default
                ]);

                // REDIRECT KE HALAMAN DATA KARYAWAN
                return redirect()->route('perusahaan.data-karyawan') 
                         ->with('success', 'Pelamar **' . $lamaran->nama_lengkap . '** telah diterima dan ditambahkan ke **Data Karyawan**.');

            } catch (\Exception $e) {
                 // Tangani error jika gagal menyimpan ke Karyawan
                 return redirect()->back()->with('error', 'Lamaran berhasil diterima, namun **Gagal menambahkan data ke Data Karyawan**: ' . $e->getMessage());
            }

        } else {
             // Jika status Ditolak
             return redirect()->route('perusahaan.lamaran_masuk.index')
                      ->with('success', 'Status lamaran pelamar berhasil diubah menjadi **' . ucfirst($lamaran->status) . '**.');
        }
    }
}