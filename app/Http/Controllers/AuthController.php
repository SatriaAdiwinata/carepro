<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // BARIS INI DITAMBAHKAN UNTUK MEMPERBAIKI UNDEFINED TYPE 'Log'

class AuthController extends Controller
{
    /**
     * Menampilkan formulir registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Menangani proses registrasi pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // 1. Validasi Data yang Masuk
        $rules = [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            // Perbaikan: Ubah 'size:8' menjadi 'min:8' agar lebih fleksibel dan sesuai standar
            'password' => 'required|string|min:8|confirmed', 
            'user_type' => 'required|in:pelamar,perusahaan',
            'terms' => 'required|accepted',
        ];

        // **PERBAIKAN KRITIS 1: Tambahkan Validasi Bersyarat untuk Nama Perusahaan**
        if ($request->user_type === 'perusahaan') {
            $rules['company_name'] = 'required|string|max:150'; // Pastikan sesuai dengan ukuran kolom DB
        }

        $request->validate($rules, [
            'terms.required' => 'Anda harus menyetujui Ketentuan Layanan dan Kebijakan Privasi.',
            'terms.accepted' => 'Anda harus menyetujui Ketentuan Layanan dan Kebijakan Privasi.',
            'password.size' => 'Password harus minimal 8 karakter.', // Sesuaikan pesan jika pakai min:8
            'company_name.required' => 'Bidang Nama Perusahaan wajib diisi.'
        ]);


        // **PERBAIKAN KRITIS 2: Gunakan Transaksi Database**
        DB::beginTransaction();

        try {
            // 2. Buat pengguna baru di tabel 'pengguna'
            $pengguna = Pengguna::create([
                'nama' => $request->first_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran' => $request->user_type,
            ]);

            // 3. Buat entri di tabel 'pelamar' atau 'perusahaan'
            if ($request->user_type === 'pelamar') {
                Pelamar::create([
                    'pengguna_id' => $pengguna->id, // Menggunakan ID pengguna yang baru dibuat
                ]);
            } elseif ($request->user_type === 'perusahaan') {
                Perusahaan::create([
                    'pengguna_id' => $pengguna->id, // KRITIS: Menyediakan pengguna_id
                    'nama_perusahaan' => $request->company_name, // KRITIS: Menggunakan input baru dari form
                ]);
            }

            // 4. Commit Transaksi
            DB::commit();

            // Opsional: Langsung login setelah registrasi (tidak wajib, tapi umum)
            // Auth::login($pengguna);

            return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
            
        } catch (\Exception $e) {
            // Jika ada yang gagal, batalkan semua perubahan
            DB::rollBack();

            // Log error untuk debugging (Sekarang \Log bisa dihilangkan karena sudah di-use)
            Log::error("Registration failed: " . $e->getMessage());

            // Kembalikan ke form dengan pesan error umum
            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Menampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validasi kredensial yang masuk
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba untuk melakukan autentikasi pengguna
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Logika Redireksi Setelah Login Berdasarkan Peran
            $peran = Auth::user()->peran;
            
            if ($peran === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($peran === 'perusahaan') {
                return redirect()->intended(route('perusahaan.dashboard'));
            } else { // Default ke pelamar
                return redirect()->intended(route('pengguna.dashboard'));
            }
        }

        // Jika autentikasi gagal, lemparkan pengecualian validasi
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    /**
     * Menangani proses logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Arahkan ke halaman login
        return redirect()->route('home');
    }
}
