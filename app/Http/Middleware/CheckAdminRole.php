<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan pertama: Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Pengecekan kedua: Pastikan peran pengguna adalah 'admin'
        // Berdasarkan skema database Anda, kolom yang digunakan adalah 'peran'.
        if ($user && $user->peran === 'admin') {
            return $next($request);
        }

        // Jika peran bukan 'admin', tolak akses dan arahkan ke rute yang sesuai
        // atau kembali dengan pesan error.
        return redirect()->route('beranda_umum')->with('error', 'Anda tidak memiliki hak akses sebagai Administrator.');
    }
}
