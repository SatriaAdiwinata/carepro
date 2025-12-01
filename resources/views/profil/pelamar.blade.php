@extends('layouts.app')

@section('title', $user->nama . ' - Profil Pelamar')

{{-- Bagian Content Utama --}}
@section('content')

    {{-- 
        PENYESUAIAN PENTING:
        1. pt-24 (Padding Top 6rem/96px): Mengompensasi tinggi fixed header (h-24 di desktop) dari layout utama.
        2. mx-auto & max-w-6xl: Memastikan responsivitas dan konten berada di tengah.
    --}}
    <div class="max-w-6xl mx-auto animate-fade-in-up pt-24">
        
        <div class="profile-header bg-white rounded-3xl p-6 md:p-12 text-center shadow-xl border border-gray-100 mb-8 transition-all duration-300">
            <div class="photo-container relative inline-block mb-8">
                <div 
                    id="profile-photo" 
                    onclick="document.getElementById('photo-upload').click()"
                    class="w-36 h-36 rounded-full mx-auto flex items-center justify-center text-6xl text-white cursor-pointer transition-all duration-300 hover:scale-105 shadow-xl bg-gradient-to-br from-fuchsia-400 to-purple-500"
                    style="
                        @if ($user->profile_photo_path)
                            background-image: url('{{ $user->profile_photo_url }}'); background-size: cover; background-position: center;
                        @endif
                    " 
                >
                    @if (!$user->profile_photo_path)
                        👤
                    @endif
                </div>
                <input type="file" id="photo-upload" class="hidden" accept="image/*">
                <div onclick="document.getElementById('photo-upload').click()" class="upload-btn absolute bottom-1 right-1 bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center text-lg cursor-pointer shadow-lg hover:bg-purple-700 transition-all duration-300">
                    📷
                </div>
            </div>

            <h1 class="profile-name text-4xl font-extrabold text-purple-900 mb-2 transition-colors duration-300" id="user-name">{{ $user->nama }}</h1>
            <p class="profile-title text-xl text-purple-700 font-medium mb-4 transition-colors duration-300" id="job-title">{{ $data->pekerjaan ?? 'UI/UX Designer' }}</p>
            <div class="profile-location inline-flex items-center space-x-2 bg-purple-50 p-2 px-4 rounded-full text-purple-800 text-sm mb-6 transition-colors duration-300">
                <span>📍</span> 
                <span id="location">{{ $data->alamat ?? 'Bandung, Indonesia' }}</span>
            </div>
            <p class="profile-bio text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto mb-6 transition-colors duration-300" id="bio">{{ $data->bio ?? 'Desainer UI/UX yang berpengalaman dalam menciptakan antarmuka yang indah dan fungsional.' }}</p>
            
            {{-- PERUBAHAN UTAMA: Tombol Edit diubah menjadi tautan ke halaman edit.blade.php --}}
            <div class="profile-actions mb-4">
                <a href="{{ route('profil.edit') }}" class="btn-edit bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white font-semibold py-3 px-6 rounded-full text-base cursor-pointer transition-all duration-300 shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-fuchsia-600 inline-flex items-center space-x-2"> 
                    <span class="edit-icon">⚙️</span> 
                    <span class="edit-text">Edit Profil</span> 
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <div class="card bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <h2 class="card-title text-2xl font-semibold text-purple-900 mb-6 flex items-center space-x-3">
                    <div class="w-11 h-11 bg-blue-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md">📞</div> Kontak
                </h2>
                <div class="contact-item flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-4 border-l-4 border-fuchsia-400 hover:bg-purple-50 transition-all duration-300">
                    <div class="w-10 h-10 flex items-center justify-center text-2xl text-gray-500">📧</div>
                    <div class="flex-1">
                        <div class="contact-label text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Email</div>
                        <div class="contact-value text-gray-700 font-medium" id="email">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="contact-item flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-4 border-l-4 border-fuchsia-400 hover:bg-purple-50 transition-all duration-300">
                    <div class="w-10 h-10 flex items-center justify-center text-2xl text-gray-500">📱</div>
                    <div class="flex-1">
                        <div class="contact-label text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Telepon</div>
                        <div class="contact-value text-gray-700 font-medium" id="phone">{{ $data->no_hp ?? '+62 xxx xxxx xxxx' }}</div>
                    </div>
                </div>
                <div class="contact-item flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-4 border-l-4 border-fuchsia-400 hover:bg-purple-50 transition-all duration-300">
                    <div class="w-10 h-10 flex items-center justify-center text-2xl text-gray-500">📷</div>
                    <div class="flex-1">
                        <div class="contact-label text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Instagram</div>
                        <div class="contact-value text-gray-700 font-medium" id="instagram">{{ $data->instagram ?? '@belum_diatur' }}</div>
                    </div>
                </div>
                <div class="contact-item flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-4 border-l-4 border-fuchsia-400 hover:bg-purple-50 transition-all duration-300">
                    <div class="w-10 h-10 flex items-center justify-center text-2xl text-gray-500">🎵</div>
                    <div class="flex-1">
                        <div class="contact-label text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">TikTok</div>
                        <div class="contact-value text-gray-700 font-medium" id="tiktok">{{ $data->tiktok ?? '@belum_diatur' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <h2 class="card-title text-2xl font-semibold text-purple-900 mb-6 flex items-center space-x-3">
                    <div class="w-11 h-11 bg-blue-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md">⭐</div> Keahlian
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                        $skills = ['Figma', 'Adobe XD', 'Sketch', 'Prototyping', 'User Research', 'Wireframing'];
                    @endphp

                    @foreach ($skills as $skill)
                        <div class="skill-item bg-purple-100 text-purple-800 py-3 px-4 rounded-xl text-center text-sm font-semibold transition-all duration-300 hover:bg-fuchsia-400 hover:text-white hover:scale-105 shadow-md">
                            {{ $skill }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="full-width-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 mb-8">
            <h2 class="card-title text-2xl font-semibold text-purple-900 mb-6 flex items-center space-x-3">
                <div class="w-11 h-11 bg-blue-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md">💼</div> Pengalaman Kerja
            </h2>
            
            @php
                 // Data Mock Pengalaman Kerja (Harusnya berasal dari Controller)
                 $experiences = [
                    (object)['title' => 'Senior UI/UX Designer', 'company' => 'PT. Creative Digital', 'period' => 'Februari 2022 - Sekarang', 'desc' => 'Memimpin tim design dalam mengembangkan produk digital untuk berbagai klien. Bertanggung jawab dalam user research, wireframing, prototyping, dan design system.'],
                    (object)['title' => 'UI/UX Designer', 'company' => 'Startup Teknologi ABC', 'period' => 'Juni 2020 - Januari 2022', 'desc' => 'Merancang antarmuka aplikasi mobile dan web. Melakukan user testing dan iterasi design berdasarkan feedback pengguna untuk meningkatkan user experience.'],
                    (object)['title' => 'Junior Graphic Designer', 'company' => 'Studio Kreatif XYZ', 'period' => 'Agustus 2019 - Mei 2020', 'desc' => 'Memulai karir sebagai graphic designer dengan fokus pada branding dan visual identity. Belajar prinsip-prinsip design dan user-centered design.'],
                ];
            @endphp
            
            @foreach ($experiences as $experience)
                <div class="experience-item bg-gray-50 rounded-xl p-5 mb-4 border-l-4 border-purple-600 transition-all duration-300 hover:bg-purple-50 hover:shadow-lg hover:scale-[1.01] hover:translate-x-1">
                    <div class="experience-title text-lg font-semibold text-purple-900 mb-1">
                        {{ $experience->title }}
                    </div>
                    <div class="experience-company text-purple-700 font-medium mb-1">
                        {{ $experience->company }}
                    </div>
                    <div class="experience-period text-gray-400 text-sm mb-3">
                        {{ $experience->period }}
                    </div>
                    <div class="experience-desc text-gray-600 leading-relaxed">
                        {{ $experience->desc }}
                    </div>
                </div>
            @endforeach

        </div>

        <div class="cta-section bg-gradient-to-r from-purple-600 to-fuchsia-500 rounded-xl p-8 text-center text-white shadow-xl mb-8">
            <h2 class="cta-title text-3xl font-bold mb-4">Mari Berkolaborasi!</h2>
            <p class="cta-subtitle text-xl opacity-90 mb-6">Tertarik untuk bekerja sama dalam proyek design? Hubungi saya sekarang</p>
            <div class="cta-buttons flex justify-center gap-6 flex-wrap">
                <a href="#" class="btn btn-primary bg-white text-purple-600 py-3 px-8 rounded-xl font-semibold transition-all duration-300 hover:bg-gray-100 hover:-translate-y-1 shadow-lg">Lihat Portfolio</a>
                <a href="mailto:{{ $user->email }}" class="btn btn-secondary bg-transparent border-2 border-white text-white py-3 px-8 rounded-xl font-semibold transition-all duration-300 hover:bg-white hover:text-purple-600 hover:-translate-y-1">Hubungi Saya</a>
            </div>
        </div>

    </div>

@endsection

{{-- PENTING: Semua skrip edit mode dihapus dan hanya menyisakan fungsi photo upload (jika ada) --}}
@push('scripts')
    <script>
        // Photo upload functionality (hanya untuk tampilan sementara di halaman show)
        document.getElementById('photo-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const photoElement = document.getElementById('profile-photo');
                    photoElement.style.backgroundImage = `url(${e.target.result})`;
                    photoElement.style.backgroundSize = 'cover';
                    photoElement.style.backgroundPosition = 'center';
                    photoElement.textContent = ''; 
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush