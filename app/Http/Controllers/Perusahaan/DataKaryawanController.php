<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Karyawan; 

class DataKaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan untuk perusahaan yang sedang login.
     * Route: perusahaan.data-karyawan
     */
    public function index(Request $request)
    {
        // 1. Dapatkan data Perusahaan dari pengguna yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data profil perusahaan tidak ditemukan.');
        }

        $namaPerusahaan = $perusahaan->nama; 
        $perusahaanId = $perusahaan->id;

        // 2. Query Data Karyawan
        $query = Karyawan::where('perusahaan_id', $perusahaanId)
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

        // 4. Kirim data ke View
        return view('perusahaan.data-karyawan', compact('karyawans', 'namaPerusahaan'));
    }


    public function destroy($id)
    {
        // 1. Dapatkan data Perusahaan dari pengguna yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data profil perusahaan tidak ditemukan.');
        }

        // 2. Cari karyawan berdasarkan ID dan pastikan ia milik perusahaan yang sedang login
        $karyawan = Karyawan::where('perusahaan_id', $perusahaan->id)
                            ->where('id', $id)
                            ->first();

        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan atau Anda tidak memiliki akses untuk menghapusnya.');
        }

        $namaKaryawan = $karyawan->nama_karyawan;

        try {
            // 3. Lakukan penghapusan
            $karyawan->delete();

            // 4. Redirect dengan pesan sukses
            return redirect()->route('perusahaan.data-karyawan')
                             ->with('success', 'Data karyawan **' . $namaKaryawan . '** berhasil dihapus.');

        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            return redirect()->back()->with('error', 'Gagal menghapus data karyawan: ' . $e->getMessage());
        }
    }
}