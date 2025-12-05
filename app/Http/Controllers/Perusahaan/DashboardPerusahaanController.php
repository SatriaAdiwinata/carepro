<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan; 
use App\Models\Lowongan;   
use App\Models\Lamaran;    
use Carbon\Carbon;         

class DashboardPerusahaanController extends Controller
{
    /**
     * Mengambil data statistik dan menampilkannya di dashboard.
     */
    public function index()
    {
        // 1. Dapatkan ID Perusahaan yang sedang login
        $perusahaan = Perusahaan::where('pengguna_id', Auth::id())->first();

        if (!$perusahaan) {
            // Jika profil perusahaan belum ditemukan
            return redirect('/')->with('error', 'Profil perusahaan tidak ditemukan.');
        }

        // ✅ TAMBAHKAN BARIS INI: Mengambil nama perusahaan
        $namaPerusahaan = $perusahaan->nama; 
        $perusahaanId = $perusahaan->id; 

        // 2. LOGIKA PENGAMBILAN DATA UNTUK CARD-CARD
        
        $lowonganAktif = Lowongan::where('perusahaan_id', $perusahaanId)
                                 ->where('status', 'Aktif')
                                 ->count();

        $totalPelamar = Lamaran::whereHas('lowongan', function ($query) use ($perusahaanId) {
                                    $query->where('perusahaan_id', $perusahaanId);
                                })
                                ->count();

        // --- PERBAIKAN CARD 3: MENUNGGU REVIEW ---
        $menungguReview = Lamaran::whereHas('lowongan', function ($query) use ($perusahaanId) {
                                    $query->where('perusahaan_id', $perusahaanId);
                                })
                                ->where('status', 'menunggu') // <--- DIUBAH DARI 'Menunggu Review'
                                ->count();

        // --- PERBAIKAN CARD 4: DITERIMA BULAN INI ---
        $diterimaBulanIni = Lamaran::whereHas('lowongan', function ($query) use ($perusahaanId) {
                                        $query->where('perusahaan_id', $perusahaanId);
                                    })
                                    ->where('status', 'diterima') // <--- DIUBAH DARI 'Diterima'
                                    ->whereMonth('updated_at', Carbon::now()->month) 
                                    ->whereYear('updated_at', Carbon::now()->year)
                                    ->count();


        // 3. LOGIKA UNTUK TABEL LOWONGAN TERBARU
        $lowonganTerbaruData = Lowongan::withCount('lamarans') 
                                 ->where('perusahaan_id', $perusahaanId)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();
        
        $lowonganTerbaru = $lowonganTerbaruData->map(function ($lowongan) {
            return [
                'posisi' => $lowongan->posisi,
                'tipe' => $lowongan->tipe_pekerjaan, 
                'lokasi' => $lowongan->lokasi,
                'pelamar' => $lowongan->lamarans_count, 
                'status' => $lowongan->status,
            ];
        });


        // 4. MENGIRIM SEMUA DATA KE VIEW DENGAN PENAMBAHAN $namaPerusahaan
        return view('perusahaan.dashboard', [
            'lowonganAktif' => $lowonganAktif,
            'totalPelamar' => $totalPelamar,
            'menungguReview' => $menungguReview,
            'diterimaBulanIni' => $diterimaBulanIni, 
            'lowonganTerbaru' => $lowonganTerbaru,
            'namaPerusahaan' => $namaPerusahaan, // Tambahkan ini
        ]);
    }
}