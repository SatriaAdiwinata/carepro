<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\Pengguna;

class LowonganController extends Controller
{
    // Daftar tipe pekerjaan yang digunakan untuk dropdown
    private $tipePekerjaan = ['Full Time', 'Part Time', 'Kontrak', 'Freelance', 'Remote'];
    
    // DELIMITER BARU untuk memisahkan Kualifikasi Wajib dan Tambahan
    private const KUALIFIKASI_DELIMITER = "=== TAMBAHAN ==="; 

    /**
     * Method Helper untuk mendapatkan data perusahaan dan nama perusahaan.
     * @return array
     */
    private function getPerusahaanData()
    {
        $pengguna = Auth::user();
        $perusahaan = Perusahaan::where('pengguna_id', $pengguna->id)->first();
        $namaPerusahaan = $perusahaan->nama_perusahaan ?? $pengguna->nama ?? 'HR Perusahaan';

        return [
            'pengguna' => $pengguna,
            'perusahaan' => $perusahaan,
            'namaPerusahaan' => $namaPerusahaan
        ];
    }


    /**
     * Tampilkan daftar lowongan milik perusahaan yang sedang login.
     */
    public function index(Request $request)
    {
        $perusahaanData = $this->getPerusahaanData();
        $perusahaan = $perusahaanData['perusahaan'];
        $namaPerusahaan = $perusahaanData['namaPerusahaan']; 

        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Anda belum memiliki profil perusahaan.');
        }

