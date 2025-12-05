@extends('layouts.app')

@section('title', $user->nama . ' - Profil Pelamar')

{{-- Bagian Content Utama --}}
@section('content')

    {{-- 
        PENYESUAIAN PENTING:
        1. pt-24 (Padding Top 6rem/96px): Mengompensasi tinggi fixed header.
        2. mb-12 (Margin Bottom 3rem/48px): MENAMBAH JARAK DARI FOOTER.
    --}}
    <div class="max-w-6xl mx-auto animate-fade-in-up pt-24 px-4 sm:px-6 lg:px-8 mb-12">
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded-xl shadow-md mb-8" role="alert">
                <p class="font-bold">Sukses!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="profile-header bg-white rounded-3xl p-6 md:p-12 text-center shadow-xl border border-gray-100 mb-8 transition-all duration-300 relative">
            
            {{-- Tombol Edit --}}
            <a href="{{ route('profil.edit') }}" class="absolute top-4 right-4 text-purple-600 hover:text-purple-800 transition duration-150">
                <i class="fas fa-edit fa-lg"></i>
            </a>

            <div class="photo-container relative inline-block mb-8">
                <div 
                    id="profile-photo" 
                    class="w-36 h-36 rounded-full mx-auto flex items-center justify-center text-6xl text-white shadow-xl bg-gradient-to-br from-fuchsia-400 to-purple-500"
                    style="
                        @if ($user->profile_photo_path)
                            background-image: url('{{ Storage::url($user->profile_photo_path) }}');
                            background-size: cover;
                            background-position: center;
                        @endif
                    "
                >
                    @if (!$user->profile_photo_path)
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    @endif
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">{{ $user->nama }}</h1>
            <p class="text-lg text-purple-600 font-medium mb-6">{{ $user->email }}</p>

            <div class="social-links flex justify-center gap-4 mb-8 text-xl text-gray-500">
                @if ($data->instagram)
                    <a href="https://instagram.com/{{ $data->instagram }}" target="_blank" class="hover:text-purple-600 transition"><i class="fab fa-instagram"></i></a>
                @endif
                @if ($data->tiktok)
                    <a href="https://tiktok.com/@{{ $data->tiktok }}" target="_blank" class="hover:text-purple-600 transition"><i class="fab fa-tiktok"></i></a>
                @endif
            </div>

            
        </div>

        {{-- Detail Profil --}}
        {{-- Diubah menjadi md:grid-cols-2 untuk layar medium, di mobile tetap 1 kolom --}}
        <div class="profile-details grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Kolom Data Kontak --}}
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                <h3 class="text-xl font-bold text-slate-800 mb-4 border-b pb-2"><i class="fas fa-user-circle me-2 text-purple-600"></i> Data Kontak</h3>
                <div class="space-y-3 text-sm text-slate-600">
                    <p><strong>Telepon:</strong> {{ $data->no_hp ?? '-' }}</p> 
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Alamat:</strong> {{ $data->alamat ?? '-' }}</p>
                </div>
            </div>

            {{-- Kolom Media Sosial --}}
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                <h3 class="text-xl font-bold text-slate-800 mb-4 border-b pb-2"><i class="fas fa-hashtag me-2 text-purple-600"></i> Media Sosial</h3>
                
                <div class="space-y-3 text-sm text-slate-600">
                    <p><strong>Instagram:</strong> {{ $data->instagram ? '@' . $data->instagram : '-' }}</p>
                    <p><strong>TikTok:</strong> {{ $data->tiktok ? '@' . $data->tiktok : '-' }}</p>
                </div>
            </div>
            
        </div>

    </div>

@endsection