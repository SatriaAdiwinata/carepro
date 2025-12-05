@extends('layouts.app')

@section('content')
    @push('styles')
        {{-- Memuat style yang sama dengan halaman detail pekerjaan --}}
        <link rel="stylesheet" href="{{ asset('css/form.css') }}"> 
        {{-- Anda perlu memastikan file form.css ada di public/css --}}
    @endpush

    <div class="container form-page-wrapper">
        {{-- Menampilkan pesan sukses atau error dari Controller --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="header-section">
            <div class="header-image">
                <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400" alt="Person writing">
            </div>
            <div class="header-text">
                <h1>Form Lamaran Pekerjaan</h1>
                <p>Anda melamar untuk posisi: **{{ $lowongan->posisi ?? 'Tidak Diketahui' }}**.</p>
                <p>Isi form berikut untuk melamar pekerjaan melalui platform CarePro. Pastikan data yang Anda masukkan sudah benar.</p>
            </div>
        </div>

        <div class="form-section">
            <form action="{{ route('lamaran.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- PENTING: Hidden Input untuk mengirim ID Lowongan ke Controller --}}
            <input type="hidden" name="lowongan_id" value="{{ $lowongan->id ?? '' }}">

            <h2 class="section-title">Data Pribadi</h2>
            
            {{-- Catatan: Nama Depan tidak ada di tabel lamaran, tapi tetap dipertahankan dari form asli --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Depan <span class="required">*</span></label>
                    {{-- Diisi dengan 'old' value --}}
                    <input type="text" name="nama_depan" placeholder="Masukkan nama depan" value="{{ old('nama_depan') }}" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap', Auth::user()->nama ?? '') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="contoh@email.com" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon <span class="required">*</span></label>
                    <input type="tel" name="nomor_telepon" placeholder="081234567890" value="{{ old('nomor_telepon') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin <span class="required">*</span></label>
                    <select name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Alamat <span class="required">*</span></label>
                <textarea name="alamat" placeholder="Masukkan alamat lengkap Anda" required>{{ old('alamat') }}</textarea>
            </div>

            <h2 class="section-title" style="margin-top: 2rem;">Pendidikan & Pengalaman</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir <span class="required">*</span></label>
                    <select name="pendidikan_terakhir" required>
                        <option value="">Pilih pendidikan</option>
                        <option value="sma" {{ old('pendidikan_terakhir') == 'sma' ? 'selected' : '' }}>SMA/SMK</option>
                        <option value="d3" {{ old('pendidikan_terakhir') == 'd3' ? 'selected' : '' }}>D3</option>
                        <option value="s1" {{ old('pendidikan_terakhir') == 's1' ? 'selected' : '' }}>S1</option>
                        <option value="s2" {{ old('pendidikan_terakhir') == 's2' ? 'selected' : '' }}>S2</option>
                        <option value="s3" {{ old('pendidikan_terakhir') == 's3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jurusan <span class="required">*</span></label>
                    <input type="text" name="jurusan" placeholder="Contoh: Teknik Informatika" value="{{ old('jurusan') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Universitas (Opsional)</label>
                    <input type="text" name="universitas" placeholder="Nama universitas" value="{{ old('universitas') }}">
                </div>
                <div class="form-group">
                    <label>Tahun Lulus <span class="required">*</span></label>
                    <input type="number" name="tahun_lulus" placeholder="YYYY" min="1950" max="2030" value="{{ old('tahun_lulus') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>IPK (Opsional)</label>
                    <input type="text" name="ipk" placeholder="Contoh: 3.75" value="{{ old('ipk') }}">
                </div>
                <div class="form-group">
                    <label>Posisi yang Dilamar <span class="required">*</span></label>
                    <select name="posisi_dilamar" required>
                        <option value="">Pilih posisi</option>
                        {{-- Menggunakan posisi lowongan sebagai default/pilihan utama --}}
                        <option value="{{ $lowongan->posisi ?? '' }}" selected>{{ $lowongan->posisi ?? 'Posisi Lowongan' }}</option>
                        {{-- Tambahkan pilihan lain jika diperlukan --}}
                        <option value="developer" {{ old('posisi_dilamar') == 'developer' ? 'selected' : '' }}>Software Developer</option>
                        <option value="designer" {{ old('posisi_dilamar') == 'designer' ? 'selected' : '' }}>UI/UX Designer</option>
                        <option value="marketing" {{ old('posisi_dilamar') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="hr" {{ old('posisi_dilamar') == 'hr' ? 'selected' : '' }}>Human Resources</option>
                        <option value="sales" {{ old('posisi_dilamar') == 'sales' ? 'selected' : '' }}>Sales</option>
                    </select>
                </div>
            </div>

            <div class="form-group full-width">
                <label>Pengalaman Kerja (Opsional)</label>
                <textarea name="pengalaman_kerja" placeholder="Jelaskan pengalaman kerja relevan Anda">{{ old('pengalaman_kerja') }}</textarea>
            </div>
            
            {{-- BARU: Input Teks Surat Pengantar, sesuai dengan kolom 'surat_pengantar' di DB --}}
            <div class="form-group full-width">
                <label>Surat Pengantar / Motivasi (Teks, Opsional)</label>
                <textarea name="surat_pengantar" placeholder="Tuliskan surat pengantar atau motivasi Anda di sini">{{ old('surat_pengantar') }}</textarea>
            </div>

            <h2 class="section-title" style="margin-top: 2rem;">Upload Berkas</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Upload CV (PDF, max 2MB) <span class="required">*</span></label>
                    {{-- Tambahkan class 'uploaded' jika ada old file path untuk feedback visual --}}
                    <label for="cv-upload" class="upload-area {{ old('cv_file') ? 'uploaded' : '' }}">
                        <div class="upload-icon">☁️</div>
                        <div class="upload-text">{{ old('cv_file') ? 'File siap diupload/diperbarui' : 'Klik untuk upload atau seret' }}</div>
                    </label>
                    <input type="file" id="cv-upload" name="cv_file" accept=".pdf" {{ old('cv_file') ? '' : 'required' }}> 
                    <small class="text-info">Hanya PDF. Maksimal 2MB. Jika Anda mengedit, file harus diupload ulang.</small>
                </div>
                <div class="form-group">
                    <label>Upload Surat Lamaran (PDF/File, Opsional)</label>
                    <label for="cover-letter-upload" class="upload-area {{ old('cover_letter') ? 'uploaded' : '' }}">
                        <div class="upload-icon">☁️</div>
                        <div class="upload-text">{{ old('cover_letter') ? 'File siap diupload/diperbarui' : 'Klik untuk upload atau seret' }}</div>
                    </label>
                    <input type="file" id="cover-letter-upload" name="cover_letter" accept=".pdf">
                    <small class="text-info">Hanya PDF. Maksimal 2MB.</small>
                </div>
            </div>

            <div class="submit-section">
                <button type="submit" class="btn-submit">Kirim Lamaran</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk memperbarui teks label upload
        function updateUploadLabel(inputId, textContent) {
            const input = document.getElementById(inputId);
            const label = input.parentElement.querySelector('.upload-area');
            const uploadText = label.querySelector('.upload-text');

            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                uploadText.textContent = fileName;
                label.classList.add('uploaded');
            } else {
                uploadText.textContent = textContent;
                label.classList.remove('uploaded');
            }
        }
        
        // Listener untuk CV
        const cvUpload = document.getElementById('cv-upload');
        cvUpload.addEventListener('change', function(e) {
            updateUploadLabel('cv-upload', 'Klik untuk upload atau seret');
        });

        // Listener untuk Surat Lamaran
        const coverLetterUpload = document.getElementById('cover-letter-upload');
        coverLetterUpload.addEventListener('change', function(e) {
            updateUploadLabel('cover-letter-upload', 'Klik untuk upload atau seret');
        });

        // Inisialisasi status upload saat page load (jika menggunakan old input)
        document.addEventListener('DOMContentLoaded', function() {
            // Jika ada file yang sebelumnya di-upload (walaupun harus diupload ulang), ini akan menampilkan teks default
            updateUploadLabel('cv-upload', 'Klik untuk upload atau seret');
            updateUploadLabel('cover-letter-upload', 'Klik untuk upload atau seret');
        });
    </script>
@endsection