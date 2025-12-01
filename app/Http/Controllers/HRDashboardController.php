<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use App\Models\Perusahaan; 
// Hapus 'use App\Models\Lowongan;' karena Lowongan sudah dipindahkan
// use App\Models\Lowongan; 
// Jika Anda sudah siap dengan fitur lamaran, uncomment baris ini
// use App\Models\Lamaran; 

class HRDashboardController extends Controller
{
    /**
     * Method Helper untuk mendapatkan data perusahaan dan pengguna (HR) yang sedang login.
     * @return array
     */
    private function getPerusahaanData()
    {
        $pengguna = Auth::user();
        // Ambil data perusahaan yang terkait dengan pengguna yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', $pengguna->id)->first();
        $namaPerusahaan = $perusahaan->nama_perusahaan ?? $pengguna->nama;

        return [
            'pengguna' => $pengguna,
            'perusahaan' => $perusahaan,
            'namaPerusahaan' => $namaPerusahaan
        ];
    }
    
    public function dashboard()
    {
        $dataPerusahaan = $this->getPerusahaanData();
        $namaPerusahaan = $dataPerusahaan['namaPerusahaan'];
        
        $data = [
            'namaPerusahaan' => $namaPerusahaan,
            'lowonganAktif' => 12, // (Contoh data)
            'totalPelamar' => 248, // (Contoh data)
            'menungguReview' => 45, // (Contoh data)
            'diterimaBulanIni' => 18, // (Contoh data)
            'lowonganTerbaru' => [] 
        ];
        return view('perusahaan.dashboard', $data);
    }

    /**
     * Menampilkan halaman profil perusahaan.
     */
    public function profil()
    {
        $dataPerusahaan = $this->getPerusahaanData();
        $perusahaan = $dataPerusahaan['perusahaan'];
        $pengguna = $dataPerusahaan['pengguna'];

        if ($perusahaan) {
            $data = [
                'perusahaan' => $perusahaan, // Objek perusahaan untuk Blade
                'namaPerusahaan' => $perusahaan->nama_perusahaan,
                'bidangIndustri' => $perusahaan->industri,
                'alamatKantor' => $perusahaan->alamat,
                'nomorTelepon' => $perusahaan->telepon,
                'website' => $perusahaan->website,
                'deskripsiPerusahaan' => $perusahaan->deskripsi,
                'namaHR' => $pengguna->nama
                // Logo diakses langsung melalui $perusahaan->logo di view
            ];
        } else {
             $data = [
                'perusahaan' => null, // Tandai data belum lengkap
                'namaPerusahaan' => $pengguna->nama . ' (Lengkapi Profil)',
                'bidangIndustri' => '-',
                'alamatKantor' => '-',
                'nomorTelepon' => '-',
                'website' => '#',
                'deskripsiPerusahaan' => 'Silakan lengkapi profil perusahaan Anda.',
                'namaHR' => $pengguna->nama
            ];
        }
        
        return view('perusahaan.profil-hr', $data);
    }
    
    /**
     * Memperbarui atau membuat data profil perusahaan, termasuk logo.
     * @param Request $request
     */
    public function updateProfil(Request $request)
    {
        // 1. Validasi Data Masukan (Termasuk Logo)
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|string|max:150',
            'industri' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'nama_perusahaan.required' => 'Nama Perusahaan wajib diisi.',
            'website.url' => 'Format Website tidak valid.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    
        // 2. Ambil Data Perusahaan/Pengguna
        $dataPerusahaan = $this->getPerusahaanData();
        $perusahaan = $dataPerusahaan['perusahaan'];
        $pengguna = $dataPerusahaan['pengguna'];
    
        $dataToSave = [
            'nama_perusahaan' => $validatedData['nama_perusahaan'],
            'industri' => $validatedData['industri'] ?? null,
            'deskripsi' => $validatedData['deskripsi'] ?? null,
            'alamat' => $validatedData['alamat'] ?? null,
            'telepon' => $validatedData['telepon'] ?? null,
            'website' => $validatedData['website'] ?? null,
        ];
        
        // 3. Proses Upload Logo (Jika Ada File Baru)
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file ke direktori 'storage/app/public/logos'
            $file->storeAs('logos', $fileName, 'public'); 
            
            // Hapus logo lama jika ada
            if ($perusahaan && $perusahaan->logo) {
                 Storage::disk('public')->delete('logos/' . $perusahaan->logo);
            }
            
            $dataToSave['logo'] = $fileName;
        }
    
        // 4. Proses Update atau Create
        if ($perusahaan) {
            $perusahaan->update($dataToSave);
        } else {
            $dataToSave['pengguna_id'] = $pengguna->id;
            Perusahaan::create($dataToSave);
        }
        
        // 5. Sinkronisasi Nama Pengguna (HR)
        if ($pengguna->nama !== $validatedData['nama_perusahaan']) {
            $pengguna->nama = $validatedData['nama_perusahaan'];
            $pengguna->save();
        }
    
        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('perusahaan.profil')->with('success', 'Profil perusahaan berhasil diperbarui, termasuk logo!');
    }

    // --- HAPUS METHOD KELOLA LOWONGAN DAN STORE LOWONGAN YANG LAMA ---
    // public function kelolaLowongan() { ... }
    // public function storeLowongan(Request $request) { ... }
    // -----------------------------------------------------------------

    /**
     * Menampilkan halaman lamaran masuk. (SOLUSI SEMENTARA)
     */
    public function lamaranMasuk()
    {
        $dataPerusahaan = $this->getPerusahaanData();
        $namaPerusahaan = $dataPerusahaan['namaPerusahaan'];
        
        // Dibuat Collection kosong agar view tidak error (tanpa model Lamaran)
        $lamaranMasuk = collect([]); 
        $daftarLowongan = collect([]); 

        return view('perusahaan.lamaran-masuk', compact('lamaranMasuk', 'namaPerusahaan', 'daftarLowongan'));
    }

    /**
     * Menampilkan halaman pengaturan. (SOLUSI SEMENTARA)
     */
    public function pengaturan()
    {
        $dataPerusahaan = $this->getPerusahaanData();
        $namaPerusahaan = $dataPerusahaan['namaPerusahaan'];
        $pengaturanData = []; 
        
        return view('perusahaan.pengaturan', compact('namaPerusahaan', 'pengaturanData'));
    }
    
    /**
     * Menampilkan halaman data karyawan. (SOLUSI SEMENTARA)
     */
    public function dataKaryawan()
    {
        $dataPerusahaan = $this->getPerusahaanData();
        $namaPerusahaan = $dataPerusahaan['namaPerusahaan'];
        $dataKaryawan = []; 

        return view('perusahaan.data-karyawan', compact('namaPerusahaan', 'dataKaryawan'));
    }
}