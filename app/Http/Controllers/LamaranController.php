<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Lamaran; 
use App\Models\Pelamar; 
use App\Models\Lowongan; 
use Illuminate\Support\Facades\Storage; // Tambahkan untuk menangani upload file

class LamaranController extends Controller
{
    /**
     * Memproses pengiriman formulir lamaran pekerjaan.
     */
    public function submit(Request $request)
    {
        // 1. Otorisasi & Pelamar ID
        if (!Auth::check() || Auth::user()->peran !== 'pelamar') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai Pelamar.');
        }

        $pelamar = Pelamar::where('pengguna_id', Auth::id())->first();

        if (!$pelamar) {
             return redirect()->back()->with('error', 'Data profil pelamar tidak ditemukan.')->withInput();
        }
        
        // 2. Validasi Data
        $validatedData = $request->validate([
            // Validasi data berdasarkan nama kolom di form dan skema DB
            'lowongan_id' => 'required|exists:lowongan,id', 
            'nama_lengkap' => 'required|string|max:255', 
            'email' => 'required|email|max:255', 
            'nomor_telepon' => 'required|string|max:20', 
            'tanggal_lahir' => 'required|date', 
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])], 
            'alamat' => 'required|string|max:500', 
            'pendidikan_terakhir' => ['required', Rule::in(['sma', 'd3', 's1', 's2', 's3'])], 
            'jurusan' => 'required|string|max:255', 
            'universitas' => 'nullable|string|max:255', 
            'tahun_lulus' => 'required|integer|min:1950|max:' . (date('Y') + 5), 
            'ipk' => 'nullable|string|max:10', 
            'posisi_dilamar' => 'required|string|max:255', 
            'pengalaman_kerja' => 'nullable|string', 
            'surat_pengantar' => 'nullable|string', 
            
            // Validasi File
            'cv_file' => 'required|file|mimes:pdf|max:2048', // name="cv_file" di form
            'cover_letter' => 'nullable|file|mimes:pdf|max:2048', // name="cover_letter" di form
        ]);

        // 3. Proses Upload File
        
        // Upload CV ke storage/app/public/lamaran_files/cv
        $cvPath = $request->file('cv_file')->store('lamaran_files/cv', 'public');
        
        // Upload Surat Lamaran (Opsional)
        $coverLetterPath = null;
        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('lamaran_files/cover_letter', 'public');
        }

        // 4. Simpan Data ke Tabel `lamaran`
        try {
            Lamaran::create([
                'pelamar_id' => $pelamar->id,
                'lowongan_id' => $validatedData['lowongan_id'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'email' => $validatedData['email'],
                'no_telepon' => $validatedData['nomor_telepon'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'alamat' => $validatedData['alamat'],
                'jurusan' => $validatedData['jurusan'],
                'tahun_lulus' => $validatedData['tahun_lulus'],
                'posisi_dilamar' => $validatedData['posisi_dilamar'],
                
                // Simpan path file
                'file_cv' => $cvPath, 
                'file_cover_letter' => $coverLetterPath, 
                
                // Data Opsional / Lainnya
                'pendidikan_terakhir' => $validatedData['pendidikan_terakhir'],
                'pengalaman_kerja' => $validatedData['pengalaman_kerja'] ?? '', 
                'surat_pengantar' => $validatedData['surat_pengantar'] ?? null, 
                'universitas' => $validatedData['universitas'] ?? null,
                'ipk' => $validatedData['ipk'] ?? null,
                
                'status' => 'menunggu', // Status awal
            ]);

            // 5. Redirect ke Halaman Sukses
            return redirect()->route('lamaran.success')->with('success', 'Lamaran Anda telah berhasil dikirim!');
            
        } catch (\Exception $e) {
             // Jika gagal, pastikan file yang terlanjur diupload dihapus
             if ($cvPath) Storage::disk('public')->delete($cvPath);
             if ($coverLetterPath) Storage::disk('public')->delete($coverLetterPath);
             
             return redirect()->back()->withInput()->with('error', 'Gagal menyimpan lamaran. Mohon coba lagi.');
        }
    }

    /**
     * Menampilkan halaman sukses setelah pengiriman lamaran.
     */
    public function success()
    {
        return view('jobs.success'); 
    }
}