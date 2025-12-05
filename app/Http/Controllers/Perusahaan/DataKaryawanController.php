<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Karyawan; 
use Carbon\Carbon; // <<< WAJIB ADA UNTUK PERHITUNGAN TANGGAL
use Illuminate\Support\Facades\Storage; // <<< TAMBAH BARIS INI

class DataKaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan untuk perusahaan yang sedang login.
     * Route: perusahaan.data-karyawan
     */
    public function index(Request $request)
    {
        // 1. Dapatkan data Perusahaan
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data profil perusahaan tidak ditemukan.');
        }

        $namaPerusahaan = $perusahaan->nama; 
        $perusahaanId = $perusahaan->id;

        // 2. Query Data Karyawan dengan Filter
        $query = Karyawan::where('perusahaan_id', $perusahaanId)
                        ->with('lamaran') // <<< KODE BARU: Memuat data Lamaran (untuk akses CV)
                         ->orderBy('tanggal_bergabung', 'desc');

        // Filter Posisi
        if ($request->filled('posisi')) {
            $query->where('posisi', $request->posisi);
        }
        
        // Filter Pencarian (Search)
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_karyawan', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm);
            });
        }

        // 3. Ambil data dengan pagination
        $karyawans = $query->paginate(10);
        
        // 4. Hitung karyawan yang bergabung bulan ini ("Diterima Bulan Ini")
        $karyawanBulanIni = Karyawan::where('perusahaan_id', $perusahaanId)
                                    ->whereYear('tanggal_bergabung', Carbon::now()->year)
                                    ->whereMonth('tanggal_bergabung', Carbon::now()->month)
                                    ->count();


        // 5. Kirim data ke view
        return view('perusahaan.data-karyawan', compact('karyawans', 'karyawanBulanIni', 'namaPerusahaan'));
    }
    
    /**
     * Hapus data karyawan (DELETE).
     * Route: perusahaan.data-karyawan.destroy
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();
        if (!$perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data profil perusahaan tidak ditemukan.');
        }

        $karyawan = Karyawan::where('perusahaan_id', $perusahaan->id)
                            ->where('id', $id)
                            ->first();

        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan atau Anda tidak memiliki akses untuk menghapusnya.');
        }

        $namaKaryawan = $karyawan->nama_karyawan;
        try {
            $karyawan->delete();
            return redirect()->route('perusahaan.data-karyawan')
                             ->with('success', 'Data karyawan **' . $namaKaryawan . '** berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data karyawan: ' . $e->getMessage());
        }
    }
    
    /**
     * Mengambil detail karyawan berdasarkan ID (untuk AJAX).
     * Route: perusahaan.data-karyawan.detail
     */
    public function getDetail($id)
    {
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $karyawan = Karyawan::where('perusahaan_id', $perusahaan->id)
                            ->where('id', $id)
                            ->first();

        if (!$karyawan) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }

        // --- KODE BARU: Menghasilkan URL CV ---
        $cvUrl = null;
        if ($karyawan->lamaran && $karyawan->lamaran->file_cv) {
            // Gunakan Storage::url untuk mendapatkan URL lengkap
            $cvUrl = Storage::url($karyawan->lamaran->file_cv);
        }
        
        // Tambahkan URL CV ke objek karyawan yang akan di-JSON-kan
        $karyawan->cv_url = $cvUrl;

        // Kembalikan seluruh objek karyawan dalam format JSON
        return response()->json([
            'success' => true,
            'karyawan' => $karyawan 
        ]);
    }
}