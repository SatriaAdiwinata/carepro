@extends('admin.layouts.app')

@section('title', 'Detail Pengguna: ' . $user->nama)

@section('content')

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">
                    Detail Pengguna: {{ $user->nama }}
                </h3>
                
                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
            
            <div class="p-6">
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    
                    {{-- Kolom Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm sm:text-sm text-gray-900 font-medium">
                            {{ $user->nama }}
                        </div>
                    </div>

                    {{-- Kolom Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm sm:text-sm text-gray-900 font-medium">
                            {{ $user->email }}
                        </div>
                    </div>

                    {{-- Kolom Peran (Tipe) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peran/Tipe Pengguna</label>
                        @php
                            $role_map = [
                                'admin' => ['label' => 'Administrator', 'color' => 'red'],
                                'perusahaan' => ['label' => 'Perusahaan', 'color' => 'purple'],
                                'pelamar' => ['label' => 'Pencari Kerja', 'color' => 'blue'],
                            ];
                            $current_role = $role_map[$user->peran] ?? ['label' => 'Tidak Diketahui', 'color' => 'gray']; 
                        @endphp
                        <div class="mt-1">
                            <span class="px-3 py-1 text-sm font-medium text-{{ $current_role['color'] }}-800 bg-{{ $current_role['color'] }}-100 rounded-full">
                                {{ $current_role['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Kolom Tanggal Bergabung --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm sm:text-sm text-gray-900 font-medium">
                            {{ $user->created_at->format('d F Y H:i:s') }}
                        </div>
                    </div>

                    {{-- Kolom Waktu Terakhir Diperbarui --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md shadow-sm sm:text-sm text-gray-900 font-medium">
                            {{ $user->updated_at->format('d F Y H:i:s') }}
                        </div>
                    </div>
                    
                </div>
                
                {{-- Bagian Lain yang mungkin Anda butuhkan (misal: relasi ke profil Perusahaan/Pelamar) --}}
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Tambahan (Relasi)</h4>
                    {{-- Contoh: Jika pengguna adalah 'perusahaan', tampilkan nama perusahaan --}}
                    @if ($user->peran === 'perusahaan' && $user->perusahaan)
                        <p class="text-gray-600">Nama Perusahaan: <span class="font-medium text-gray-900">{{ $user->perusahaan->nama_perusahaan }}</span></p>
                        {{-- Tambahkan detail lain dari tabel perusahaan --}}
                    @elseif ($user->peran === 'pelamar' && $user->pelamar)
                        <p class="text-gray-600">Pelamar ID: <span class="font-medium text-gray-900">{{ $user->pelamar->id }}</span></p>
                        {{-- Tambahkan detail lain dari tabel pelamar --}}
                    @else
                        <p class="text-gray-500 italic">Tidak ada detail relasi yang tersedia.</p>
                    @endif
                </div>

            </div> {{-- Akhir p-6 --}}
        </div> {{-- Akhir bg-white --}}
    </div>

@endsection