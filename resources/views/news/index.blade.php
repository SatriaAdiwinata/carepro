@extends('layouts.app')

@section('title', 'Berita dan Acara CarePro')

@section('content')

{{-- Style for Card Hover Effect (Custom CSS) --}}
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .card-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
</style>

<div class="w-full bg-gray-100 shadow-sm mt-20">
    <div class="max-w-5xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-medium">News & Events</h1>
    </div>
</div>
    
{{-- Logic untuk memisahkan artikel: Featured (1), Sidebar (2), Grid Lainnya (Maksimal 4) --}}
@php
    // Fix: Menggunakan metode items() untuk mengambil koleksi item dari Paginator,
    // yang mencegah error "Cannot access protected property Illuminate\Pagination\LengthAwarePaginator::$items".
    if ($beritas instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $beritasCollection = collect($beritas->items());
    } else {
        // Asumsi jika bukan Paginator, maka sudah berupa Collection/Array.
        $beritasCollection = collect($beritas);
    }
    
    $total = $beritasCollection->count();

    $featuredBerita = $total > 0 ? $beritasCollection->get(0) : null;
    $sidebarBeritas = $total > 1 ? $beritasCollection->slice(1, 2) : collect(); // Ambil index 1 dan 2
    
    // MODIFIKASI: Mengambil maksimal 4 artikel dari sisa koleksi (mulai dari index 3)
    $otherBeritas = $total > 3 ? $beritasCollection->slice(3, 4) : collect(); 
@endphp

<!-- News Section -->
<section id="newsSection" class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($total == 0)
            <p class="text-center text-lg sm:text-xl text-gray-500 py-10">Belum ada berita yang dipublikasikan saat ini.</p>
        @else

        <!-- Featured + Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- ARTIKEL UTAMA --}}
            @if($featuredBerita)
            <div class="lg:col-span-2">
                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover h-full flex flex-col">
                    <a href="{{ route('news.show', $featuredBerita->slug) }}">
                        <div class="h-56 sm:h-72 md:h-80 overflow-hidden">
                            @if ($featuredBerita->gambar)
                                <img src="{{ Storage::url($featuredBerita->gambar) }}"
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @else
                                <img src="https://placehold.co/800x400/8b5cf6/ffffff?text=CarePro+News+Featured"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                    </a>
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full w-fit">
                            Artikel Utama
                        </span>

                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mt-3 mb-3 hover:text-purple-600">
                            {{ $featuredBerita->judul }}
                        </h3>

                        <p class="text-gray-600 mb-4 line-clamp-3 text-sm sm:text-base">
                            {{ Str::limit(strip_tags($featuredBerita->konten), 200) }}
                        </p>

                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100 text-sm">
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($featuredBerita->created_at)->translatedFormat('d F Y') }}</span>
                            <a href="{{ route('news.show', $featuredBerita->slug) }}" class="text-purple-600 hover:text-purple-800 font-semibold">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </article>
            </div>
            @endif

            {{-- SIDEBAR ARTIKEL --}}
            <div class="space-y-6">
                @foreach ($sidebarBeritas as $berita)
                <article class="bg-white rounded-xl shadow-lg p-4 sm:p-6 card-hover border border-gray-100">
                    <a href="{{ route('news.show', $berita->slug) }}" class="block">
                        <div class="flex items-start mb-3">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 overflow-hidden rounded-lg mr-4 flex-shrink-0">
                                @if ($berita->gambar)
                                    <img src="{{ Storage::url($berita->gambar) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://placehold.co/96x96/f5f3ff/9333ea?text=CP" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-gray-800 mb-1 line-clamp-2 text-sm sm:text-base hover:text-purple-600">
                                    {{ $berita->judul }}
                                </h4>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
                        <p class="text-sm text-purple-600 font-semibold hover:text-purple-800">Baca Selengkapnya →</p>
                    </a>
                </article>
                @endforeach
            </div>
        </div>

        {{-- GRID BERITA LAINNYA --}}
        @if ($otherBeritas->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
            @foreach ($otherBeritas as $berita)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                <a href="{{ route('news.show', $berita->slug) }}">
                    <div class="h-40 sm:h-48 overflow-hidden">
                        @if ($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" class="w-full h-full object-cover">
                        @else
                        <img src="https://placehold.co/400x150/f3f4f6/6b7280?text=Artikel+Lain" class="w-full h-full object-cover">
                        @endif
                    </div>
                </a>
                <div class="p-4">
                    <h4 class="font-bold text-gray-800 text-sm sm:text-base mt-1 mb-1 line-clamp-2 hover:text-purple-600">
                        {{ $berita->judul }}
                    </h4>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($berita->konten), 80) }}</p>
                    <div class="flex justify-between items-center mt-3 text-xs sm:text-sm">
                        <span class="text-gray-500">{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                        <a href="{{ route('news.show', $berita->slug) }}" class="font-semibold text-purple-600 hover:text-purple-800">→</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $beritas->links() }}
        </div>

        @endif
    </div>
</section>    

@endsection
