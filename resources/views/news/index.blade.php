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
  <div class="max-w-5xl mx-20 py-3 px-4 sm:px-6 lg:px-8 ">
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
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        @if($total == 0)
            <p class="text-center text-xl text-gray-500 py-10">Belum ada berita yang dipublikasikan saat ini.</p>
        @else
            {{-- Menggunakan 'items-stretch' untuk memastikan kolom sidebar mengisi sisa ruang --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                
                {{-- ARTIKEL UTAMA (FEATURED) --}}
                @if($featuredBerita)
                <div class="lg:col-span-2">
                    {{-- Menambahkan h-full untuk memastikan artikel mengisi tinggi kolom --}}
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover h-full flex flex-col">
                        {{-- Link ke halaman detail --}}
                        <a href="{{ route('news.show', $featuredBerita->slug) }}" class="block">
                            {{-- Gambar lebih besar (h-80) --}}
                            <div class="h-80 overflow-hidden">
                                @if ($featuredBerita->gambar)
                                    <img src="{{ Storage::url($featuredBerita->gambar) }}" alt="{{ $featuredBerita->judul }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-[1.03]" />
                                @else
                                    <img src="https://placehold.co/800x400/8b5cf6/ffffff?text=CarePro+News+Featured" alt="Placeholder Gambar" class="w-full h-full object-cover" />
                                @endif
                            </div>
                        </a>
                        {{-- Menggunakan flex-grow untuk mengisi sisa ruang --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full w-fit">Artikel Utama</span>
                            <a href="{{ route('news.show', $featuredBerita->slug) }}">
                                <h3 class="text-2xl font-bold text-gray-800 mt-3 mb-2 hover:text-purple-600 transition-colors">
                                    {{ $featuredBerita->judul }}
                                </h3>
                            </a>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($featuredBerita->konten), 200) }}
                            </p>
                            {{-- Menggunakan mt-auto untuk mendorong link ke bawah --}}
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
                                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($featuredBerita->created_at)->translatedFormat('d F Y') }}</span>
                                <a href="{{ route('news.show', $featuredBerita->slug) }}" class="text-purple-600 hover:text-purple-800 font-semibold">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </article>
                </div>
                @endif

                {{-- ARTIKEL SAMPING (SIDEBAR) --}}
                {{-- Menambahkan h-full untuk memastikan kolom mengisi sisa tinggi --}}
                <div class="space-y-6 h-full">
                    @forelse ($sidebarBeritas as $berita)
                    <article class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100">
                        <a href="{{ route('news.show', $berita->slug) }}" class="block">
                            {{-- Mengubah alignment menjadi items-start untuk gambar yang lebih besar --}}
                            <div class="flex items-start mb-3">
                                {{-- Gambar DIBESARKAN dari w-16 h-16 menjadi w-24 h-24 --}}
                                <div class="w-24 h-24 overflow-hidden rounded-lg mr-4 flex-shrink-0">
                                    @if ($berita->gambar)
                                        <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover" />
                                    @else
                                        {{-- Placeholder juga disesuaikan ukurannya --}}
                                        <img src="https://placehold.co/96x96/f5f3ff/9333ea?text=CP" alt="Placeholder" class="w-full h-full object-cover" />
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-gray-800 mb-1 line-clamp-2 hover:text-purple-600 transition-colors">{{ $berita->judul }}</h4>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>

                            {{-- Menambahkan Deskripsi Konten --}}
                            <p class="text-sm text-gray-600 mt-2 mb-3 line-clamp-3">
                                {{ Str::limit(strip_tags($berita->konten), 120) }}
                            </p>
                            
                            <p class="text-sm text-purple-600 hover:text-purple-800 font-medium">Baca Selengkapnya →</p>
                        </a>
                    </article>
                    @empty
                    {{-- Kosong jika hanya ada 1 featured article --}}
                    @endforelse
                </div>
            </div>

            {{-- GRID BERITA LAINNYA (Dibatasi 4) --}}
            @if ($otherBeritas->isNotEmpty())
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                @foreach ($otherBeritas as $berita)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover border border-gray-100">
                    <a href="{{ route('news.show', $berita->slug) }}" class="block">
                        {{-- Gambar lebih besar (h-48) --}}
                        <div class="h-48 overflow-hidden">
                            @if ($berita->gambar)
                                <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover" />
                            @else
                                <img src="https://placehold.co/400x150/f3f4f6/6b7280?text=Artikel+Lain" alt="Placeholder" class="w-full h-full object-cover" />
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('news.show', $berita->slug) }}">
                            <h4 class="font-bold text-gray-800 mt-1 mb-1 line-clamp-2 hover:text-purple-600 transition-colors">{{ $berita->judul }}</h4>
                        </a>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($berita->konten), 80) }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                            <a href="{{ route('news.show', $berita->slug) }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
            
            {{-- PAGINATION --}}
            <div class="mt-12">
                {{ $beritas->links() }}
            </div>
        @endif
    </div>
</section>     

@endsection
