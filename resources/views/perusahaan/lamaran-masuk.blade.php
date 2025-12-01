@extends('layouts.master')

@section('title', 'Lamaran Masuk')
@section('page-title', 'Lamaran Masuk')

@section('content')
    
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

    <div id="lamaran-management-container">
        <div id="lamaran-masuk" class="content-section active">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Lamaran Masuk</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pelamar</th>
                                <th>Posisi Dilamar</th>
                                <th>Lowongan</th>
                                <th>Email</th>
                                <th>Tanggal Melamar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Looping Data Lamaran (Variabel $lamarans dikirim dari Controller) --}}
                            @forelse ($lamarans as $lamaran) 
                                <tr>
                                    <td>{{ $lamaran->nama_lengkap }}</td>
                                    <td>{{ $lamaran->posisi_dilamar }}</td>
                                    {{-- Mengakses judul lowongan melalui relasi --}}
                                    <td>{{ $lamaran->lowongan->judul ?? 'Lowongan Dihapus' }}</td> 
                                    <td>{{ $lamaran->email }}</td>
                                    <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                                    <td>
                                        {{-- Menampilkan badge status --}}
                                        <span class="badge 
                                            @if ($lamaran->status === 'diterima') bg-success 
                                            @elseif ($lamaran->status === 'ditolak') bg-danger 
                                            @else bg-warning 
                                            @endif
                                        ">
                                            {{ ucfirst($lamaran->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- PERUBAHAN DI SINI: Mengubah button modal menjadi link ke halaman detail --}}
                                            <a href="{{ route('perusahaan.lamaran_masuk.show', $lamaran->id) }}" class="btn btn-sm btn-info">
                                                Detail
                                            </a>
                                            
                                            @if ($lamaran->status === 'menunggu')
                                                {{-- Form Aksi - Terima --}}
                                                <form method="POST" action="{{ route('perusahaan.lamaran_masuk.update_status', $lamaran->id) }}" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menerima lamaran ini?');">
                                                    @csrf
                                                    @method('PUT') 
                                                    <input type="hidden" name="status" value="diterima">
                                                    <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                                </form>
                                                
                                                {{-- Form Aksi - Tolak --}}
                                                <form method="POST" action="{{ route('perusahaan.lamaran_masuk.update_status', $lamaran->id) }}" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menolak lamaran ini?');">
                                                    @csrf
                                                    @method('PUT') 
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                                </form>
                                            @endif

                                            {{-- Tombol Download CV --}}
                                            {{-- Pastikan Anda sudah menjalankan 'php artisan storage:link' --}}
                                            <a href="{{ Storage::url($lamaran->file_cv) }}" class="btn btn-sm btn-primary" target="_blank" title="Download CV">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center;">
                                        <i class="fas fa-box-open"></i> Belum ada lamaran masuk untuk lowongan perusahaan Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Menampilkan link pagination --}}
                <div class="card-footer clearfix">
                    {{ $lamarans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection