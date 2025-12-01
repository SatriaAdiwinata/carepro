@extends('layouts.app')
@section('title', 'Lamaran Saya')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Lamaran Saya</h1>
        
        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <p class="text-lg font-semibold text-purple-600">Total Lamaran: <span class="text-gray-800">2</span></p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition-colors">
                    Lihat Lowongan Lain
                </button>
            </div>

            <ul class="space-y-4">
                <li class="p-4 border border-gray-200 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-xl text-gray-900">Frontend Developer</p>
                            <p class="text-sm text-gray-500 mb-2">PT Sinergi Teknologi Indonesia</p>
                            <p class="text-xs text-gray-400">Tanggal Melamar: 15 Oktober 2024</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                                Ditinjau
                            </span>
                            <a href="#" class="block mt-2 text-purple-600 hover:text-purple-800 text-sm font-semibold">Lihat Detail</a>
                        </div>
                    </div>
                </li>

                <li class="p-4 border border-gray-200 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-xl text-gray-900">Staff Administrasi</p>
                            <p class="text-sm text-gray-500 mb-2">CV Maju Bersama</p>
                            <p class="text-xs text-gray-400">Tanggal Melamar: 10 September 2024</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                Wawancara
                            </span>
                            <a href="#" class="block mt-2 text-purple-600 hover:text-purple-800 text-sm font-semibold">Lihat Jadwal</a>
                        </div>
                    </div>
                </li>

                </ul>
        </div>
    </div>
</div>
@endsection