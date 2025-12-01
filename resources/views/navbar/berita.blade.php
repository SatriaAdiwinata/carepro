@extends('layouts.app')

@section('title', 'Platform Pencarian Kerja Terpercaya')

@section('content')

<div class="w-full bg-gray-100 shadow-sm mt-20">
  <div class="max-w-5xl mx-20 py-3 px-4 sm:px-6 lg:px-8 ">
    <h1 class="text-2xl font-medium">News & Events</h1>
  </div>
</div>
        

<!-- News Section -->
    <section id="newsSection" class="py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Artikel Utama -->
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        <div class="h-64 overflow-hidden">
                            <img src="http://googleusercontent.com/image_collection/image_retrieval/4636124286068420986_0" alt="Seseorang bekerja dari jauh di ruang kerja yang nyaman" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">Trending</span>
                            <h3 class="text-xl font-bold text-gray-800 mt-3 mb-2">
                                Tren Pekerjaan Remote di Indonesia Meningkat 150% di Tahun 2024
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Survei terbaru menunjukkan bahwa pekerjaan remote semakin diminati oleh para pencari kerja di Indonesia. Perusahaan-perusahaan besar mulai membuka lebih banyak posisi remote...
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">15 Januari 2024</span>
                                <button class="text-purple-600 hover:text-purple-800 font-semibold">Baca Selengkapnya →</button>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Artikel Samping -->
                <div class="space-y-6">
                    <article class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex items-center mb-3">
                            <img src="b1.jpg" alt="Seorang mahasiswa sedang belajar dan menguasai keterampilan baru" class="w-12 h-12 object-cover rounded-lg mr-4" />
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">5 Skill Wajib untuk Fresh Graduate di 2024</h4>
                        <p class="text-sm text-gray-600 mb-3">Pelajari skill-skill yang paling dicari oleh perusahaan untuk fresh graduate...</p>
                        <span class="text-xs text-gray-500">12 Januari 2024</span>
                    </article>

                    <article class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="flex items-center mb-3">
                            <img src="http://googleusercontent.com/image_collection/image_retrieval/2331572534364497710_0" alt="Kode di layar komputer yang mewakili industri teknologi" class="w-12 h-12 object-cover rounded-lg mr-4" />
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Industri Tech Buka 10,000+ Lowongan Baru</h4>
                        <p class="text-sm text-gray-600 mb-3">Sektor teknologi mengalami pertumbuhan pesat dengan membuka ribuan posisi...</p>
                        <span class="text-xs text-gray-500">10 Januari 2024</span>
                    </article>
                </div>
            </div>

            <!-- Grid Berita Lainnya -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="h-32 overflow-hidden">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/9391905781014290854_0" alt="Anggota tim startup merayakan keberhasilan" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 mt-2 mb-2">Startup Lokal Raih Funding $50M</h4>
                        <p class="text-sm text-gray-600">Peluang kerja baru terbuka lebar...</p>
                        <span class="text-xs text-gray-500 mt-2 block">8 Januari 2024</span>
                    </div>
                </article>

                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="h-32 overflow-hidden">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/10879016257194210801_0" alt="Robot atau AI merekrut orang" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 mt-2 mb-2">AI Mengubah Landscape Rekrutmen</h4>
                        <p class="text-sm text-gray-600">Teknologi AI membantu proses hiring...</p>
                        <span class="text-xs text-gray-500 mt-2 block">5 Januari 2024</span>
                    </div>
                </article>

                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="h-32 overflow-hidden">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/3163666500688144316_0" alt="Gambar keseimbangan antara pekerjaan dan kehidupan pribadi" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 mt-2 mb-2">Work-Life Balance Jadi Prioritas</h4>
                        <p class="text-sm text-gray-600">Karyawan lebih memilih perusahaan...</p>
                        <span class="text-xs text-gray-500 mt-2 block">3 Januari 2024</span>
                    </div>
                </article>

                <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                    <div class="h-32 overflow-hidden">
                        <img src="http://googleusercontent.com/image_collection/image_retrieval/13956893606350999534_0" alt="Diagram atau grafik yang menunjukkan kenaikan gaji" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 mt-2 mb-2">Gaji IT Naik 25% di Q1 2024</h4>
                        <p class="text-sm text-gray-600">Sektor IT mengalami kenaikan gaji...</p>
                        <span class="text-xs text-gray-500 mt-2 block">1 Januari 2024</span>
                    </div>
                </article>
            </div>
        </div>
    </section>