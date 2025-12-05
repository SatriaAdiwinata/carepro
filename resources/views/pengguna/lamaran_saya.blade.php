@extends('layouts.app')
@section('title', 'Lamaran Saya')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Lamaran Saya</h1>
        
        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <p class="text-lg font-semibold text-purple-600">
                    Total Lamaran: <span class="text-gray-800">{{ $total ?? 0 }}</span>
                </p>
                <a href="{{ route('public.lowongan.index') }}" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition-colors">
                    Lihat Lowongan Lain
                </a>
            </div>

            <ul class="space-y-4">
                @forelse ($lamarans as $lamaran)
                    <li class="p-4 border border-gray-200 rounded-md shadow-sm hover:shadow-lg transition-shadow duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-xl text-gray-900">{{ $lamaran->lowongan->posisi ?? 'Posisi Tidak Ditemukan' }}</p>
                                
                                <p class="text-sm text-gray-500 mb-2">
                                    {{ $lamaran->lowongan->perusahaan->nama_perusahaan ?? 'Perusahaan Tidak Diketahui' }}
                                </p>
                                
                                <p class="text-xs text-gray-400">
                                    Tanggal Melamar: {{ \Carbon\Carbon::parse($lamaran->created_at)->format('d F Y') }}
                                </p>
                            </div>
                            
                            <div class="text-right">
                                @php
                                    $status = strtolower($lamaran->status);
                                    $class = '';
                                    $text = '';
                                    $linkText = 'Lihat Detail';
                                    
                                    // Logic untuk menentukan warna dan teks status berdasarkan data database
                                    switch ($status) {
                                        case 'diterima':
                                            $class = 'bg-green-100 text-green-800';
                                            $text = 'Diterima';
                                            $linkText = 'Lihat Status';
                                            break;
                                        case 'ditolak':
                                            $class = 'bg-red-100 text-red-800';
                                            $text = 'Ditolak';
                                            break;
                                        case 'wawancara':
                                            // Asumsi 'wawancara' adalah status custom
                                            $class = 'bg-blue-100 text-blue-800';
                                            $text = 'Wawancara';
                                            $linkText = 'Lihat Jadwal';
                                            break;
                                        case 'menunggu':
                                        default:
                                            $class = 'bg-yellow-100 text-yellow-800';
                                            $text = 'Menunggu Review';
                                            break;
                                    }
                                @endphp
                                
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $class }}">
                                    {{ $text }}
                                </span>
                                
                                <a href="#" 
                                   class="block mt-2 text-purple-600 hover:text-purple-800 text-sm font-semibold">
                                   {{ $linkText }}
                                </a>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="p-6 text-center text-gray-500 border border-gray-200 rounded-md">
                        Anda belum mengajukan lamaran pekerjaan.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection