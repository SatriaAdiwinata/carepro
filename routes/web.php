<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // <-- TAMBAHKAN INI

// Impor Controller Frontend
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\ApplicantController; // <<< TAMBAHKAN INI

use App\http\Controllers\HRDashboardController; 
use App\Http\Controllers\Perusahaan\LowonganController; 
use App\Http\Controllers\Perusahaan\LamaranMasukController; // <<< IMPOR BARU
use App\Http\Controllers\Perusahaan\DataKaryawanController; // <<< IMPOR INI
use App\Http\Controllers\Perusahaan\DashboardPerusahaanController; // <<< IMPOR BARU INI


// Impor Controller Admin
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;


/*
|--------------------------------------------------------------------------
| Rute Aplikasi Publik (Frontend)
|--------------------------------------------------------------------------
*/

// Rute Beranda Umum - DENGAN LOGIKA REDIREKSI BERDASARKAN PERAN
// PERBAIKAN: Menerima Request $request dan meneruskannya ke home()
Route::get('/', function (Request $request) { // <-- PERUBAHAN DI SINI
    if (Auth::check()) {
        $peran = Auth::user()->peran;
        
        // Arahkan berdasarkan peran pengguna yang sudah login
        if ($peran === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($peran === 'perusahaan') {
            return redirect()->route('perusahaan.dashboard'); 
        } else { // Asumsi peran 'pelamar'
            return redirect()->route('pengguna.dashboard');
        }
    }
    // Jika tidak terotentikasi, tampilkan halaman home publik dengan data berita
    return app(PublicController::class)->home($request); // <-- PERUBAHAN DI SINI
})->name('home');


// --- Rute Berita Publik ---

// Rute Daftar Berita (newsIndex)
Route::get('/berita', [PublicController::class, 'newsIndex'])
    // Nama rute ini harus digunakan di file Blade untuk pagination
    ->name('news.index'); 

// Rute Detail Berita (newsShow, menggunakan slug untuk SEO)
Route::get('/berita/{slug}', [PublicController::class, 'newsShow'])
    ->name('news.show');

// --- Rute Navigasi Statis Publik ---
Route::get('/about', function () {
    return view('navbar.about');
})->name('about');

Route::get('/kontak', function () {
    return view('navbar.kontak');
})->name('kontak');

// Rute untuk daftar semua lowongan publik (BARU)
Route::get('/lowongan-publik', [PublicController::class, 'lowonganIndex'])->name('public.lowongan.index');


// Rute untuk autentikasi (Login dan Registrasi)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); 

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute untuk Socialite (Login dengan Google/Facebook)
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

Route::get('/lowongan/{id}', [PublicController::class, 'lowonganShow'])->name('lowongan.show');
// ---
/*
|--------------------------------------------------------------------------
| Rute Yang Memerlukan Otentikasi (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
   Route::get('/lowongan', [PublicController::class, 'lowonganIndex'])->name('lowongan.index');
    
    // Dashboard Pengguna (Pelamar)
    Route::get('/dashboard-pengguna', [PublicController::class, 'penggunaDashboard'])->name('pengguna.dashboard');
    
    // RUTE BARU: Halaman Lamaran Saya
    Route::get('/lamaran-saya', [ApplicantController::class, 'index']) // <<< UBAH KE CONTROLLER
    ->name('lamaran.index');
    
    
    // Dashboard Perusahaan
    // Rute utama /perusahaan yang memiliki role check
    Route::get('/perusahaan', function () {
        if (Auth::user()->peran !== 'perusahaan') {
            return redirect()->route('pengguna.dashboard'); 
        }
        // MEMANGGIL CONTROLLER BARU, BUKAN view('perusahaan')
        return app(HRDashboardController::class)->dashboard(); 
    })->name('perusahaan.dashboard');
    
    // GRUP ROUTE UNTUK SUB-HALAMAN HR DASHBOARD
    Route::middleware(['auth', 'peran:perusahaan'])->group(function () {
    
    // Rute Dashboard HR (Ini rute duplikat, bisa dihapus, tapi jika dipertahankan biarkan saja)

    // GRUP ROUTE UNTUK SUB-HALAMAN HR DASHBOARD
    Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
        Route::get('/dashboard', [DashboardPerusahaanController::class, 'index'])->name('dashboard');
        // --- Halaman Profil ---
        Route::get('/profil-hr', [HRDashboardController::class, 'profil'])->name('profil'); 
        Route::put('/profil-hr', [HRDashboardController::class, 'updateProfil'])->name('profil.update');

        // --- Halaman Kelola Lowongan (MENGGUNAKAN RESOURCE ROUTE BARU) ---
        // Resource Route ini akan mencakup index, create, store, edit, update, destroy
        Route::resource('lowongan', LowonganController::class)->names('lowongan');

        // --- Halaman Lamaran Masuk ---
       Route::controller(LamaranMasukController::class)->group(function () {
                Route::get('/lamaran-masuk', 'index')->name('lamaran_masuk.index');
                Route::get('/lamaran-masuk/{id}', 'show')->name('lamaran_masuk.show'); 
                Route::put('/lamaran-masuk/{id}/update-status', 'updateStatus')->name('lamaran_masuk.update_status'); 
            });
                    Route::get('/data-karyawan', [DataKaryawanController::class, 'index'])->name('data-karyawan');
Route::delete('/data-karyawan/{id}', [DataKaryawanController::class, 'destroy'])->name('data-karyawan.destroy');
Route::get('/data-karyawan/{id}/detail', [DataKaryawanController::class, 'getDetail'])->name('data-karyawan.detail');

        // --- Halaman Pengaturan ---
        Route::get('/pengaturan', [HRDashboardController::class, 'pengaturan'])->name('pengaturan');
        Route::put('/pengaturan', function () { /* Logic update pengaturan */ })->name('pengaturan.update');
    });
    
});

    // RUTE PROFIL PENGGUNA UMUM (SHOW, EDIT, UPDATE)
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil.show');
    // PASTIKAN: Menggunakan nama 'profil.edit'
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit'); 
    // PASTIKAN: Menggunakan nama 'profil.update'
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profil.update');

    // Rute Logout Frontend
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// ===============================================
// Rute khusus untuk Backoffice Admin
// ===============================================
Route::prefix('backoffice')->group(function () {
    
    // Rute Login Admin (Hanya untuk Guest)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Rute yang dilindungi Admin (Membutuhkan Login DAN Role Admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // 1. Dashboard Utama
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // [Perbaikan dari Error Sebelumnya]: Menambahkan rute profil admin
        Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
        
        // 2. Resource Controllers
        Route::resource('jobs', JobController::class)->names('admin.jobs');
        Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
        Route::resource('companies', CompanyController::class)->names('admin.companies'); 
        
        // CRUD Berita
        Route::resource('news', NewsController::class)->names('admin.news');

        // 3. Rute Non-Resource
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');

        // 4. Pengaturan
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

        // 5. Data Dokter
        Route::controller(AdminController::class)->group(function () {
            Route::get('/data-dokter', 'dataDokter')->name('admin.data_dokter');
            Route::post('/data-dokter', 'storeDokter')->name('admin.data_dokter.store');
            Route::put('/data-dokter/{id}', 'updateDokter')->name('admin.data_dokter.update');
            Route::delete('/data-dokter/{id}', 'destroyDokter')->name('admin.data_dokter.destroy');
            
            // Rute update profil admin
            Route::put('/profile/update', 'updateProfile')->name('admin.profile.update');
        });

        // Route untuk menampilkan halaman detail perusahaan (frontend only dengan data dummy)
        Route::get('/companies/{id}', function ($id) {
            return view('admin.companies.show');
        })->name('companies.show');
        
        // 6. Log Out Admin
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});

Route::get('/lowongan/{id}', [PublicController::class, 'lowonganShow'])->name('lowongan.show');

// Route GET untuk menampilkan Form
// Menunjuk ke: resources/views/jobs/form.blade.php
Route::get('/lowongan/{id}/lamar', function ($id) {
    
    // Lowongan::findOrFail($id) akan mengembalikan 404 jika ID tidak ada
    $lowongan = App\Models\Lowongan::findOrFail($id); 
    
    // Kirim objek $lowongan ke view
    return view('jobs.form', [
        'id' => $lowongan->id, 
        'lowongan' => $lowongan // Objek lowongan untuk ditampilkan di form
    ]); 
})->name('jobs.form');

Route::post('/submit-lamaran', [LamaranController::class, 'submit'])->name('lamaran.submit');

// 2. Route GET untuk halaman sukses (Memanggil LamaranController@success)
Route::get('/lamaran-sukses', [LamaranController::class, 'success'])->name('lamaran.success');


