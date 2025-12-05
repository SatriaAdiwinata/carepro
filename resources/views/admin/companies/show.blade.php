@extends('admin.layouts.app')

@section('title', 'Detail Perusahaan: PT Tech Indonesia')

@section('content')

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">
                    Detail Perusahaan: PT Tech Indonesia
                </h3>
                
                <!-- Tombol Kembali -->
                <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
            
            <div class="p-6">
                
                <!-- Logo dan Info Utama -->
                <div class="flex items-start space-x-6 mb-8 pb-6 border-b border-gray-200">
                    <div class="flex-shrink-0">
                        <!-- Logo Dummy -->
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">PT</span>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">PT Tech Indonesia</h2>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 rounded-full">
                                Teknologi
                            </span>
                            <span class="px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                                50-100 karyawan
                            </span>
                        </div>
                        <div class="flex items-center text-gray-600 space-x-4 text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                Jakarta
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                3 Lowongan Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Grid Informasi Detail -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Perusahaan</label>
                        <div class="flex items-center p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">info@techindonesia.com</span>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <div class="flex items-center p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">021-12345678</span>
                        </div>
                    </div>

                    <!-- Website -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <div class="flex items-center p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="https://techindonesia.com" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">https://techindonesia.com</a>
                        </div>
                    </div>

                    <!-- Tahun Berdiri -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Berdiri</label>
                        <div class="flex items-center p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">2015</span>
                        </div>
                    </div>

                    <!-- Tanggal Bergabung -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                        <div class="flex items-center p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">15 Januari 2024 10:30:00</span>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Perusahaan -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perusahaan</label>
                    <div class="p-4 bg-gray-50 border border-gray-300 rounded-md">
                        <p class="text-gray-700 leading-relaxed">
                            PT Tech Indonesia adalah perusahaan teknologi terkemuka yang berfokus pada pengembangan solusi digital inovatif. Kami menyediakan layanan konsultasi IT, pengembangan aplikasi mobile dan web, serta solusi cloud computing untuk berbagai industri.
                            <br><br>
                            Dengan tim profesional yang berpengalaman lebih dari 10 tahun di bidang teknologi, kami berkomitmen untuk memberikan solusi terbaik yang sesuai dengan kebutuhan klien. Kami telah melayani lebih dari 100 klien dari berbagai sektor termasuk perbankan, retail, dan e-commerce.
                        </p>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <div class="p-4 bg-gray-50 border border-gray-300 rounded-md">
                        <p class="text-gray-700 leading-relaxed">
                            Jl. Jenderal Sudirman No. 123, Tanah Abang, Jakarta Pusat, DKI Jakarta 10220
                        </p>
                    </div>
                </div>

                <!-- Daftar Lowongan Perusahaan -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Lowongan yang Diposting</h4>
                        <span class="px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                            3 Lowongan
                        </span>
                    </div>
                    
                    <div class="space-y-3">
                        <!-- Lowongan 1 -->
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900">Frontend Developer</h5>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span>📍 Jakarta</span>
                                    <span>💼 Full-time</span>
                                    <span>💰 Rp 8-12 juta</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        <!-- Lowongan 2 -->
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900">Backend Developer</h5>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span>📍 Jakarta</span>
                                    <span>💼 Full-time</span>
                                    <span>💰 Rp 10-15 juta</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        <!-- Lowongan 3 -->
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900">UI/UX Designer</h5>
                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                    <span>📍 Jakarta</span>
                                    <span>💼 Full-time</span>
                                    <span>💰 Rp 7-10 juta</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 transition-colors"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini? Tindakan ini tidak dapat dibatalkan.');">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Hapus Perusahaan
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection