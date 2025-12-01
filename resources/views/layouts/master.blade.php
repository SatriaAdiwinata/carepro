<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePro - @yield('title', 'Dashboard HR')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logotab.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* START: CSS INLINE DARI FILE ASLI */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo h2 {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            font-size: 14px;
            opacity: 0.9;
            display: block;
            margin-top: 5px;
            font-weight: 400;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            text-decoration: none;
            /* Menghapus garis bawah */
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
        }

        .nav-item i {
            font-size: 18px;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            color: #1e293b;
        }

        /* === POPUP LOGOUT ONLY === */
        .logout-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.60);
            backdrop-filter: blur(3px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .logout-popup-box {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            width: 320px;
            text-align: center;
            color: #000;
            animation: logout-popup-show 0.25s ease-out;
        }

        .logout-popup-box h3 {
            margin-bottom: 8px;
            font-size: 18px;
            font-weight: 600;
        }

        .logout-popup-box p {
            margin-bottom: 15px;
            color: #8D8D8D;
            font-size: 14px;
        }

        .logout-popup-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .logout-cancel,
        .logout-confirm {
            flex: 1;
            padding: 10px 0;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.25s;
        }

        .logout-cancel {
            background: #333;
            color: #fff;
        }

        .logout-cancel:hover {
            background: #444;
        }

        .logout-confirm {
            background: #ff4a4a;
            color: white;
        }

        .logout-confirm:hover {
            background: #e63939;
        }

        @keyframes logout-popup-show {
            from {
                transform: scale(0.85);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }


        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-card:nth-child(4) .stat-icon {
            background: #fce7f3;
            color: #db2777;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
        }

        /* Content Sections */
        /* display: none; pada original HTML dihilangkan di sini karena setiap view hanya merender satu section */
        .content-section.active {
            display: block;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        tr:hover {
            background: #f8fafc;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-active {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #334155;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea.form-input {
            font-family: inherit;
            min-height: 100px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        /* Profile Section */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: 600;
        }

        .profile-info h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .profile-info p {
            color: #64748b;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-row {
            padding: 18px;
            background: #e7f3ff;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #d9dee4;
        }

        .info-label {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .info-value {
            color: #1e293b;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-active { background: #dcfce7; color: #16a34a; }
        .badge-inactive { background: #fee2e2; color: #dc2626; }
        .badge-pending { background: #fef3c7; color: #d97706; }

        /* HAMBURGER MENU */
        .hamburger {
            display: none;
            position: fixed;
            top: 18px;
            left: 18px;
            font-size: 28px;
            color: rgb(7, 7, 7);
            z-index: 2000;
            cursor: pointer;
        }

        /* MOBILE MODE */
        @media (max-width: 768px) {

            /* Tombol hamburger tampil */
            .hamburger {
                display: block;
            }

            /* Sidebar disembunyikan */
            .sidebar {
                transform: translateX(-260px);
                transition: 0.3s;
            }

            /* Sidebar muncul ketika diberi class .active */
            .sidebar.active {
                transform: translateX(0);
            }

            /* Konten tetap di kiri saat mobile */
            .main-content {
                margin-left: 0;
            }
        }


        /* END: CSS INLINE DARI FILE ASLI */
    </style>
    @stack('styles')
</head>

<body>
    <div class="container">
        {{-- Pastikan Anda memiliki file sidebar.blade.php di folder navbar --}}
        @include('navbar.sidebar')

        <div class="main-content">
            <div class="header">
                <h1 id="page-title">@yield('page-title', 'Dashboard')</h1>
                <div class="user-info">
                    <div>
                        <div style="font-weight: 600;">{{ $namaPerusahaan }}</div>
                        <div style="font-size: 13px; color: #64748b;">HR Manager</div>
                    </div>
                    {{-- Asumsi $namaPerusahaan sudah dikirim dari Controller --}}
                    <div class="user-avatar">{{ substr($namaPerusahaan, 0, 2) }}</div>
                </div>
            </div>


            @yield('content')
        </div>
    </div>

    <div id="logout-popup" class="logout-popup-overlay">
        <div class="logout-popup-box">
            <h3>Konfirmasi Logout</h3>
            <p>Anda yakin ingin keluar?</p>

            <div class="logout-popup-buttons">
                <button class="logout-cancel" onclick="closeLogoutPopup()">Batal</button>
                <button class="logout-confirm" onclick="submitLogoutForm()">Logout</button>
            </div>
        </div>
    </div>

    {{-- Form tersembunyi untuk proses logout POST --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    {{-- Script JS umum untuk form dan scroll --}}
    <script>
        // --- FUNGSI NAVIGASI DAN UMUM ---

        /**
         * Fungsi ini BISA DIHAPUS jika Anda menggunakan navigasi penuh Laravel (bukan SPA).
         * Saat ini dibiarkan untuk kompatibilitas.
         */
        function showSection(sectionId, event) {
            // Sembunyikan semua bagian konten
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Hapus class 'active' dari semua item navigasi
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.classList.remove('active');
            });

            // Tampilkan bagian konten yang dipilih
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.add('active');
            }

            // Tambahkan class 'active' ke item navigasi yang diklik
            if (event && event.target) {
                const clickedNavItem = event.target.closest('.nav-item');
                if (clickedNavItem) {
                    clickedNavItem.classList.add('active');
                }
            }

            // Perbarui judul halaman di header
            const titles = {
                'dashboard': 'Dashboard',
                'kelola-lowongan': 'Kelola Lowongan',
                'lamaran-masuk': 'Lamaran Masuk',
                'karyawan': 'Data Karyawan',
                'pengaturan': 'Pengaturan',
                'profil': 'Profil HR'
            };
            const pageTitleElement = document.getElementById('page-title');
            if (pageTitleElement) {
                pageTitleElement.textContent = titles[sectionId] || sectionId;
            }
        }

        /**
         * Menampilkan form tambah lowongan dan menggulirkan halaman.
         * Fungsi ini juga bisa dihapus karena sudah diganti dengan navigasi route Laravel.
         */
        function showAddJobForm() {
            const formElement = document.getElementById('add-job-form');
            if (formElement) {
                formElement.style.display = 'block';
                window.scrollTo({
                    top: formElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        }

        /**
         * Menyembunyikan form tambah lowongan.
         * Fungsi ini juga bisa dihapus karena sudah diganti dengan navigasi route Laravel.
         */
        function hideAddJobForm() {
            const formElement = document.getElementById('add-job-form');
            if (formElement) {
                formElement.style.display = 'none';
            }
        }

        // --- INITALISASI DAN EVENT LISTENERS ---
        document.addEventListener('DOMContentLoaded', function() {

            //  Inisialisasi Tampilan Dashboard (Hanya berfungsi jika menggunakan SPA)
            const initialNavItem = document.querySelector('.nav-item[onclick*="dashboard"]');
            if (initialNavItem) {
                // Panggil showSection dengan event dummy untuk mengaktifkan item menu
                showSection('dashboard', {
                    target: initialNavItem
                });
            }

            // =========================================================================
            // PERBAIKAN PENTING: KODE DEMO FORM SUBMISSION DINONAKTIFKAN/DIHAPUS
            // =========================================================================
            /*
            //  Event Listener untuk Form Submission (Pencegahan default & menggunakan console.log pengganti alert())
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // BARIS INI DINONAKTIFKAN!
                    console.log('Form disubmit. Data berhasil disimpan! (Mode Demo)');

                    // Sembunyikan form tambah lowongan jika itu yang disubmit
                    if (form.closest('#add-job-form')) {
                        hideAddJobForm();
                    }
                });
            });
            */
            // =========================================================================

            //  Tambahkan fungsi ke global scope (agar bisa dipanggil dari HTML)
            window.showSection = showSection;
            window.showAddJobForm = showAddJobForm;
            window.hideAddJobForm = hideAddJobForm;
        });

        //  POP UP LOGOUT
        function confirmLogoutPopup() {
            document.getElementById('logout-popup').style.display = 'flex';
        }

        function closeLogoutPopup() {
            document.getElementById('logout-popup').style.display = 'none';
        }

        function submitLogoutForm() {
            // Mengirim form logout tersembunyi
            document.getElementById('logout-form').submit();
        }

        //  Hamburger Menu
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>