@extends('layouts.master')

@section('title', 'Dashboard HR')
@section('page-title', 'Dashboard')

@section('content')
 <!--DASHBOARD PERUSAHAAN -->
<div id="dashboard" class="content-section active">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-value">{{ $lowonganAktif }}</div>
            <div class="stat-label">Lowongan Tersedia</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalPelamar }}</div>
            <div class="stat-label">Total Pelamar</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $menungguReview }}</div>
            <div class="stat-label">Menunggu Review</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $diterimaBulanIni }}</div>
            <div class="stat-label">Diterima Bulan Ini</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lowongan Terbaru</h3>
        </div>
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
                @foreach ($lowonganTerbaru as $lowongan)
                    <tr>
                        <td><strong>{{ $lowongan['posisi'] }}</strong></td>
                        <td>{{ $lowongan['tipe'] }}</td>
                        <td>{{ $lowongan['lokasi'] }}</td>
                        <td>{{ $lowongan['pelamar'] }}</td>
                        <td><span class="badge {{ $lowongan['status'] == 'Aktif' ? 'badge-active' : '' }}">{{ $lowongan['status'] }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection