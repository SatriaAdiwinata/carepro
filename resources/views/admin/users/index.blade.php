@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Kelola Pengguna</h3>
                {{-- Tombol Tambah Pengguna Baru (Dihapus/Dinonaktifkan sesuai diskusi) --}}
            </div>
            
            <div class="p-6">
                {{-- Bagian Notifikasi (success, info, error) --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">{{ session('success') }}</span></div>
                @endif
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">{{ session('info') }}</span></div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><span class="block sm:inline">{{ session('error') }}</span></div>
                @endif
                
                <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="relative w-full md:w-1/3">
                            <input type="text" name="search" id="search" placeholder="Cari berdasarkan nama atau email..." 
                                   value="{{ request('search') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-10 pr-4 py-2">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.195l4.303 4.303a1 1 0 01-1.414 1.414l-4.303-4.303A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Nama</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Email</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Peran (Tipe)</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Bergabung</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-900">{{ $user->nama }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @php
                                        // Logika untuk menampilkan badge Peran (Tipe)
                                        $role_map = [
                                            'perusahaan' => ['label' => 'Perusahaan', 'color' => 'purple'],
                                            'pelamar' => ['label' => 'Pencari Kerja', 'color' => 'blue'],
                                        ];
                                        $current_role = $role_map[$user->peran] ?? ['label' => 'Tidak Diketahui', 'color' => 'gray']; 
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium text-{{ $current_role['color'] }}-800 bg-{{ $current_role['color'] }}-100 rounded-full">
                                        {{ $current_role['label'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td> 
                                
                                
                                
                                <td class="py-4 px-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Detail</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-4 text-center text-gray-500">Tidak ada data pengguna yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection