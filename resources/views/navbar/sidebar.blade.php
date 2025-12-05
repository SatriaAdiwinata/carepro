{{-- INI SIDEBAR UNTUK DASHBOARD ADMIN PERUSAHAAN --}}
<!-- HAMBURGER MENU -->
<div class="hamburger" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>
<div class="sidebar">
    <div class="logo">
        <h2 style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/logologin.png') }}"
                alt="CarePro Logo"
                style="width: 45px; height: 45px;">
            CarePro
        </h2>

        <span>HR Management</span>
    </div>

    <nav class="nav-menu">
        {{-- Ganti div dengan <a> dan gunakan route Laravel --}}

        {{-- Dashboard --}}
        <a href="{{ route('perusahaan.dashboard') }}"
            {{-- Menggunakan Route::is() untuk pengecekan eksak route dashboard --}}
            class="nav-item {{ Route::is('perusahaan.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        {{-- Kelola Lowongan --}}
        {{-- **PERBAIKAN ADA DI SINI** --}}
        <a href="{{ route('perusahaan.lowongan.index') }}"
            class="nav-item {{ Route::is('perusahaan.lowongan.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Kelola Lowongan</span>
        </a>

        {{-- Lamaran Masuk --}}
        <a href="{{ route('perusahaan.lamaran_masuk.index') }}"
            class="nav-item {{ Route::is('perusahaan.lamaran_masuk') ? 'active' : '' }}">
            <i class="fas fa-inbox"></i>
            <span>Lamaran Masuk</span>
        </a>

        {{-- Data Karyawan (MENU BARU) --}}
        <a href="{{ route('perusahaan.data-karyawan') }}"
            class="nav-item {{ Route::is('perusahaan.data-karyawan') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i>
            <span>Data Karyawan</span>
        </a>

        {{-- Pengaturan --}}
        <a href="{{ route('perusahaan.pengaturan') }}"
            class="nav-item {{ Route::is('perusahaan.pengaturan') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>

        {{-- Profil HR --}}
        <a href="{{ route('perusahaan.profil') }}"
            class="nav-item {{ Route::is('perusahaan.profil') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profil HR</span>
        </a>
    </nav>


    {{-- TOMBOL LOGOUT --}}
<div class="logout-section" style="padding: 20px 0;">
    <a href="#" 
       class="nav-item"
       onclick="event.preventDefault(); confirmLogoutPopup();">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
</div>


</div>