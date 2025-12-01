@extends('layouts.master')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')

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

    <div id="karyawan" class="content-section active">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Karyawan yang Sudah Diterima</h3>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>

            {{-- Form Filter (Logika Server-Side) --}}
            <form action="{{ route('perusahaan.data-karyawan') }}" method="GET" style="padding: 20px 20px 0 20px;">
                <div style="margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
                    
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label">Filter Posisi</label>
                        <select class="form-input" id="filterPosisi" name="posisi">
                            <option value="">Semua Posisi</option>
                            <option value="Backend Developer" {{ request('posisi') == 'Backend Developer' ? 'selected' : '' }}>Backend Developer</option>
                            <option value="Frontend Developer" {{ request('posisi') == 'Frontend Developer' ? 'selected' : '' }}>Frontend Developer</option>
                            <option value="UI/UX Designer" {{ request('posisi') == 'UI/UX Designer' ? 'selected' : '' }}>UI/UX Designer</option>
                            <option value="Marketing Executive" {{ request('posisi') == 'Marketing Executive' ? 'selected' : '' }}>Marketing Executive</option>
                            <option value="Data Analyst" {{ request('posisi') == 'Data Analyst' ? 'selected' : '' }}>Data Analyst</option>
                        </select>
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label">Cari Karyawan</label>
                        <input type="text" class="form-input" id="searchKaryawan" name="search" placeholder="Cari nama..." value="{{ request('search') }}">
                    </div>
                    
                    <div style="display: flex; align-items: flex-end; gap: 5px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                        <a href="{{ route('perusahaan.data-karyawan') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- Kartu Info --}}
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; padding: 0 20px;">

                <div
                    style="
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        ">
                    <div style="font-size: 28px; font-weight: bold;">{{ number_format($karyawans->total()) }}</div>
                    <div style="opacity: 0.9;">Total Karyawan</div>
                </div>

                <div
                    style="
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        ">
                    <div style="font-size: 28px; font-weight: bold;">?</div> 
                    <div style="opacity: 0.9;">Baru Bulan Ini</div>
                </div>

            </div>

            <div class="table-responsive">
                <table id="karyawanTable" class="table table-bordered table-striped"> 
                    <thead>
                        <tr>
                            {{-- KOLOM ID DIHAPUS --}}
                            <th>Nama Karyawan</th>
                            <th>Posisi</th>
                            <th>Tanggal Bergabung</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            {{-- KOLOM STATUS DIHAPUS --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($karyawans as $karyawan)
                            <tr data-posisi="{{ $karyawan->posisi }}" data-nama="{{ $karyawan->nama_karyawan }}">
                                {{-- Kolom ID dihapus --}}
                                <td><strong>{{ $karyawan->nama_karyawan }}</strong></td>
                                <td>{{ $karyawan->posisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung ?? now())->format('d M Y') }}</td>
                                <td>{{ $karyawan->email }}</td>
                                <td>{{ $karyawan->no_telepon }}</td>
                                {{-- Kolom Status dihapus --}}
                                <td>
                                    <div class="action-buttons">
                                        {{-- viewEmployee dipanggil dengan ID --}}
                                        <button class="btn btn-primary btn-sm" onclick="viewEmployee('{{ $karyawan->nama_karyawan }}', {{ $karyawan->id }})"><i
                                                class="fas fa-eye"></i>
                                        </button>
                                        
                                        {{-- Form delete Laravel --}}
                                        <form action="{{ route('perusahaan.data-karyawan.destroy', $karyawan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus karyawan {{ $karyawan->nama_karyawan }}? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">
                                    <i class="fas fa-user-slash"></i> Belum ada data karyawan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Link --}}
            <div class="card-footer clearfix">
                {{ $karyawans->links() }}
            </div>
        </div>
    </div>

    {{-- Halaman Detail --}}
    <div id="employee-detail-page" class="card" style="display: none;">
        <div class="card-header">
            <h3 class="card-title">Detail Karyawan</h3>
            <button class="btn btn-secondary" onclick="cancelEmployeeDetailPage()">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
        <div id="employeeDetailPageContent" style="padding: 25px;">
            {{-- Konten detail akan dimasukkan di sini oleh JavaScript --}}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Data statis dan fungsi filterKaryawan() telah dihapus.
        
        // --- FUNGSI VIEW EMPLOYEE (PLACEHOLDER, perlu AJAX) ---
        
        /**
         * Fungsi untuk menampilkan halaman detail karyawan.
         * CATATAN: Ini hanya placeholder. Anda harus menggunakan AJAX untuk 
         * mengambil data detail karyawan secara dinamis dari Controller.
         */
        function viewEmployee(nama, id) {
             const listPage = document.getElementById('karyawan');
             const detailPage = document.getElementById('employee-detail-page');
             const detailContent = document.getElementById('employeeDetailPageContent');

             if (!listPage || !detailPage || !detailContent) return;
             
             // --- TAMPILAN PLACEHOLDER JIKA DATA DETAIL TIDAK ADA ---
             const initials = nama.split(' ').map(n => n[0]).join('');

             detailContent.innerHTML = `
                 <div style="text-align: center; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
                     <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 700;">
                         ${initials}
                     </div>
                     <h2 style="margin: 0; color: #1f2937;">${nama}</h2>
                     {{-- Status 'Aktif' dihilangkan dari tampilan detail ini --}}
                 </div>
                 <div class="alert alert-warning" style="text-align: center;">
                    <i class="fas fa-exclamation-triangle"></i> Data Detail Karyawan tidak dapat ditampilkan!
                    Harap implementasikan fungsi **AJAX/fetch** di sini untuk mengambil data lengkap Karyawan ID: **#${id}**
                    dari Controller backend.
                 </div>
             `;

             // Sembunyikan daftar karyawan dan tampilkan halaman detail
             listPage.style.display = 'none';
             detailPage.style.display = 'block';

             window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        /**
         * Fungsi untuk kembali ke halaman daftar karyawan.
         */
        function cancelEmployeeDetailPage() {
             const listPage = document.getElementById('karyawan');
             const detailPage = document.getElementById('employee-detail-page');

             if (!listPage || !detailPage) return;

             detailPage.style.display = 'none';
             listPage.style.display = 'block';

             window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // --- PENDAFTARAN KE GLOBAL SCOPE ---
        document.addEventListener('DOMContentLoaded', function() {
            window.viewEmployee = viewEmployee;
            window.cancelEmployeeDetailPage = cancelEmployeeDetailPage;
        });
    </script>
@endsection