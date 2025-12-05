@extends('layouts.app')

@section('title', 'Platform Pencarian Kerja Terpercaya')

@section('content')
    <section id="beranda" class="gradient-bg text-white py-10">
    <div class="container mt-6 mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-10">

        <!-- Text -->
        <div class="w-full ml-0 md:ml-16 md:w-1/2 text-center md:text-left">
            <h2 class="text-4xl md:text-6xl font-bold mb-6 mt-12 md:mt-0 
                max-w-xs sm:max-w-sm md:max-w-none mx-auto md:mx-0 leading-tight">
                Temukan Karir Impian Anda
            </h2>
            <p class="text-lg md:text-1xl mb-8 leading-relaxed">
                CarePropro menghubungkan talenta terbaik
                dengan perusahaan terpercaya. membantu Anda menemukan peluang kerja yang sesuai keahlian.
                Mulai perjalanan karir Anda hari ini!
            </p>
        </div>

        <!-- Image -->
        <div class="w-full md:w-1/2 flex justify-center -mt-16 md:mt-0">
            <img src="images/KarirCP.png"
                 alt="Karir Impian"
                 class="w-full max-w-xs sm:max-w-sm md:max-w-md">
        </div>

    </div>
</section>


    <section class="py-10 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
            
            <div>
                <div class="text-4xl font-bold text-purple-600 mb-1">10,000+</div>
                <div class="text-gray-600 text-sm md:text-base">Lowongan Aktif</div>
            </div>

            <div>
                <div class="text-4xl font-bold text-purple-600 mb-1">5,000+</div>
                <div class="text-gray-600 text-sm md:text-base">Perusahaan Terdaftar</div>
            </div>

            <div>
                <div class="text-4xl font-bold text-purple-600 mb-1">50,000+</div>
                <div class="text-gray-600 text-sm md:text-base">Pencari Kerja</div>
            </div>

            <div>
                <div class="text-4xl font-bold text-purple-600 mb-1">95%</div>
                <div class="text-gray-600 text-sm md:text-base">Tingkat Kepuasan</div>
            </div>

        </div>
    </div>
</section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-800 mb-4">Mengapa Memilih CarePro?</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 card-hover bg-gray-50 rounded-lg">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎯</span>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">Pencarian Tepat Sasaran</h4>
                    <p class="text-gray-600">Algoritma canggih yang mencocokkan skill dan preferensi Anda dengan lowongan yang tepat</p>
                </div>
                
                <div class="text-center p-6 card-hover bg-gray-50 rounded-lg">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🏢</span>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">Perusahaan Terpercaya</h4>
                    <p class="text-gray-600">Bermitra dengan perusahaan-perusahaan terbaik di Indonesia</p>
                </div>
                
                <div class="text-center p-6 card-hover bg-gray-50 rounded-lg">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⚡</span>
                    </div>
                    <h4 class="text-xl font-semibold mb-3">Proses Cepat</h4>
                    <p class="text-gray-600">Lamar pekerjaan dengan mudah dan dapatkan respon lebih cepat</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <!-- Image -->
            <div class="flex justify-center">
                <img src="images/TentangCP.png" alt="Tentang Kami" 
                     class="w-full max-w-md rounded-lg">
            </div>

            <!-- Text Content -->
            <div>
                <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">
                    Tentang Kami
                </h3>

                <p class="text-lg text-gray-600 mb-8 text-center md:text-left">
                    CarePro adalah platform pencarian kerja terdepan di Indonesia yang menghubungkan talenta terbaik dengan perusahaan-perusahaan terpercaya. Kami berkomitmen untuk membantu setiap individu menemukan karir yang sesuai dengan passion dan kemampuan mereka.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-xl font-semibold mb-4 text-purple-600">Untuk Pencari Kerja</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li>✓ Akses ke ribuan lowongan kerja</li>
                            <li>✓ Profile builder yang mudah</li>
                            <li>✓ Notifikasi lowongan sesuai kriteria</li>
                            <li>✓ Tips karir dan interview</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold mb-4 text-purple-600">Untuk Perusahaan</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li>✓ Posting lowongan dengan mudah</li>
                            <li>✓ Database kandidat berkualitas</li>
                            <li>✓ Tools screening yang efektif</li>
                            <li>✓ Analytics dan reporting</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
    <!-- Job Listings -->
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

{{-- ... bagian bawah file ... --}}
@endsection