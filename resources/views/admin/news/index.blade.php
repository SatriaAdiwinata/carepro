@extends('admin.layouts.app')

@section('title', 'Kelola Berita & Artikel')

@section('content')

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Kelola Berita & Artikel</h3>
                {{-- Arahkan ke rute create --}}
                <a href="{{ route('admin.news.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-plus mr-1"></i> Tambah Berita
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($news->isEmpty())
                <p class="text-center text-gray-500">Belum ada berita yang tersedia.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    {{-- Ulangi untuk setiap berita --}}
                    @foreach ($news as $item)
                        <div class="border border-gray-200 rounded-lg overflow-hidden flex flex-col">
                            <div class="h-48">
                                {{-- Tampilkan gambar atau placeholder --}}
                                @if ($item->gambar)
                                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-2 text-xs mb-2">
                                        {{-- Anda bisa memodifikasi badge ini sesuai status publish jika ada --}}
                                        <span class="px-2 py-1 font-medium text-yellow-800 bg-yellow-100 rounded-full">Dipublikasikan</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h4>
                                    {{-- Tampilkan sebagian konten --}}
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                                </div>

                                <div class="text-xs text-gray-500 mb-3">
                                    <span>📅 {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                                </div>
                                
                                <div class="flex space-x-2 mt-auto">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="flex-1 text-center px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    
                                    {{-- Tombol Delete --}}
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini? Aksi ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-1 text-xs bg-red-100 text-red-800 rounded hover:bg-red-200 transition-colors">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection