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

            {{-- Form Filter (Server-Side) --}}
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
                    <div style="font-size: 28px; font-weight: bold;">{{ number_format($karyawanBulanIni) }}</div> 
                    <div style="opacity: 0.9;">Diterima Bulan Ini</div>
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
                                <td><strong>{{ $karyawan->nama_karyawan }}</strong></td>
                                <td>{{ $karyawan->posisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung ?? now())->format('d M Y') }}</td>
                                <td>{{ $karyawan->email }}</td>
                                <td>{{ $karyawan->no_telepon }}</td>
                                <td>
                                    <div class="action-buttons">
                                        {{-- viewEmployee dipanggil dengan ID untuk AJAX --}}
                                        <button class="btn btn-primary btn-sm" onclick="viewEmployee('{{ $karyawan->nama_karyawan }}', {{ $karyawan->id }})"><i
                                                class="fas fa-eye"></i>
                                        </button>

                                        @if ($karyawan->lamaran && $karyawan->lamaran->file_cv)
                                            <a href="{{ Storage::url($karyawan->lamaran->file_cv) }}" class="btn btn-sm btn-info" target="_blank" title="Download CV">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        
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

    {{-- Halaman Detail (Akan diisi oleh JS/AJAX) --}}
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
        
        /**
         * Fungsi untuk menampilkan halaman detail karyawan menggunakan AJAX.
         */
        function viewEmployee(nama, id) {
             const listPage = document.getElementById('karyawan');
             const detailPage = document.getElementById('employee-detail-page');
             const detailContent = document.getElementById('employeeDetailPageContent');

             if (!listPage || !detailPage || !detailContent) return;

             // 1. Tampilkan loading state dan ubah tampilan
             detailContent.innerHTML = '<div style="text-align: center; padding: 50px;"><i class="fas fa-spinner fa-spin fa-2x"></i> Memuat data...</div>';
             listPage.style.display = 'none';
             detailPage.style.display = 'block';
             window.scrollTo({ top: 0, behavior: 'smooth' });

             // 2. Lakukan panggilan AJAX ke Controller (Route: perusahaan.data-karyawan.detail)
             const url = `{{ url('perusahaan/data-karyawan') }}/${id}/detail`;
             
             fetch(url, {
                 method: 'GET',
                 headers: {
                     'X-Requested-With': 'XMLHttpRequest',
                     'Content-Type': 'application/json'
                 }
             })
             .then(response => {
                 if (!response.ok) {
                     return response.json().then(err => {
                         throw new Error(err.error || 'Gagal mengambil data detail.');
                     });
                 }
                 return response.json();
             })
             .then(data => {
                 if (data.success && data.karyawan) {
                     const k = data.karyawan;
                     
                     
                     // Helper untuk memformat tanggal
                     const formatDate = (dateString) => {
                         if (!dateString) return 'N/A';
                         return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                     };

                     const tglGabung = formatDate(k.tanggal_bergabung);
                     const tglLahir = formatDate(k.tanggal_lahir);
                     const initials = k.nama_karyawan.split(' ').map(n => n[0]).join('');

                     // 3. Isi Konten Detail HTML
                     detailContent.innerHTML = `
                         <div style="text-align: center; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
                             <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 700;">
                                 ${initials}
                             </div>
                             <h2 style="margin: 0; color: #1f2937;">${k.nama_karyawan}</h2>
                             <p style="margin: 5px 0 0; color: #64748b;">${k.posisi}</p>
                         </div>

                         <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                             <div class="detail-box">
                                 <h4 style="margin-top: 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Informasi Kontak & Pekerjaan</h4>
                                 <p><strong class="detail-label">Email:</strong> <span class="detail-value">${k.email}</span></p>
                                 <p><strong class="detail-label">No. Telepon:</strong> <span class="detail-value">${k.no_telepon}</span></p>
                                 <p><strong class="detail-label">Tanggal Bergabung:</strong> <span class="detail-value">${tglGabung}</span></p>
                                 <p><strong class="detail-label">Alamat:</strong> <span class="detail-value">${k.alamat || 'N/A'}</span></p>
                             </div>
                             <div class="detail-box">
                                 <h4 style="margin-top: 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Data Pribadi & Pendidikan</h4>
                                 <p><strong class="detail-label">Tanggal Lahir:</strong> <span class="detail-value">${tglLahir}</span></p>
                                 <p><strong class="detail-label">Jenis Kelamin:</strong> <span class="detail-value">${k.jenis_kelamin || 'N/A'}</span></p>
                                 <p><strong class="detail-label">Pendidikan Terakhir:</strong> <span class="detail-value">${k.pendidikan_terakhir || 'N/A'}</span></p>
                                 <p><strong class="detail-label">Jurusan/Program Studi:</strong> <span class="detail-value">${k.jurusan || 'N/A'}</span></p>
                                 <p><strong class="detail-label">Universitas/Institusi:</strong> <span class="detail-value">${k.universitas || 'N/A'}</span></p>
                                 <p><strong class="detail-label">Tahun Lulus:</strong> <span class="detail-value">${k.tahun_lulus || 'N/A'}</span></p>
                                 <p><strong class="detail-label">IPK:</strong> <span class="detail-value">${k.ipk || 'N/A'}</span></p>
                             </div>
                         </div>
                         <style>
                             .detail-box {
                                padding: 15px;
                                background: #f8fafc;
                                border-radius: 8px;
                                border: 1px solid #e2e8f0;
                                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                            }
                            .detail-label {
                                color: #64748b;
                                font-size: 14px;
                                display: block;
                                margin-bottom: 2px;
                            }
                            .detail-value {
                                font-weight: 600;
                                color: #1f2937;
                                display: block;
                                margin-bottom: 10px;
                            }
                         </style>
                     `;

                 } else {
                     detailContent.innerHTML = '<div class="alert alert-danger" style="text-align: center;"><i class="fas fa-exclamation-triangle"></i> Data karyawan tidak valid.</div>';
                 }
             })
             .catch(error => {
                 console.error('Error fetching employee data:', error);
                 detailContent.innerHTML = `<div class="alert alert-danger" style="text-align: center;"><i class="fas fa-exclamation-triangle"></i> Gagal memuat data karyawan: ${error.message}.</div>`;
             });
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
        
        document.addEventListener('DOMContentLoaded', function() {
            window.viewEmployee = viewEmployee;
            window.cancelEmployeeDetailPage = cancelEmployeeDetailPage;
        });
    </script>
@endsection