@extends('layouts.master')

@section('title', 'Dashboard HR')
@section('page-title', 'Dashboard')

@section('content')
 <div id="dashboard" class="content-section active">
    
    {{-- 1. GRID KARTU STATISTIK (MENGGUNAKAN VARIABEL DARI CONTROLLER) --}}
    <div class="stats-grid">
        
        {{-- Card 1: Lowongan Aktif --}}
        <div class="stat-card stat-lowongan">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $lowonganAktif }}</div>
                <div class="stat-label">Lowongan Tersedia</div>
            </div>
        </div>
        
        {{-- Card 2: Total Pelamar --}}
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalPelamar }}</div>
                <div class="stat-label">Total Pelamar</div>
            </div>
        </div>
        
        {{-- Card 3: Menunggu Review --}}
        <div class="stat-card stat-review">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $menungguReview }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </div>
        
        {{-- Card 4: Diterima Bulan Ini --}}
        <div class="stat-card stat-diterima">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $diterimaBulanIni }}</div>
                <div class="stat-label">Diterima Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- 2. TABEL LOWONGAN TERBARU --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Lowongan Terbaru Anda (5 Teratas)</h3>
             <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-sm btn-info float-right">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Tipe</th>
                        <th>Lokasi</th>
                        <th>Pelamar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowonganTerbaru as $lowongan)
                        <tr>
                            <td><strong>{{ $lowongan['posisi'] }}</strong></td>
                            <td>{{ $lowongan['tipe'] }}</td>
                            <td>{{ $lowongan['lokasi'] }}</td>
                            <td><span class="badge badge-primary">{{ $lowongan['pelamar'] }} Pelamar</span></td>
                            <td>
                                <span class="badge 
                                    {{ $lowongan['status'] == 'Aktif' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $lowongan['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <i class="fas fa-search"></i> Belum ada lowongan yang dipublikasikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- CSS KHUSUS UNTUK TAMPILAN DASHBOARD --}}
@section('styles')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white; 
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon i {
            font-size: 32px;
        }
        
        .stat-content {
            text-align: right;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Skema Warna Kartu Statistik */
        .stat-lowongan { background: linear-gradient(45deg, #1e3a8a, #3b82f6); } 
        .stat-total { background: linear-gradient(45deg, #047857, #10b981); } 
        .stat-review { background: linear-gradient(45deg, #b45309, #f59e0b); } 
        .stat-diterima { background: linear-gradient(45deg, #be185d, #ec4899); } 

        /* Gaya Tabel dan Card */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .card-title { margin: 0; font-size: 1.25rem; font-weight: 600; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        table thead th {
            text-align: left;
            padding: 12px 20px;
            background-color: #f7f7f7;
            border-bottom: 2px solid #ddd;
            font-weight: 600;
            color: #4a5568;
        }
        table tbody td {
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        table tbody tr:hover { background-color: #f9f9f9; }
        .text-center { text-align: center; }

        /* Gaya Badge */
        .badge {
            padding: 0.4em 0.8em;
            font-size: 75%;
            font-weight: 700;
            border-radius: 0.25rem;
            color: white;
        }
        .badge-active { background-color: #10b981; } /* Green */
        .badge-inactive { background-color: #ef4444; } /* Red */
        .badge-primary { background-color: #3b82f6; } /* Blue */
    </style>
@endsection