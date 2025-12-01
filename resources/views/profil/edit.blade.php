@extends('layouts.master')

@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan')

@section('content')

    {{-- Notifikasi Error (jika validasi gagal) menggunakan styling yang disesuaikan --}}
    @if ($errors->any())
        {{-- Menggunakan styling card untuk notifikasi error --}}
        <div class="card bg-red-100 border border-red-400 text-red-700 p-4 rounded-xl shadow-md mb-4">
            <h5 class="mb-2 font-bold"><i class="fas fa-exclamation-triangle me-2"></i> Error: Ada masalah dengan input Anda.</h5>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- Container utama formulir edit menggunakan kelas dari kode Anda --}}
    <div id="edit-job-page" class="card bg-white p-6 rounded-xl shadow-md mb-5">
        <div class="card-header flex justify-between items-center mb-5 pb-4 border-b-2 border-slate-100">
            <h3 class="card-title text-xl font-semibold text-slate-800">Edit Lowongan Pekerjaan: {{ $lowongan->posisi }}</h3>
            <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="card-body">
            
            {{-- Form PUT/PATCH mengarah ke rute UPDATE --}}
            <form action="{{ route('perusahaan.lowongan.update', $lowongan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- POSISI --}}
                <div class="form-group mb-6">
                    <label for="posisi" class="form-label block mb-2 font-medium text-gray-700">Posisi *</label>
                    <input type="text" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('posisi') border-red-500 @enderror" 
                           id="posisi" name="posisi" value="{{ old('posisi', $lowongan->posisi) }}" required>
                    @error('posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- TIPE PEKERJAAN --}}
                <div class="form-group mb-6">
                    <label for="tipe_pekerjaan" class="form-label block mb-2 font-medium text-gray-700">Tipe Pekerjaan *</label>
                    <select class="form-input w-full p-2 border border-gray-300 rounded-lg @error('tipe_pekerjaan') border-red-500 @enderror" 
                            id="tipe_pekerjaan" name="tipe_pekerjaan" required>
                        {{-- Menggunakan variabel $tipePekerjaan dari controller --}}
                        @foreach ($tipePekerjaan as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == $tipe ? 'selected' : '' }}>
                                {{ $tipe }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipe_pekerjaan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- LOKASI --}}
                <div class="form-group mb-6">
                    <label for="lokasi" class="form-label block mb-2 font-medium text-gray-700">Lokasi *</label>
                    <input type="text" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('lokasi') border-red-500 @enderror" 
                           id="lokasi" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required>
                    @error('lokasi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- GAJI MIN & MAX --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label for="gaji_min" class="form-label block mb-2 font-medium text-gray-700">Gaji Minimum (Rp)</label>
                        <input type="number" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('gaji_min') border-red-500 @enderror" 
                               id="gaji_min" name="gaji_min" value="{{ old('gaji_min', $lowongan->gaji_min) }}">
                        @error('gaji_min')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="gaji_max" class="form-label block mb-2 font-medium text-gray-700">Gaji Maksimum (Rp)</label>
                        <input type="number" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('gaji_max') border-red-500 @enderror" 
                               id="gaji_max" name="gaji_max" value="{{ old('gaji_max', $lowongan->gaji_max) }}">
                        @error('gaji_max')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                {{-- BATAS LAMARAN --}}
                <div class="form-group mb-6">
                    <label for="batas_lamaran" class="form-label block mb-2 font-medium text-gray-700">Batas Akhir Lamaran</label>
                    <input type="date" class="form-input w-full p-2 border border-gray-300 rounded-lg @error('batas_lamaran') border-red-500 @enderror" 
                           id="batas_lamaran" name="batas_lamaran" value="{{ old('batas_lamaran', $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('Y-m-d') : '') }}">
                    @error('batas_lamaran')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- DESKRIPSI (deskripsi) --}}
                <div class="form-group mb-6">
                    <label for="deskripsi" class="form-label block mb-2 font-medium text-gray-700">Deskripsi Pekerjaan *</label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[150px] @error('deskripsi') border-red-500 @enderror" 
                              id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- 🆕 KUALIFIKASI WAJIB (Menggunakan nama input baru: kualifikasi_wajib) --}}
                <div class="form-group mb-6">
                    <label for="kualifikasi_wajib" class="form-label block mb-2 font-medium text-gray-700">Kualifikasi Wajib *</label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[150px] @error('kualifikasi_wajib') border-red-500 @enderror" 
                              id="kualifikasi_wajib" name="kualifikasi_wajib" rows="5" required 
                              placeholder="Masukkan setiap kualifikasi WAJIB dalam baris baru (tekan Enter untuk poin berikutnya)..."
                    >{{ old('kualifikasi_wajib', $kualifikasiWajib) }}</textarea>
                    @error('kualifikasi_wajib')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- 🆕 KUALIFIKASI TAMBAHAN (Menggunakan nama input baru: kualifikasi_tambahan) --}}
                <div class="form-group mb-6">
                    <label for="kualifikasi_tambahan" class="form-label block mb-2 font-medium text-gray-700">Kualifikasi Tambahan</label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[150px] @error('kualifikasi_tambahan') border-red-500 @enderror" 
                              id="kualifikasi_tambahan" name="kualifikasi_tambahan" rows="5" 
                              placeholder="Masukkan kualifikasi tambahan/opsional jika ada (Pisahkan dengan Enter)..."
                    >{{ old('kualifikasi_tambahan', $kualifikasiTambahan) }}</textarea>
                    @error('kualifikasi_tambahan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- 🆕 SKILL DIBUTUHKAN (Menggunakan nama input baru: skill_dibutuhkan. Menggantikan field 'kualifikasi' lama) --}}
                <div class="form-group mb-6">
                    <label for="skill_dibutuhkan" class="form-label block mb-2 font-medium text-gray-700">Skill Dibutuhkan *</label>
                    <textarea class="form-input w-full p-2 border border-gray-300 rounded-lg resize-y min-h-[150px] @error('skill_dibutuhkan') border-red-500 @enderror" 
                              id="skill_dibutuhkan" name="skill_dibutuhkan" rows="5" required 
                              placeholder="Masukkan setiap skill yang benar-benar dibutuhkan dalam baris baru (tekan Enter untuk poin berikutnya)..."
                    >{{ old('skill_dibutuhkan', $skillDibutuhkan) }}</textarea>
                    @error('skill_dibutuhkan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                
                {{-- STATUS --}}
                <div class="form-group mb-5">
                    <label class="form-label block mb-2 font-medium text-slate-700" for="status">Status <span class="text-red-500">*</span></label>
                    <select class="form-input w-full p-2 border border-gray-300 rounded-lg @error('status') border-red-500 @enderror" id="status" name="status" required>
                        <option value="Aktif" {{ old('status', $lowongan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        {{-- Perbaikan: Ganti 'Nonaktif' menjadi 'Non-Aktif' --}}
                        <option value="Non-Aktif" {{ old('status', $lowongan->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="Ditutup" {{ old('status', $lowongan->status) == 'Ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    @error('status')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
            
                {{-- Tombol Aksi --}}
                <div class="action-buttons flex gap-2 justify-start">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection