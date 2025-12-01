@extends('layouts.master')

@section('title', 'Profil HR')
@section('page-title', 'Profil HR')

@section('content')

{{-- Style CSS Khusus untuk Modal (Pop-up) --}}
<style>
    /* Styling Dasar Modal */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 10000; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6); 
    }

    /* Konten Modal */
    .modal-content {
        background-color: #ffffff;
        margin: 10% auto; 
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); 
        position: relative;
        animation: animatetop 0.4s; 
    }

    /* Animasi Pop-up */
    @keyframes animatetop {
        from {top: -300px; opacity: 0}
        to {top: 10%; opacity: 1}
    }

    /* Tombol Tutup (X) */
    .close-btn {
        color: #aaa;
        float: right;
        font-size: 36px;
        font-weight: normal;
        cursor: pointer;
        line-height: 0;
        position: absolute;
        top: 10px;
        right: 15px;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #333;
        text-decoration: none;
    }
    
    .modal-content h3 {
        margin-top: 10px;
        color: #10B981; 
        font-size: 24px;
    }

    .modal-icon {
        font-size: 48px;
        color: #10B981;
        margin-bottom: 15px;
    }
</style>

{{-- Struktur Modal Pop-up Sukses --}}
<div id="successModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <div class="modal-icon"><i class="fas fa-check-circle"></i></div>
    <h3>Berhasil!</h3>
    <p id="modalMessage" style="font-size: 16px; margin-bottom: 25px;">Profil perusahaan berhasil diperbarui!</p>
    <button class="btn btn-primary" onclick="closeModal()" style="padding: 10px 30px;">OK</button>
  </div>
</div>


