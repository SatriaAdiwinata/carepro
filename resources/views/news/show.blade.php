@extends('layouts.app')
@section('title', $berita->judul)

@section('content')

    {{-- 1. Bagian Header (Judul & Meta Data) - FULL WIDTH --}}
    <div class="pt-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumbs --}}
            <div class="text-sm text-gray-500 mb-2">
                <a href="{{ url('/') }}" class="hover:text-purple-600">Home</a> &gt;
                <a href="{{ route('news.index') }}" class="hover:text-purple-600">News & Events</a> &gt;
                <span class="text-gray-700">{{ Str::limit($berita->judul, 40) }}</span>
            </div>

            {{-- Judul Besar --}}
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                {{ $berita->judul }}
            </h1>


            {{-- Meta Data (Penulis & Tanggal) - HANYA Penulis yang ditinggalkan di sini --}}
            <div class="flex items-center text-sm text-gray-500 border-b pb-4 mb-8">
                <span class="mr-4">
                    <i class="fas fa-user-circle mr-1"></i>
                    {{ $berita->penulis }}
                </span>
            </div>
        </div>
    </div>

    {{-- 2. AREA KONTEN UTAMA DUA KOLOM (FOTO + KONTEN + SIDEBAR) --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

       <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-10">


            {{-- KOLOM KIRI (Konten Utama) - Mengambil 3 dari 4 kolom --}}
            <div class="lg:col-span-3">

                {{-- FOTO UTAMA --}}
                @if ($berita->gambar)
                    <div class="w-full mb-10">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Utama {{ $berita->judul }}"
                            class="w-full h-96 object-cover rounded-lg shadow-xl">
                    </div>
                @endif

                {{-- 💡 PERUBAHAN 2: TANGGAL PINDAH KE SINI --}}
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-xl font-bold text-gray-800">Konten Artikel</h2>
                    <span class="text-sm text-gray-500 flex items-center">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}
                    </span>
                </div>

                {{-- Konten Lengkap --}}
                <div class="prose lg:prose-lg max-w-none mb-12">
                    {!! $berita->konten !!}
                </div>

            </div>

            {{-- KOLOM KANAN (Sidebar Berita Lainnya) --}}
            <div class="lg:col-span-1">

                <div class="sticky top-24">

                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Berita Lainnya</h2>

                    <div class="space-y-4">
                        @forelse($terkait as $item)
                            {{-- Item Berita Terkait: Card Vertikal --}}
                            {{-- 💡 PERUBAHAN 1: container lebih kecil (space-y-4 & padding p-2) --}}
                            <a href="{{ route('news.show', $item->slug) }}"
                                class="group block border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">

                                {{-- FOTO (Thumbnail melebar di dalam sidebar) --}}
                                <div class="relative w-full h-24 overflow-hidden">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif

                                    {{-- Tanggal di Bawah Foto --}}
                                    <p
                                        class="absolute bottom-0 right-0 bg-black bg-opacity-50 text-white text-xs px-2 py-0.5 rounded-tl-lg">
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                    </p>
                                </div>

                                {{-- Teks Berita Terkait --}}
                                <div class="p-2">
                                    {{-- 💡 JUDUL DIKECILKAN: text-sm --}}
                                    <h3
                                        class="font-semibold text-sm text-gray-800 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                        {{ $item->judul }}
                                    </h3>

                                    {{-- Deskripsi (Opsional) --}}
                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                        {{ Str::limit(strip_tags($item->konten), 40) }}
                                    </p>
                                </div>

                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada berita terkait lainnya.</p>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection