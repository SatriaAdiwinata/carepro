<?php

namespace App\Http\Controllers;

use App\Models\Berita; 
use App\Models\Lowongan; // IMPORT MODEL LOWONGAN BARU
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Database\Eloquent\Builder; // Diperlukan untuk query pencarian relasi

class PublicController extends Controller
{
    /**
     * Helper untuk mengambil data lowongan aktif
     * Digunakan oleh beberapa halaman publik.
     * @param Request $request
     * @param int $limit Opsional, untuk membatasi jumlah data (misal di Home/Dashboard). Default null (ambil semua).
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getLatestLowongan(Request $request, $limit = null)
    {
        $search = $request->input('search');
        
        // Eager load relasi 'perusahaan' agar nama perusahaan bisa ditampilkan
        $query = Lowongan::with('perusahaan')
            ->where('status', 'Aktif')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                // Mencari di kolom lowongan
                $q->where('posisi', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('tipe_pekerjaan', 'like', '%' . $search . '%');
            })
            // Mencari berdasarkan nama perusahaan (melalui relasi)
            ->orWhereHas('perusahaan', function (Builder $q) use ($search) {
                $q->where('nama_perusahaan', 'like', '%' . $search . '%');
            });
        }
        
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Menampilkan halaman Beranda (Home)
     * Mengambil 3 berita dan 6 lowongan terbaru.
     * * Rute yang menangani: /
     */
    public function home(Request $request)
    {
        $beritas = Berita::orderBy('created_at', 'desc')->take(3)->get();
        
        // Ambil 6 lowongan terbaru untuk ditampilkan di Beranda
        $lowonganTerbaru = $this->getLatestLowongan($request, 6);
        
        // Pass kedua variabel ke view 'home.blade.php'
        return view('home', compact('beritas', 'lowonganTerbaru'));
    }
    
    /**
     * Menampilkan halaman Dashboard Pengguna (Pelamar)
     * Mengambil 3 berita dan 6 lowongan terbaru/rekomendasi.
     * * Rute yang menangani: /dashboard-pengguna
     */
    public function penggunaDashboard(Request $request)
    {
        if (Auth::check() && strtolower(Auth::user()->peran) === 'pelamar') {
            
            $beritas = Berita::orderBy('created_at', 'desc')->take(3)->get();
            
            // Ambil 6 lowongan terbaru/rekomendasi untuk Dashboard Pelamar
            $lowonganTerbaru = $this->getLatestLowongan($request, 6);
            
            // Mengirimkan variabel $beritas dan $lowonganTerbaru ke view 'pengguna.blade.php'
            return view('pengguna', compact('beritas', 'lowonganTerbaru'));
        }
        
        return redirect()->route('home');
    }

    /**
     * Menampilkan semua lowongan pekerjaan (Public/Frontend Lowongan Index).
     * * Rute yang menangani: /lowongan
     */
public function lowonganIndex(Request $request)
{
    // 🔥 BARIS WAJIB 1: Mendefinisikan $daftarLowongan dengan memanggil helper 🔥
    // Variabel ini harus dibuat sebelum dipanggil di compact()
    $daftarLowongan = $this->getLatestLowongan($request);
    
    // BARIS WAJIB 2: Mendefinisikan $search (jika ini juga digunakan di compact)
    $search = $request->input('search');

    // Pada baris ini, kedua variabel sudah terdefinisi.
    return view('navbar.lowongan', compact('daftarLowongan', 'search'));
}



public function lowonganShow($id)
{
    // 1. Ambil data Lowongan berdasarkan ID, termasuk relasi 'perusahaan'
    $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
    
    // 2. Mengambil lowongan terkait (Opsional)
    $lowonganTerkait = Lowongan::with('perusahaan')
        ->where('id', '!=', $id)
        ->where('status', 'Aktif')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    // 3. Mengirimkan variabel $lowongan dan $lowonganTerkait ke view
    return view('jobs.detail-pekerjaan', compact('lowongan', 'lowonganTerkait'));
}
    
    public function newsIndex()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->paginate(9); 
        return view('news.index', compact('beritas')); 
    }

    public function newsShow($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $terkait = Berita::where('id', '!=', $berita->id)
                         ->orderBy('created_at', 'desc')
                         ->take(3)
                         ->get();
        return view('news.show', compact('berita', 'terkait'));
    }
}