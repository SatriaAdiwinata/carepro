@extends('layouts.app')


@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/job-detail.css') }}">
    @endpush

    {{-- Logika Blade untuk Memproses Data --}}
    @php
        // Definisikan delimiter yang digunakan untuk memisahkan Kualifikasi Wajib dan Tambahan
        $KUALIFIKASI_DELIMITER = "=== TAMBAHAN ===";
        
        // Data dari kolom 'tanggung_jawab' (yang berisi Kualifikasi Wajib & Tambahan)
        $kualifikasiData = $lowongan->tanggung_jawab ?? '';
        $kualifikasiWajib = $kualifikasiData;
        $kualifikasiTambahan = null;

        // Pisahkan Kualifikasi Wajib dan Tambahan
        if (strpos($kualifikasiData, $KUALIFIKASI_DELIMITER) !== false) {
            list($wajib, $tambahan) = explode($KUALIFIKASI_DELIMITER, $kualifikasiData, 2);
            $kualifikasiWajib = trim($wajib);
            $kualifikasiTambahan = trim($tambahan);
        }

        // Hitung informasi waktu (Deadline)
        $batasLamaran = $lowongan->batas_lamaran ? \Carbon\Carbon::parse($lowongan->batas_lamaran) : null;
        $tanggalDibuat = \Carbon\Carbon::parse($lowongan->created_at);
        
        $deadlineInfo = '';

        if ($batasLamaran && $batasLamaran->isFuture()) {
            // Tampilkan tanggal deadline dalam format "28 November 2025"
            $formattedDeadline = $batasLamaran->isoFormat('D MMMM Y'); 
            // **HARI TERSISA DIHILANGKAN DARI SINI**
            $deadlineInfo = "Batas Lamaran: " . $formattedDeadline; 
        } elseif ($batasLamaran && $batasLamaran->isPast()) {
            $deadlineInfo = "Lowongan telah ditutup pada " . $batasLamaran->isoFormat('D MMMM Y');
        } else {
            $deadlineInfo = "Deadline tidak ditentukan.";
        }

        $dipostingInfo = 'Diposting: ' . $tanggalDibuat->diffForHumans();

    @endphp

    <div class="job-detail-page pt-20">
        <div class="container">
            <div class="job-header">
                <div class="job-info">
                    <div class="company-logo">{{ substr($lowongan->perusahaan->nama_perusahaan ?? 'P', 0, 2) }}</div>
                    <h1 class="job-title">{{ $lowongan->posisi }}</h1>
                    <div class="company-name">{{ $lowongan->perusahaan->nama_perusahaan ?? 'Perusahaan Tidak Dikenal' }}</div>
                    <div class="company-category">{{ $lowongan->perusahaan->industri ?? 'Umum' }}</div>

                    <div class="job-badges">
                        <div class="badge">
                            <div class="badge-label">📍 Lokasi</div>
                            <div class="badge-value">{{ $lowongan->lokasi }}</div>
                        </div>
                        <div class="badge">
                            <div class="badge-label">💰 Gaji</div>
                            <div class="badge-value">
                                @if ($lowongan->gaji_min && $lowongan->gaji_max)
                                    Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }} - {{ number_format($lowongan->gaji_max, 0, ',', '.') }}
                                @else
                                    Gaji Rahasia
                                @endif
                            </div>
                        </div>
                        <div class="badge">
                            <div class="badge-label">⏰ Tipe</div>
                            <div class="badge-value">{{ $lowongan->tipe_pekerjaan }}</div>
                        </div>
                    </div>
                </div>

                <div class="job-apply">
                    <div class="applicants">0</div>
                    <div class="applicants-text">Pelamar saat ini</div>
                    <div class="deadline-info">
                        {{-- HARI TERSISA DIHILANGKAN DARI TAMPILAN INI --}}
                        <div>
                            {{ $deadlineInfo }} 
                        </div>
                        <div>{{ $dipostingInfo }}</div>
                    </div>
                    <a href="{{ route('jobs.form', ['id' => $lowongan->id]) }}" class="btn-apply btn-link">Lamar Sekarang</a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="main-content">
                {{-- DESKRIPSI PEKERJAAN --}}
                <div class="section">
                    <h2 class="section-title">Deskripsi Pekerjaan</h2>
                    <div class="section-content">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                <div class="section">
                    <h2 class="section-title">Persyaratan</h2>

                    {{-- KUALIFIKASI WAJIB --}}
                    <div class="requirements-section">
                        <h3 class="requirements-subtitle">Kualifikasi Wajib:</h3>
                        <ul class="requirements-list">
                            @foreach (explode("\n", $kualifikasiWajib) as $item)
                                @if (trim($item))
                                    <li>{!! trim($item) !!}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    {{-- KUALIFIKASI TAMBAHAN (Hanya tampil jika ada) --}}
                    @if ($kualifikasiTambahan)
                    <div class="requirements-section">
                        <h3 class="requirements-subtitle">Kualifikasi Tambahan:</h3>
                        <ul class="requirements-list">
                            @foreach (explode("\n", $kualifikasiTambahan) as $item)
                                @if (trim($item))
                                    <li>{!! trim($item) !!}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="sidebar">
                {{-- SKILL YANG DIBUTUHKAN --}}
                <div class="section">
                    <h3 class="section-title">Skill yang dibutuhkan</h3>
                    <div class="skills-list">
                        @foreach (explode("\n", $lowongan->kualifikasi ?? '') as $skill)
                            @if (trim($skill))
                                <div class="skill-item">
                                    <span class="skill-name">{!! trim($skill) !!}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                {{-- LOWONGAN TERKAIT (RAPI) --}}
                @if (isset($lowonganTerkait) && $lowonganTerkait->count() > 0)
                    <div class="section mt-8 p-4 bg-white rounded-lg shadow-md border border-gray-100">
                        <h3 class="section-title text-lg font-semibold mb-3 text-slate-800 border-b pb-2">Lowongan Terkait</h3>
                        <ul class="space-y-3">
                            @foreach ($lowonganTerkait as $terkait)
                                <li class="p-2 hover:bg-gray-50 transition duration-150 rounded-md border border-dashed border-gray-200">
                                    <a href="{{ route('lowongan.show', $terkait->id) }}" class="block">
                                        <div class="font-medium text-sm text-indigo-600 hover:text-indigo-800 transition duration-150">
                                            {{ $terkait->posisi }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ $terkait->perusahaan->nama_perusahaan ?? 'Perusahaan Lain' }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <script>
        // Kode Javascript Anda (Tidak diubah)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (header) { 
                if (window.scrollY > 100) {
                    header.style.background = 'rgba(99, 102, 241, 0.9)';
                    header.style.backdropFilter = 'blur(10px)';
                } else {
                    header.style.background = 'transparent';
                    header.style.backdropFilter = 'none';
                }
            }
        });

        // Add animation on page load
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.badge, .job-apply, .section');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection