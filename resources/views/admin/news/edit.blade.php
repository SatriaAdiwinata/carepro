@extends('admin.layouts.app') 

@section('title', 'Edit Berita: ' . $news->judul)

@section('content')

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">Edit Berita/Artikel</h3>
        
        {{-- Form Edit Berita --}}
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Penting untuk metode Update --}}

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Berita/Artikel</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $news->judul) }}" 
                       class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-primary focus:border-primary @error('judul') border-red-500 @enderror" 
                       placeholder="Masukkan judul berita" required>
                @error('judul')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten Berita</label>
                <textarea name="konten" id="konten" rows="10" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2.5 @error('konten') border-red-500 @enderror" 
                          placeholder="Tuliskan isi berita di sini..." required>{{ old('konten', $news->konten) }}</textarea>
                @error('konten')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama</label>
                
                {{-- Tampilkan gambar yang ada saat ini --}}
                @if ($news->gambar)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Gambar Saat Ini:</p>
                        <img src="{{ Storage::url($news->gambar) }}" alt="Gambar Berita Saat Ini" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                @endif
                
                <input type="file" name="gambar" id="gambar" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100"
                       aria-describedby="gambar_help">
                <p id="gambar_help" class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar. JPG, PNG, atau JPEG (maks 2MB).</p>
                @error('gambar')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-save mr-1"></i> Perbarui Berita
                </button>
            </div>
        </form>
    </div>

@endsection