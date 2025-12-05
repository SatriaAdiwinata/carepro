@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

    {{-- Container Utama --}}
    <div class="max-w-4xl mx-auto pt-24 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl border border-gray-100 mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-6 border-b pb-3 flex items-center">
                <i class="fas fa-edit me-3 text-purple-600"></i> Edit Profil Saya
            </h1>

            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-xl shadow-md mb-6">
                    <h5 class="mb-2 font-bold"><i class="fas fa-exclamation-triangle me-2"></i> Perhatian!</h5>
                    <ul class="list-disc list-inside text-sm mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulir Edit --}}
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Bagian 1: Informasi Akun --}}
                <div class="mb-8 border-b pb-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-4"><i class="fas fa-user-shield me-2"></i> Data Akun</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Foto Profil --}}
                        <div class="md:col-span-1 text-center">
                            <label class="block mb-2 font-medium text-slate-700">Foto Profil</label>
                            <div class="relative w-36 h-36 mx-auto mb-3 rounded-full overflow-hidden border-4 border-purple-200">
                                @php
                                    // URL foto profil, jika ada, gunakan Storage::url(), jika tidak gunakan placeholder
                                    $photoUrl = $user->profile_photo_path ? Storage::url($user->profile_photo_path) : 'https://placehold.co/144x144/f0f4f8/9333ea?text=Foto';
                                @endphp
                                <img id="current-photo" src="{{ $photoUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
                                <button type="button" onclick="document.getElementById('profile_photo').click()" class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300 text-white text-sm font-semibold">Ubah</button>
                            </div>
                            <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                            @error('profile_photo')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Nama & Email --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="form-label block mb-2 font-medium text-slate-700" for="nama">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('nama') border-red-500 @enderror">
                                @error('nama')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                            </div>
                            
                            <div>
                                <label class="form-label block mb-2 font-medium text-slate-700" for="email">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror">
                                @error('email')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Data Pribadi Pelamar (HANYA FIELD YANG ADA DI DB) --}}
                <div class="mb-8 border-b pb-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-4"><i class="fas fa-id-card me-2"></i> Data Pelamar</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Telepon diubah menjadi no_hp --}}
                        <div>
                            <label class="form-label block mb-2 font-medium text-slate-700" for="no_hp">Nomor Telepon</label>
                            <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelamar->no_hp) }}" class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('no_hp') border-red-500 @enderror">
                            @error('no_hp')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        {{-- Field Tanggal Lahir, Jenis Kelamin, dan Pendidikan Terakhir Dihapus --}}
                        <div class="md:col-span-2">
                             <label class="form-label block mb-2 font-medium text-slate-700" for="alamat">Alamat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="3" class="form-textarea w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $pelamar->alamat) }}</textarea>
                            @error('alamat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                       
                    </div>

                </div>

                {{-- Bagian 3: Media Sosial (HANYA FIELD YANG ADA DI DB) --}}
                <div class="mb-8 border-b pb-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-4"><i class="fas fa-link me-2"></i> Media Sosial</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        
                        {{-- Field LinkedIn dan Portfolio Dihapus --}}

                        {{-- Instagram --}}
                        <div>
                            <label class="form-label block mb-2 font-medium text-slate-700" for="instagram">Username Instagram</label>
                            <input type="text" id="instagram" name="instagram" placeholder="tanpa @ atau https://" value="{{ old('instagram', $pelamar->instagram) }}" class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('instagram') border-red-500 @enderror">
                            @error('instagram')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- TikTok --}}
                        <div>
                            <label class="form-label block mb-2 font-medium text-slate-700" for="tiktok">Username TikTok</label>
                            <input type="text" id="tiktok" name="tiktok" placeholder="tanpa @ atau https://" value="{{ old('tiktok', $pelamar->tiktok) }}" class="form-input w-full p-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 @error('tiktok') border-red-500 @enderror">
                            @error('tiktok')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Deskripsi Pengalaman Kerja Dihapus --}}

                </div>

                {{-- Tombol Aksi --}}
                <div class="action-buttons flex gap-3 justify-end pt-4">
                    <a href="{{ route('profil.show') }}" class="btn bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-all duration-300 hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="btn bg-purple-600 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 hover:bg-purple-700 hover:shadow-lg hover:shadow-purple-300">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan preview foto yang diupload
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('current-photo').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush