<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePro - @yield('title', 'Halaman Utama')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/logotab.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Alpine.js (untuk interaktivitas klik buka/tutup) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
    @stack('styles')

</head>
<body class="bg-gray-50 font-sans antialiased">
    <header class="fixed top-0 left-0 w-full z-50 gradient-bg text-white shadow-lg">
        <nav class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/carepro-logo.png') }}" alt="CarePro Logo" class="h-20 w-auto">
                </div>

                <div class="hidden md:flex space-x-6 items-center">
                    <a href="{{ url('/') }}" class="hover:text-purple-200 transition-colors">Beranda</a>
                    <a href="{{ url('/lowongan') }}" class="hover:text-purple-200 transition-colors">Lowongan</a>
                    
                    <div class="relative">
                        <button id="infoButton" onclick="toggleDropdown('infoDropdown', 'infoArrow')" class="flex items-center space-x-1 hover:text-purple-200 text-white focus:outline-none">
                            <span>Info</span>
                            <svg class="w-4 h-4 fill-current text-white transition-transform duration-200" id="infoArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/>
                            </svg>
                        </button>
                        <div id="infoDropdown" class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg text-gray-800 hidden z-50">
                            <a href="{{ url('/about') }}" class="block px-4 py-2 hover:bg-purple-100">Tentang Kami</a>
                            <a href="{{ url('/berita') }}" class="block px-4 py-2 hover:bg-purple-100">News & Events</a>
                        </div>
                    </div>
                    <a href="{{ url('/kontak') }}" class="hover:text-purple-200 transition-colors">Kontak Kami</a>
                </div>
                
                <div class="hidden md:flex space-x-3 items-center">
                    @guest
                        <a href="{{ route('login') }}" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-purple-800 px-4 py-2 rounded-lg font-semibold hover:bg-purple-900 transition-colors">Daftar</a>
                    @else
                        <div class="relative">
                            {{-- START: PERUBAHAN TOMBOL PROFIL --}}
                            <button id="profileButton" onclick="toggleDropdown('profileDropdown', 'profileArrow')" class="flex items-center space-x-2 hover:text-purple-200 text-white focus:outline-none">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.914A5.992 5.992 0 0110 16a5.992 5.992 0 014.546-2.086A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-base font-semibold">{{ Auth::user()->nama }}</span>
                                {{-- Ikon Panah Dropdown DITAMBAHKAN --}}
                                <svg class="w-4 h-4 fill-current text-white transition-transform duration-200" id="profileArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/>
                                </svg>
                            </button>
                            {{-- END: PERUBAHAN TOMBOL PROFIL --}}

                            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg text-gray-800 hidden z-50">
                                {{-- START: MENU LAMARAN SAYA --}}
                                <a href="{{ route('lamaran.index') }}" class="block px-4 py-2 hover:bg-purple-100">Lamaran Saya</a>
                                {{-- END: MENU LAMARAN SAYA --}}
                                
                                <a href="{{ route('profil.show') }}" class="block px-4 py-2 hover:bg-purple-100">Profil Saya</a>
                                <hr class="my-1">
                                <button type="button" onclick="showLogoutModal()" class="block w-full text-left px-4 py-2 hover:bg-red-100 text-red-600 font-semibold">
                                    Log out
                                </button>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" type="button" class="text-white hover:text-purple-200 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <div id="mobile-menu" class="hidden md:hidden w-full bg-purple-800 text-white">
            <div class="flex flex-col items-start px-6 py-4 space-y-2">
                <a href="{{ url('/') }}" class="block w-full py-2 hover:bg-purple-700">Beranda</a>
                <a href="{{ url('/lowongan') }}" class="block w-full py-2 hover:bg-purple-700">Lowongan</a>
                <a href="{{ url('/about') }}" class="block w-full py-2 hover:bg-purple-700">Tentang Kami</a>
                <a href="{{ url('/berita') }}" class="block w-full py-2 hover:bg-purple-700">News & Events</a>
                <a href="{{ url('/kontak') }}" class="block w-full py-2 hover:bg-purple-700">Kontak Kami</a>
                <hr class="w-full border-gray-600 my-2">
                @guest
                    <a href="{{ route('login') }}" class="block w-full py-2 text-center bg-white text-purple-600 rounded-lg font-semibold hover:bg-purple-50">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full py-2 text-center bg-purple-600 rounded-lg font-semibold hover:bg-purple-700">Daftar</a>
                @else
                    <a href="{{ route('lamaran.index') }}" class="block w-full py-2 hover:bg-purple-700">Lamaran Saya</a>
                    <a href="{{ route('profil.show') }}" class="block w-full py-2 hover:bg-purple-700">Profil Saya</a>
                    <button type="button" onclick="showLogoutModal()" class="block w-full text-left px-4 py-2 hover:bg-red-100 text-red-600 font-semibold">
                        Log out
                    </button>
                @endguest
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    
    <div id="logout-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Keluar</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin keluar dari akun ini?</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="modal-close" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-300 transition-colors">Batal</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" id="modal-logout-button" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 hover:bg-red-700 transition-colors">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Contact Button -->
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50" x-cloak>
        <!-- Tombol utama -->
        <button @click="open = !open"
            class="bg-indigo-700 hover:bg-indigo-800 text-white rounded-full p-5 shadow-lg transition transform hover:scale-110 focus:outline-none">
            <template x-if="!open">
                <i class="fas fa-comments text-2xl"></i>
            </template>
            <template x-if="open">
                <i class="fas fa-times text-2xl"></i>
            </template>
        </button>

        <!-- Popup menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-3"
            class="absolute bottom-20 right-0 bg-white rounded-xl shadow-xl p-4 w-60">

            <!-- Email -->
            <div class="flex items-center space-x-3 mb-3 hover:bg-gray-50 p-2 rounded-lg transition">
                <div class="bg-orange-500 text-white p-2 rounded-full">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="medianaangga2@gmail.com" class="text-gray-700 font-medium hover:text-indigo-700">Email</a>
            </div>

            <!-- WhatsApp -->
            <div class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition">
                <div class="bg-green-500 text-white p-2 rounded-full">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <a href="https://wa.me/6281338341344" target="_blank"
                    class="text-gray-700 font-medium hover:text-indigo-700">WhatsApp</a>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('images/logologin.png') }}" alt="CarePro Logo"
                        class="h-10 w-10 object-contain">
                    <h4 class="text-xl font-bold">CarePro</h4>
                </div>

                <p class="text-gray-400">Platform pencarian kerja terpercaya untuk menghubungkan talenta dengan
                    peluang terbaik.</p>
            </div>

            <div>
                <h5 class="font-semibold mb-4 md:ml-10">Untuk Pencari Kerja</h5>
                <ul class="space-y-2 text-gray-400 md:ml-10">
                    <li><a href="#" class="hover:text-white">Cari Lowongan</a></li>
                    <li><a href="#" class="hover:text-white">Buat CV</a></li>
                    <li><a href="#" class="hover:text-white">Tips Karir</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-semibold mb-4 md:ml-8">Untuk Perusahaan</h5>
                <ul class="space-y-2 text-gray-400 md:ml-8">
                    <li><a href="#" class="hover:text-white">Post Lowongan</a></li>
                    <li><a href="#" class="hover:text-white">Cari Kandidat</a></li>
                    <li><a href="#" class="hover:text-white">Paket Premium</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-semibold mb-4">Ikuti Kami</h5>
                <div class="flex space-x-4">
                    <a href="#"
                        class="bg-gray-600 hover:bg-gray-500 text-white w-10 h-10 flex items-center justify-center rounded-full transition">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#"
                        class="bg-gray-600 hover:bg-gray-500 text-white w-10 h-10 flex items-center justify-center rounded-full transition">
                        <i class="fab fa-tiktok text-lg"></i>
                    </a>
                    <a href="#"
                        class="bg-gray-600 hover:bg-gray-500 text-white w-10 h-10 flex items-center justify-center rounded-full transition">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2025 CarePro. All rights reserved.</p>
        </div>
    </div>
