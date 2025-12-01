<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Menggunakan @yield('title') agar judul bisa diganti per halaman --}}
    <title>@yield('title', 'Halaman Admin') - CarePro</title> 
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurasi Tailwind untuk warna kustom
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',   // Biru Utama
                        secondary: '#1E40AF', // Biru Tua
                        accent: '#F59E0B'     // Kuning/Orange
                    }
                }
            }
        }
    </script>
    <style>
        /* CSS untuk menandai link Sidebar yang aktif */
        .sidebar-link.active {
            background-color: #DBEAFE; /* blue-100 */
            color: #1E40AF; /* secondary color for text */
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out" id="sidebar">
        <div class="flex items-center justify-center h-16 bg-primary">
            <h1 class="text-xl font-bold text-white">CarePro Admin</h1>
        </div>
        
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                
                {{-- Dashboard: Route 'admin.dashboard' --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.dashboard')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path></svg>
                    Dashboard
                </a>
                
                {{-- Kelola Lowongan: Route 'admin.jobs.*' --}}
                <a href="{{ route('admin.jobs.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.jobs.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    Daftar Lowongan
                </a>
                
                {{-- Pengguna: Route 'admin.users.*' --}}
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.users.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    Pengguna
                </a>
                
                {{-- Perusahaan: Route 'admin.companies.*' --}}
                <a href="{{ route('admin.companies.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.companies.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path></svg>
                    Perusahaan
                </a>
                
                {{-- Kelola Berita: Route 'admin.news.*' --}}
                <a href="{{ route('admin.news.index') }}"
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.news.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V9a1 1 0 00-1-1h-1v4.5a1.5 1.5 0 01-3 0V7z"></path></svg>
                    Kelola Berita
                </a>
                
                {{-- Pengaturan: Route 'admin.settings.*' --}}
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 sidebar-link 
                   @if(request()->routeIs('admin.settings.*')) active @endif">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    Account
                </a>

            </div>
        </nav>
    </div>
    
    <div class="ml-64 p-4 min-h-screen">
        
        <header class="bg-white shadow-md p-4 flex justify-between items-center rounded-lg mb-4">
            <h1 class="text-2xl font-semibold text-gray-800">
                @yield('title', 'Halaman Admin') {{-- Menampilkan judul halaman --}}
            </h1>
            
            <div class="relative">
        <button id="logoutButton" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none" aria-expanded="false" aria-haspopup="true">
            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                <span class="text-white text-sm font-medium">A</span>
            </div>
            <span class="text-sm font-medium">Admin</span>
        </button>

                <div id="logoutDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-50 py-1 hidden">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-4 bg-white rounded-lg shadow-md">
            @yield('content') {{-- <--- INI ADALAH TEMPAT KONTEN DISUNTIKKAN --}}
        </main>
    </div>
    
    <script>
        // Script untuk mengendalikan dropdown Logout
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.getElementById('logoutButton');
            const logoutDropdown = document.getElementById('logoutDropdown');

            if (logoutButton && logoutDropdown) {
                logoutButton.addEventListener('click', function(e) {
                    e.stopPropagation(); // Mencegah event mencapai window click
                    logoutDropdown.classList.toggle('hidden');
                });

                // Tutup dropdown jika user klik di luar
                window.addEventListener('click', function(e) {
                    if (!logoutButton.contains(e.target) && !logoutDropdown.contains(e.target)) {
                        logoutDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

</body>
</html>