        $query = Lowongan::where('perusahaan_id', $perusahaan->id)->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('posisi', 'like', '%' . $request->search . '%');
        }

        $lowongans = $query->paginate(10);
        
        return view('perusahaan.lowongan.index', compact('lowongans', 'namaPerusahaan'));
    }

    /**
     * Tampilkan formulir untuk membuat lowongan baru.
     */
    public function create()
    {
        $perusahaanData = $this->getPerusahaanData();
        $namaPerusahaan = $perusahaanData['namaPerusahaan'];
        
        $tipePekerjaan = $this->tipePekerjaan;
        
        return view('perusahaan.lowongan.create', compact('tipePekerjaan', 'namaPerusahaan'));
    }

    /**
     * Simpan lowongan baru ke database.
     */
    public function store(Request $request)
    {
        $perusahaanData = $this->getPerusahaanData();
        $perusahaan = $perusahaanData['perusahaan'];

        if (!$perusahaan) {
            throw ValidationException::withMessages(['perusahaan' => 'Data perusahaan tidak ditemukan.']);
        }

        $validatedData = $request->validate([
            'posisi' => 'required|string|max:150',
            // Status di store() sudah benar: Non-Aktif
            'status' => 'required|in:Aktif,Non-Aktif,Ditutup', 
            'tipe_pekerjaan' => 'required|in:' . implode(',', $this->tipePekerjaan),
            'lokasi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kualifikasi_wajib' => 'required|string', 
            'kualifikasi_tambahan' => 'nullable|string',        
            'skill_dibutuhkan' => 'required|string',        
            'gaji_min' => 'nullable|integer|min:0',
            'gaji_max' => 'nullable|integer|min:0|gte:gaji_min',
            'batas_lamaran' => 'nullable|date|after_or_equal:today',
        ]);
        
        // PENGGABUNGAN DATA (Kualifikasi Wajib + Delimiter + Kualifikasi Tambahan)
        $kualifikasiPersyaratanGabungan = trim($validatedData['kualifikasi_wajib']);
        
        if (!empty($validatedData['kualifikasi_tambahan'])) {
             // Pastikan kualifikasi wajib diakhiri dengan baris baru, lalu tambahkan delimiter
            $kualifikasiPersyaratanGabungan .= "\n" . self::KUALIFIKASI_DELIMITER . "\n" . trim($validatedData['kualifikasi_tambahan']);
        }
        
        // PEMETAAN DATA KE KOLOM DATABASE
        $dataToSave = [
            'perusahaan_id' => $perusahaan->id,
            'posisi' => $validatedData['posisi'],
            'status' => $validatedData['status'],
            'tipe_pekerjaan' => $validatedData['tipe_pekerjaan'],
            'lokasi' => $validatedData['lokasi'],
            'deskripsi' => $validatedData['deskripsi'],
            'tanggung_jawab' => $kualifikasiPersyaratanGabungan, 
            'kualifikasi' => $validatedData['skill_dibutuhkan'],             
            'gaji_min' => $validatedData['gaji_min'],
            'gaji_max' => $validatedData['gaji_max'],
            'batas_lamaran' => $validatedData['batas_lamaran'],
        ];

        $lowongan = Lowongan::create($dataToSave);
        
        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan **' . $validatedData['posisi'] . '** berhasil ditambahkan!');
    }


    /**
     * Tampilkan formulir untuk mengedit lowongan tertentu.
     */
    public function edit(Lowongan $lowongan)
    {
        // 🚨 PERBAIKAN UTAMA: Tambahkan baris ini untuk mengambil dan mendefinisikan $namaPerusahaan
        $perusahaanData = $this->getPerusahaanData();
        $namaPerusahaan = $perusahaanData['namaPerusahaan'];
        
        // Otorisasi
        if ($lowongan->perusahaan->pengguna_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // PEMISAHAN DATA KUALIFIKASI UNTUK EDIT
        $kualifikasiWajib = $lowongan->tanggung_jawab;
        $kualifikasiTambahan = '';

        // Cek apakah data mengandung delimiter
        if (strpos($lowongan->tanggung_jawab, self::KUALIFIKASI_DELIMITER) !== false) {
            list($wajib, $tambahan) = explode(self::KUALIFIKASI_DELIMITER, $lowongan->tanggung_jawab, 2);
            $kualifikasiWajib = trim($wajib);
            $kualifikasiTambahan = trim($tambahan);
        }
        
        $skillDibutuhkan = $lowongan->kualifikasi;

        $tipePekerjaan = $this->tipePekerjaan;
        
        // Kirim hasil pemisahan ke view (Pastikan $namaPerusahaan ada di compact)
        return view('perusahaan.lowongan.edit', compact('lowongan', 'tipePekerjaan', 'kualifikasiWajib', 'kualifikasiTambahan', 'skillDibutuhkan', 'namaPerusahaan'));
    }

    /**
     * Perbarui lowongan tertentu di database.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        // Otorisasi: Pastikan lowongan ini milik perusahaan yang sedang login
        if ($lowongan->perusahaan->pengguna_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
        $validatedData = $request->validate([
            'posisi' => 'required|string|max:150',
            // 🚨 PERBAIKAN SEKUNDER: Ganti 'Nonaktif' menjadi 'Non-Aktif'
            'status' => 'required|in:Aktif,Non-Aktif,Ditutup', 
            'tipe_pekerjaan' => 'required|in:' . implode(',', $this->tipePekerjaan),
            'lokasi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kualifikasi_wajib' => 'required|string', 
            'kualifikasi_tambahan' => 'nullable|string',        
            'skill_dibutuhkan' => 'required|string',        
            'gaji_min' => 'nullable|integer|min:0',
            'gaji_max' => 'nullable|integer|min:0|gte:gaji_min',
            'batas_lamaran' => 'nullable|date|after_or_equal:today',
        ]);

        // PENGGABUNGAN DATA (Kualifikasi Wajib + Delimiter + Kualifikasi Tambahan)
        $kualifikasiPersyaratanGabungan = trim($validatedData['kualifikasi_wajib']);
        
        if (!empty($validatedData['kualifikasi_tambahan'])) {
            $kualifikasiPersyaratanGabungan .= "\n" . self::KUALIFIKASI_DELIMITER . "\n" . trim($validatedData['kualifikasi_tambahan']);
        }

        // PEMETAAN DATA KE KOLOM DATABASE
        $dataToSave = [
            'posisi' => $validatedData['posisi'],
            'status' => $validatedData['status'],
            'tipe_pekerjaan' => $validatedData['tipe_pekerjaan'],
            'lokasi' => $validatedData['lokasi'],
            'deskripsi' => $validatedData['deskripsi'],
            'tanggung_jawab' => $kualifikasiPersyaratanGabungan, 
            'kualifikasi' => $validatedData['skill_dibutuhkan'],             
            'gaji_min' => $validatedData['gaji_min'],
            'gaji_max' => $validatedData['gaji_max'],
            'batas_lamaran' => $validatedData['batas_lamaran'],
        ];
        
        $lowongan->update($dataToSave); 

        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan **' . $validatedData['posisi'] . '** berhasil diperbarui!');
    }

    /**
     * Hapus lowongan tertentu dari database.
     */
    public function destroy(Lowongan $lowongan)
    {
        // Otorisasi
        if ($lowongan->perusahaan->pengguna_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $lowongan->delete();
        return redirect()->route('perusahaan.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}