</footer>

    <script>
        function toggleDropdown(dropdownId, arrowId) {
            const dropdown = document.getElementById(dropdownId);
            const arrow = arrowId ? document.getElementById(arrowId) : null;
            dropdown.classList.toggle('hidden');
            if (arrow) {
                // Tambahkan atau hapus class 'rotate-180' pada panah
                arrow.classList.toggle('rotate-180');
            }
        }

        function showLogoutModal() {
            document.getElementById('logout-modal').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Logika untuk menutup dropdown saat mengklik di luar area
            document.addEventListener('click', function(event) {
                const infoDropdown = document.getElementById('infoDropdown');
                const profileDropdown = document.getElementById('profileDropdown');
                const infoButton = document.getElementById('infoButton');
                const profileButton = document.getElementById('profileButton');

                // Jika klik di luar dropdown "Info" dan tombolnya
                if (infoDropdown && !infoDropdown.contains(event.target) && infoButton && !infoButton.contains(event.target)) {
                    infoDropdown.classList.add('hidden');
                    document.getElementById('infoArrow').classList.remove('rotate-180');
                }

                // Jika klik di luar dropdown "Profil" dan tombolnya
                if (profileDropdown && !profileDropdown.contains(event.target) && profileButton && !profileButton.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                    
                    // START: LOGIKA RESET PANAH PROFIL DITAMBAHKAN
                    const profileArrow = document.getElementById('profileArrow');
                    if (profileArrow) {
                        profileArrow.classList.remove('rotate-180');
                    }
                    // END: LOGIKA RESET PANAH PROFIL DITAMBAHKAN
                }
            });

            // Mendengarkan klik pada tombol menu seluler
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Logika untuk modal logout
            const modalCloseButton = document.getElementById('modal-close');
            if (modalCloseButton) {
                modalCloseButton.addEventListener('click', function() {
                    document.getElementById('logout-modal').classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>