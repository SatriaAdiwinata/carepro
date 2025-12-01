@extends('layouts.app')

@section('title', 'Daftar Lowongan Pekerjaan | CarePro')

@section('content')

    <section id="beranda" class="gradient-bg text-white py-28">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-5xl font-bold mt-12 mb-6">Temukan Pekerjaan Impian Anda</h2>
            <p class="text-xl mb-8 max-w-20xl mx-auto">CarePro menghubungkan talenta terbaik dengan perusahaan terpercaya. Mulai perjalanan karir Anda hari ini!</p>

            {{-- Form Pencarian dengan Aksi ke rute lowongan saat ini --}}
            <form action="{{ route('public.lowongan.index') }}" method="GET" class="bg-white rounded-lg p-6 max-w-4xl mx-auto shadow-xl">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Input untuk mencari posisi, kata kunci, atau perusahaan --}}
                    <input type="text" name="search" placeholder="Posisi, Perusahaan, atau Lokasi..." 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           value="{{ request('search') }}">
                    
                    {{-- Tombol Submit --}}
                    <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">Cari Kerja</button>
                </div>
            </form>
        </div>
    </section>

    <section id="lowongan" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Lowongan Tersedia ({{ $daftarLowongan->count() }})</h3>

            @if ($daftarLowongan->isEmpty())
                <div class="text-center py-10 bg-white rounded-lg shadow-md">
                    <p class="text-gray-600 text-lg">Maaf, tidak ada lowongan yang ditemukan untuk kriteria pencarian Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    {{-- LOOPING DATA LOWONGAN DARI CONTROLLER --}}
                    @foreach ($daftarLowongan as $lowongan)
                        <div class="bg-white rounded-lg shadow-md p-6 card-hover flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        {{-- Tampilkan Posisi Lowongan --}}
                                        <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $lowongan->posisi }}</h4>
                                        
                                        {{-- Tampilkan Nama Perusahaan (via relasi) --}}
                                        <p class="text-purple-600 font-medium">{{ $lowongan->perusahaan->nama_perusahaan ?? 'N/A' }}</p>
                                    </div>
                                    {{-- Tampilkan Tipe Pekerjaan --}}
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ $lowongan->tipe_pekerjaan }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 mb-3 text-sm">
                                    {{-- Tampilkan Lokasi --}}
                                    <span class="mr-4">📍 {{ $lowongan->lokasi }}</span>
                                    {{-- Tampilkan Gaji --}}
                                    <span>💰 {{ number_format($lowongan->gaji_min, 0, ',', '.') }} - {{ number_format($lowongan->gaji_max, 0, ',', '.') }}</span>
                                </div>
                                {{-- Tampilkan Deskripsi Singkat --}}
                                <p class="text-gray-600 mb-4 text-sm line-clamp-3">{{ Str::limit(strip_tags($lowongan->deskripsi), 100) }}</p>
                            </div>
                            
                            {{-- Footer Card --}}
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                {{-- Tampilkan Waktu Posting --}}
                                <span class="text-xs text-gray-500">Diposting: {{ $lowongan->created_at->diffForHumans() }}</span>
                                
                                {{-- TOMBOL LAMAR SEKARANG (MEMPERBAIKI RUTE ERROR) --}}
                                {{-- Menggunakan rute 'jobs.form' yang ada di web.php dan mengirimkan ID lowongan --}}
                                <a href="{{ route('lowongan.show', $lowongan->id) }}"
        class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
        Lihat detail
    </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

            {{-- Anda bisa menambahkan Pagination di sini jika menggunakan paginate() di Controller --}}
            {{-- Jika menggunakan paginate(), kode ini akan aktif:
                <div class="mt-10">
                    {{ $daftarLowongan->links() }}
                </div>
            --}}
        </div>
    </section>

@endsection