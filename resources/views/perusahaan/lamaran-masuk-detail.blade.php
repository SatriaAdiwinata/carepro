@extends('layouts.master')

@section('title', 'Detail Lamaran')
@section('page-title', 'Detail Lamaran Pelamar')

@section('content')

    {{-- Tambahkan styling dasar untuk tata letak yang rapi --}}
    <style>
        .info-detail-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }

        .info-detail-label {
            font-weight: bold;
            flex: 0 0 35%; /* Lebar untuk label */
            color: #4a5568;
        }

        .info-detail-value {
            flex: 1;
        }
        
        /* Style untuk badge status agar konsisten */
        .badge-lg {
            font-size: 1.1em;
            padding: 0.5em 1em;
            display: inline-block;
        }
        .bg-warning { background-color: #ffc107 !important; color: #343a40 !important; }
        .bg-success { background-color: #28a745 !important; color: white !important; }
        .bg-danger { background-color: #dc3545 !important; color: white !important; }
    </style>

    {{-- Notifikasi Sukses/Error --}}
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        {{-- Kolom Kiri: Detail Informasi Pelamar --}}
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-id-card"></i> Data Lengkap Pelamar
                    </h3>
                </div>
                <div class="card-body">
                    
                    {{-- 1. Ringkasan Lamaran --}}
                    <h4><i class="fas fa-paper-plane"></i> Detail Lamaran</h4>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Posisi Dilamar</div>
                        <div class="info-detail-value">{{ $lamaran->posisi_dilamar }}</div>
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Lowongan Terkait</div>
                        <div class="info-detail-value">
                            {{ $lamaran->lowongan->judul ?? 'Lowongan Dihapus/Tidak Ditemukan' }}
                        </div>
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Tanggal Melamar</div>
                        <div class="info-detail-value">{{ $lamaran->created_at->format('d F Y H:i') }}</div>
                    </div>
                    
                    <hr class="mt-4 mb-4">

                    {{-- 2. Data Pribadi --}}
                    <h4><i class="fas fa-user"></i> Data Pribadi</h4>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Nama Lengkap</div>
                        <div class="info-detail-value">{{ $lamaran->nama_lengkap }}</div>
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Email</div>
                        <div class="info-detail-value">{{ $lamaran->email }}</div>
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Nomor Telepon</div>
                        <div class="info-detail-value">{{ $lamaran->nomor_telepon ?? 'Tidak tersedia' }}</div>
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Alamat Lengkap</div>
                        <div class="info-detail-value">{{ $lamaran->alamat ?? 'Tidak tersedia' }}</div>
                    </div>
                    
                    <hr class="mt-4 mb-4">
                    
                    {{-- 3. Pendidikan & Pengalaman (Diasumsikan ada di model/relasi lain, menggunakan placeholder N/A) --}}
                    <h4><i class="fas fa-graduation-cap"></i> Pendidikan & Pengalaman</h4>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Pendidikan Terakhir</div>
                        {{-- Ganti 'N/A' dengan $lamaran->pendidikan jika kolom tersedia --}}
                        <div class="info-detail-value">{{ $lamaran->pendidikan_terakhir ?? 'N/A' }}</div> 
                    </div>
                    <div class="info-detail-row">
                        <div class="info-detail-label">Pengalaman Kerja</div>
                         {{-- Ganti 'N/A' dengan $lamaran->pengalaman_kerja jika kolom tersedia --}}
                        <div class="info-detail-value">{{ $lamaran->level_pengalaman ?? 'N/A' }}</div> 
                    </div>
                    
                    <hr class="mt-4 mb-4">

                    {{-- 4. Cover Letter/Pesan Tambahan --}}
                    <h4><i class="fas fa-comment-dots"></i> Pesan Pelamar (Cover Letter)</h4>
                    <p class="text-muted border p-3 rounded bg-light">
                        {{ $lamaran->pesan_tambahan ?? 'Pelamar tidak menyertakan pesan tambahan.' }}
                    </p>
                    
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status dan Aksi --}}
        <div class="col-md-4">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check"></i> Status & Aksi Cepat</h3>
                </div>
                <div class="card-body text-center">
                    
                    <div class="mb-4">
                        <p class="mb-2 font-weight-bold">Status Lamaran Saat Ini:</p>
                        {{-- Menampilkan badge status --}}
                        <span class="badge badge-lg 
                            @if ($lamaran->status === 'diterima') bg-success 
                            @elseif ($lamaran->status === 'ditolak') bg-danger 
                            @else bg-warning 
                            @endif
                        ">
                            {{ ucfirst($lamaran->status) }}
                        </span>
                    </div>

                    {{-- Link Download CV --}}
                    <div class="d-grid mb-4">
                        <a href="{{ Storage::url($lamaran->file_cv) }}" class="btn btn-primary btn-block" target="_blank" title="Download CV">
                            <i class="fas fa-file-download"></i> Unduh File CV
                        </a>
                    </div>
                    
                    {{-- Form Aksi (Hanya muncul jika status masih 'menunggu') --}}
                    @if ($lamaran->status === 'menunggu')
                        <p class="text-center font-weight-bold">Ubah Status Lamaran:</p>
                        <div class="btn-group w-100" role="group">
                            {{-- Form Terima --}}
                            <form method="POST" action="{{ route('perusahaan.lamaran_masuk.update_status', $lamaran->id) }}" class="w-50" onsubmit="return confirm('Yakin ingin MENERIMA lamaran ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('PUT') 
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Terima</button>
                            </form>
                            
                            {{-- Form Tolak --}}
                            <form method="POST" action="{{ route('perusahaan.lamaran_masuk.update_status', $lamaran->id) }}" class="w-50" onsubmit="return confirm('Yakin ingin MENOLAK lamaran ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('PUT') 
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-times"></i> Tolak</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info text-center mt-3">
                            Status lamaran sudah **{{ ucfirst($lamaran->status) }}**.
                        </div>
                    @endif
                    
                    <hr class="mt-4 mb-3">
                    
                    <a href="{{ route('perusahaan.lamaran_masuk.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Lamaran
                    </a>
                </div>
            </div>
            
        </div>
    </div>
@endsection