{{-- Tampilkan Error Validasi Form --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="profil" class="content-section active">

    {{-- Bagian VIEW (Tampilan Profil) --}}
    <div id="profil-view" class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title">Profil Perusahaan</h3>
            <button class="btn btn-primary" onclick="editProfil()">
                <i class="fas fa-edit"></i> Edit Profil
            </button>
        </div>

        <div class="profile-header">
            <div class="profile-avatar">
                {{-- Tampilkan Logo jika ada, jika tidak, tampilkan inisial --}}
                @if ($perusahaan && $perusahaan->logo)
                    <img src="{{ asset('storage/logos/' . $perusahaan->logo) }}" alt="Logo Perusahaan" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    {{ strtoupper(substr($namaPerusahaan ?? 'TM', 0, 2)) }}
                @endif
            </div>
            <div class="profile-info">
                <h2>{{ $namaPerusahaan ?? 'PT. Teknologi Maju' }}</h2>
                <p>{{ $bidangIndustri ?? 'Perusahaan Teknologi Informasi' }}</p>
                <span class="badge badge-{{ $perusahaan ? 'active' : 'inactive' }}">{{ $perusahaan ? 'Terverifikasi' : 'Belum Lengkap' }}</span>
            </div>
        </div>

        <div style="padding: 0 25px 25px;">
            <div style="display: grid; gap: 20px;">

                @php
                    $data = [
                        ['icon' => 'building', 'label' => 'Nama Perusahaan', 'value' => $namaPerusahaan ?? '-'],
                        ['icon' => 'briefcase', 'label' => 'Bidang Industri', 'value' => $bidangIndustri ?? '-'],
                        ['icon' => 'map-marker-alt', 'label' => 'Alamat Kantor', 'value' => $alamatKantor ?? '-'],
                        ['icon' => 'phone', 'label' => 'Nomor Telepon', 'value' => $nomorTelepon ?? '-'],
                        ['icon' => 'globe', 'label' => 'Website', 'value' => $website ?? '#'],
                    ];
                @endphp

                @foreach ($data as $item)
                    <div class="profile-detail-item">
                        <i class="fas fa-{{ $item['icon'] }}" style="color: #667eea;"></i>
                        <div>
                            <span class="detail-label">{{ $item['label'] }}</span>
                            <span class="detail-value">{{ $item['value'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 30px;">
                <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 15px;">Tentang Perusahaan</h4>
                <p style="white-space: pre-wrap;">{{ $deskripsiPerusahaan ?? 'Deskripsi belum diisi. Klik Edit Profil untuk menambahkan deskripsi.' }}</p>
            </div>
        </div>
    </div>

    {{-- Bagian EDIT (Formulir Edit Profil) --}}
    <div id="profil-edit" class="card" style="display: none; position: relative; z-index: 9999;">
        <div class="card-header">
            <h3 class="card-title">Edit Profil Perusahaan</h3>
        </div>
        
        {{-- KRITIS: Tambahkan enctype="multipart/form-data" untuk upload file --}}
        <form action="{{ route('perusahaan.profil.update') }}" method="POST" id="edit-profil-form" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            {{-- INPUT UNTUK LOGO PERUSAHAAN --}}
            <div class="form-group">
                <label class="form-label">Logo Perusahaan</label>
                <input type="file" class="form-input @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                <small class="form-text text-muted">Format: JPG, PNG. Maksimal: 2MB.</small>
                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror

                @if ($perusahaan && $perusahaan->logo)
                    <div style="margin-top: 10px;">
                        Logo saat ini: 
                        <img src="{{ asset('storage/logos/' . $perusahaan->logo) }}" alt="Logo Perusahaan" style="max-width: 100px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                    </div>
                @endif
            </div>

            {{-- INPUT LAINNYA --}}
            <div class="form-group">
                <label class="form-label">Nama Perusahaan*</label>
                <input type="text" class="form-input @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" value="{{ old('nama_perusahaan', $namaPerusahaan ?? '') }}" required>
                @error('nama_perusahaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Bidang Industri</label>
                <input type="text" class="form-input @error('industri') is-invalid @enderror" name="industri" value="{{ old('industri', $bidangIndustri ?? '') }}">
                @error('industri')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Kantor</label>
                <input type="text" class="form-input @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat', $alamatKantor ?? '') }}">
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" class="form-input @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon', $nomorTelepon ?? '') }}">
                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="url" class="form-input @error('website') is-invalid @enderror" name="website" value="{{ old('website', $website ?? '') }}">
                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Perusahaan</label>
                <textarea class="form-input @error('deskripsi') is-invalid @enderror" name="deskripsi" style="min-height: 120px;">{{ old('deskripsi', $deskripsiPerusahaan ?? '') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="action-buttons" style="display: flex; gap: 10px;">
                {{-- Solusi Tombol: Menggunakan type="button" untuk memanggil submit via JS --}}
                <button type="button" class="btn btn-primary" onclick="document.getElementById('edit-profil-form').submit()" style="pointer-events: all !important;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <button type="button" class="btn btn-secondary" onclick="cancelEditProfil()">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Fungsi untuk menampilkan dan menutup Modal
    function showModal(message) {
        document.getElementById('modalMessage').innerText = message;
        document.getElementById('successModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('successModal').style.display = 'none';
    }

    // 2. Profil Functions
    function editProfil() {
        document.getElementById('profil-view').style.display = 'none';
        document.getElementById('profil-edit').style.display = 'block';
    }

    function cancelEditProfil() {
        document.getElementById('profil-view').style.display = 'block';
        document.getElementById('profil-edit').style.display = 'none';
    }

    // Logika yang dijalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Solusi KRITIS: Menampilkan form edit saat validasi gagal
        @if ($errors->any())
            editProfil();
        @endif

        // Logika untuk menampilkan modal pop-up saat sukses
        @if (session('success'))
            showModal("{{ session('success') }}");
        @endif
        
        // Menutup modal jika user klik di luar modal atau tombol silang (X)
        document.querySelector('.close-btn').onclick = closeModal;
        
        window.onclick = function(event) {
            let modal = document.getElementById('successModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    });
</script>
@endsection