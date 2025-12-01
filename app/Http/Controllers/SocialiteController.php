<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login gagal, silakan coba lagi.');
        }

        $pengguna = Pengguna::firstOrCreate(
            [$provider . '_id' => $socialiteUser->getId()],
            [
                'nama' => $socialiteUser->getName() ?? 'Pengguna',
                'email' => $socialiteUser->getEmail(),
                'password' => Hash::make(Str::random(24)), // Password acak
                'peran' => 'pelamar', // Atur peran default, sesuaikan jika perlu
            ]
        );

        Auth::login($pengguna, true);

        return redirect('/home')->with('success', 'Berhasil login!');
    }
}