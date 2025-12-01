@extends('layouts.app')
tion('title', 'Platform Pencarian Kerja Terpercaya')

@section('content')

<!-- Home/Welcome Section -->
<section id="beranda" class="gradient-bg text-white py-5">
    <div class="container mx-auto px-6 flex flex-row items-center justify-between gap-10">
        <div class="w-1/2 mt-20 ml-16">
            
            {{-- Ambil nama pengguna yang login --}}
            @php
                $namaPengguna = Auth::user()->nama ?? 'Pengguna';
            @endphp
            
            {{-- HANYA menampilkan ucapan selamat datang untuk peran 'pelamar' --}}
            @if(strtolower(Auth::user()->peran) === 'pelamar')
                <h2 class="text-6xl font-bold mb-6">Selamat Datang, {{ $namaPengguna }} 👋</h2>
                <p class="text-2xl mb-8 leading-relaxed">
                    <br>Lanjutkan perjalanan karirmu bersama CarePro. Temukan rekomendasi pekerjaan yang sesuai untukmu.<br>
                </p>
            @endif
            
        </div>
        <div class="w-1/1 mt-10 flex justify-center ml-20">
            <img src="images/pengguna.png" 
                 alt="Karir Impian" 
                 class="w- max-w-md ">
        </div>
    </div>
</section>


<!-- Konten yang Sama untuk Kedua Peran -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-2">10,000+</div>
                <div class="text-gray-600">Lowongan Aktif</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-2">5,000+</div>
                <div class="text-gray-600">Perusahaan Terdaftar</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-2">50,000+</div>
                <div class="text-gray-600">Pencari Kerja</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-2">95%</div>
                <div class="text-gray-600">Tingkat Kepuasan</div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-100">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Lowongan Kerja Terbaru
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($lowonganTerbaru as $lowongan)
                    {{-- Card Lowongan (Diperbarui) --}}
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-2xl font-bold text-gray-800 line-clamp-1">{{ $lowongan->posisi }}</h4>
                            {{-- Badge Tipe Pekerjaan --}}
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap">{{ $lowongan->tipe_pekerjaan }}</span>
                        </div>
                        
                        {{-- Nama Perusahaan --}}
                        <p class="text-lg text-purple-600 font-semibold mb-3">{{ $lowongan->perusahaan->nama_perusahaan ?? 'Perusahaan Tidak Ditemukan' }}</p>
                        
                        {{-- Lokasi dan Gaji --}}
                        <div class="flex flex-wrap items-center text-gray-700 mb-4 text-base">
                            {{-- Ikon dan Lokasi --}}
                            <span class="mr-6 flex items-center">
                                {{-- Ikon pin/map marker --}}
                                <i class="fas fa-map-marker-alt text-pink-500 me-2"></i> 
                                {{ $lowongan->lokasi ?? 'Remote' }}
                            </span>
                            
                            {{-- Ikon dan Gaji --}}
                            <span class="flex items-center">
                                {{-- Ikon money/gaji --}}
                                <i class="fas fa-money-bill-wave text-yellow-600 me-2"></i> 
                                @if ($lowongan->gaji_min && $lowongan->gaji_max)
                                    Rp{{ number_format($lowongan->gaji_min, 0, ',', '.') }} - Rp{{ number_format($lowongan->gaji_max, 0, ',', '.') }}
                                @else
                                    Negosiasi
                                @endif
                            </span>
                        </div>
                        
                        {{-- Deskripsi/Ringkasan Lowongan --}}
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($lowongan->deskripsi), 100) }}
                        </p>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-50">
                            {{-- Waktu Posting --}}
                            <span class="text-sm text-gray-500">Diposting: {{ \Carbon\Carbon::parse($lowongan->created_at)->diffForHumans() }}</span>
                            
                            {{-- Tombol "Lamar Sekarang" --}}
                                              <a href="{{ route('lowongan.show', $lowongan->id) }}"
        class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
        Lihat detail
    </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 text-center py-5 bg-white rounded-lg shadow-md">
                        <p class="text-gray-600 text-lg">Saat ini belum ada lowongan pekerjaan aktif yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('public.lowongan.index') }}" class="text-xl font-semibold text-purple-600 hover:text-purple-800 transition-colors border-b-2 border-purple-600 pb-1">
                    Lihat Semua Lowongan &rarr;
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center text-gray-800 mb-4">Berita dan Artikel Terbaru</h3>
            <p class="text-center text-gray-600 mb-10">Informasi dan wawasan terbaru dari CarePro.</p>

            {{-- Cek apakah ada berita --}}
            @if($beritas->isEmpty())
                <p class="text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
            @else
                {{-- Grid untuk menampilkan berita, sesuaikan jumlah kolom (misal: 3) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    @foreach ($beritas as $berita)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            
                            {{-- Gambar Berita --}}
                            @if ($berita->gambar)
                                {{-- Pastikan Anda sudah menjalankan 'php artisan storage:link' --}}
                                <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            <div class="p-6">
                                <h4 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2">{{ $berita->judul }}</h4>
                                
                                {{-- Tampilkan potongan konten --}}
                                {{-- Pastikan Anda sudah mengimpor Str di layout Anda jika ini tidak berfungsi: use Illuminate\Support\Str; --}}
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                                
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span> {{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                                    
                                    {{-- LINK BACA SELENGKAPNYA --}}
                                    <a href="{{ route('news.show', $berita->slug) }}" class="text-purple-600 hover:text-purple-800 font-medium transition-colors">
                                        Baca Selengkapnya &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
        </div>  
</section>

@endsection
