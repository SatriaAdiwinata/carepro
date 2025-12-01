@extends('admin.layouts.app') 

@section('title', 'Tambah Berita Baru')

@section('content')

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">Buat Berita/Artikel Baru</h3>
        
        {{-- Form Tambah Berita --}}
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Berita/Artikel</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-primary focus:border-primary @error('judul') border-red-500 @enderror" 
                       placeholder="Masukkan judul berita" required>
                @error('judul')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten Berita</label>
                {{-- Gunakan Textarea dan Editor (misalnya Trix/TinyMCE) untuk konten kaya --}}
                <textarea name="konten" id="konten" rows="10" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 @error('konten') border-red-500 @enderror" 
                          placeholder="Tuliskan isi berita di sini..." required>{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama (Opsional)</label>
                <input type="file" name="gambar" id="gambar" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100"
                       aria-describedby="gambar_help">
                <p id="gambar_help" class="mt-1 text-xs text-gray-500">JPG, PNG, atau JPEG (maks 2MB).</p>
                @error('gambar')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-save mr-1"></i> Simpan Berita
                </button>
            </div>
        </form>
    </div>

@endsection