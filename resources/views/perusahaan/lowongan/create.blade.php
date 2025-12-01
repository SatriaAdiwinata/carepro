@extends('layouts.master')

{{-- Judul Browser/Tab --}}
@section('title', 'Tambah Lowongan Baru')

{{-- Judul Halaman di Dalam Konten --}}
@section('page-title', 'Tambah Lowongan Baru')

@section('content')
    {{-- Card dengan styling Tailwind --}}
    <div class="card bg-white p-6 rounded-xl shadow-lg">
        <div class="card-header pb-4 border-b border-gray-200 mb-6">
            <h3 class="card-title text-xl font-semibold text-gray-800">Isi Detail Lowongan</h3>
        </div>
        <div class="card-body">
            
            {{-- Form POST mengarah ke rute STORE --}}
            <form action="{{ route('perusahaan.lowongan.store') }}" method="POST">
                @csrf
                
                {{-- Menampilkan pesan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Gagal menyimpan lowongan!</strong> 
                        <span class="block sm:inline">Harap periksa kembali isian Anda.</span>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- POSISI --}}
                <div class="form-group mb-4">
                    <label for="posisi" class="form-label block mb-2 font-medium text-gray-700">Posisi <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('posisi') border-red-500 @enderror" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
                    @error('posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- TIPE PEKERJAAN --}}
                <div class="form-group mb-4">
                    <label for="tipe_pekerjaan" class="form-label block mb-2 font-medium text-gray-700">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                    <select class="form-input w-full p-2 border border-gray-300 rounded-lg @error('tipe_pekerjaan') border-red-500 @enderror" id="tipe_pekerjaan" name="tipe_pekerjaan" required>
                        <option value="">Pilih Tipe</option>
                        @foreach (['Full Time', 'Part Time', 'Kontrak', 'Freelance', 'Remote'] as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_pekerjaan') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                    </select>
                    @error('tipe_pekerjaan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- LOKASI --}}
                <div class="form-group mb-4">
                    <label for="lokasi" class="form-label block mb-2 font-medium text-gray-700">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('lokasi') border-red-500 @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                    @error('lokasi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- GAJI MIN & MAX --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="gaji_min" class="form-label block mb-2 font-medium text-gray-700">Gaji Minimum (Rupiah)</label>
                        <input type="number" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('gaji_min') border-red-500 @enderror" id="gaji_min" name="gaji_min" value="{{ old('gaji_min') }}" placeholder="Contoh: 8000000">
                        @error('gaji_min')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="gaji_max" class="form-label block mb-2 font-medium text-gray-700">Gaji Maksimum (Rupiah)</label>
                        <input type="number" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('gaji_max') border-red-500 @enderror" id="gaji_max" name="gaji_max" value="{{ old('gaji_max') }}" placeholder="Contoh: 12000000">
                        @error('gaji_max')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- BATAS LAMARAN --}}
                <div class="form-group mb-6">
                    <label for="batas_lamaran" class="form-label block mb-2 font-medium text-gray-700">Batas Lamaran</label>
                    <input type="date" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('batas_lamaran') border-red-500 @enderror" id="batas_lamaran" name="batas_lamaran" value="{{ old('batas_lamaran') }}">
                    @error('batas_lamaran')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- DESKRIPSI --}}
                <div class="form-group mb-6">
                    <label for="deskripsi" class="form-label block mb-2 font-medium text-gray-700">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[150px] @error('deskripsi') border-red-500 @enderror" id="deskripsi" name="deskripsi" rows="7" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label for="kualifikasi_wajib" class="form-label block mb-2 font-medium text-gray-700">
                        Kualifikasi WAJIB <span class="text-red-500">*</span>
                    </label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[100px] @error('kualifikasi_wajib') border-red-500 @enderror" id="kualifikasi_wajib" name="kualifikasi_wajib" rows="5" required
                        placeholder="Masukkan setiap kualifikasi wajib dalam baris baru (tekan Enter untuk poin berikutnya). Contoh:&#10;&#10;Minimal S1 Teknik Informatika&#10;Pengalaman 2 tahun di bidang terkait"
                    >{{ old('kualifikasi_wajib') }}</textarea>
                    @error('kualifikasi_wajib')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-6">
                    <label for="kualifikasi_tambahan" class="form-label block mb-2 font-medium text-gray-700">
                        Kualifikasi Tambahan (Opsional)
                    </label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[100px] @error('kualifikasi_tambahan') border-red-500 @enderror" id="kualifikasi_tambahan" name="kualifikasi_tambahan" rows="5"
                        placeholder="Masukkan kualifikasi atau preferensi tambahan (opsional, satu poin per baris). Contoh:&#10;&#10;Memiliki sertifikat AWS&#10;Fasih berbahasa Inggris"
                    >{{ old('kualifikasi_tambahan') }}</textarea>
                    @error('kualifikasi_tambahan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-6">
                    <label for="skill_dibutuhkan" class="form-label block mb-2 font-medium text-gray-700">
                        Skill yang Dibutuhkan <span class="text-red-500">*</span>
                    </label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[100px] @error('skill_dibutuhkan') border-red-500 @enderror" id="skill_dibutuhkan" name="skill_dibutuhkan" rows="5" required
                        placeholder="Masukkan setiap skill kunci dalam baris baru (tekan Enter untuk poin berikutnya)..."
                    >{{ old('skill_dibutuhkan') }}</textarea>
                    @error('skill_dibutuhkan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- STATUS --}}
                <div class="form-group mb-5">
                    <label class="form-label block mb-2 font-medium text-slate-700" for="status">Status <span class="text-red-500">*</span></label>
                    <select class="form-input w-full p-2 border border-gray-300 rounded-lg @error('status') border-red-500 @enderror" id="status" name="status" required>
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="Ditutup" {{ old('status') == 'Ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    @error('status')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="action-buttons flex gap-2 justify-start mt-6">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save me-1"></i> Simpan Lowongan
                    </button>
                    {{-- Tombol Batal/Kembali --}}
                    <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
            
        </div>
    </div>
@endsection