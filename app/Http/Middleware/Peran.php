<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Anda tidak perlu lagi mengimpor Response jika tidak digunakan secara langsung
// use Symfony\Component\HttpFoundation\Response; 

class Peran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $peran // Peran yang diharapkan (misal: 'perusahaan')
     * @return mixed
     */
    // Kami menghapus tipe kembalian (Response) di sini untuk mengatasi error abort()
    public function handle(Request $request, Closure $next, string $peran) 
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
        }

        $user = Auth::user();

        // 2. Cek apakah peran pengguna sesuai dengan peran yang diminta di route
        if ($user->peran == $peran) {
            return $next($request); // Lanjutkan permintaan jika peran cocok
        }

        // 3. Jika peran tidak cocok, tolak akses
        // Fungsi abort() akan menghentikan eksekusi dan menampilkan error 403
        return abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini (' . $peran . ').');
    }
}