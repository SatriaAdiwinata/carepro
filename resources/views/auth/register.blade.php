@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="tabs">
        <a href="{{ url('/login') }}" class="tab">Login</a>
        <a href="{{ url('/register') }}" class="tab tab-active">Register</a>
    </div>
    
    <div id="registerForm">
        <h3 class="form-title">Create an account</h3>
        <p class="form-subtitle">Join CarePro to find your dream job</p>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            {{-- Bagian ini untuk menampilkan semua error di atas form --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-row">
                <div class="form-column">
                    <label for="firstName" class="form-label">Name</label>
                    <input type="text" id="firstName" name="first_name" class="form-input @error('first_name') is-invalid @enderror" placeholder="John" required value="{{ old('first_name') }}">
                    @error('first_name')
                        <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="registerEmail" class="form-label">Email Address</label>
                <input type="email" id="registerEmail" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="you@example.com" required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" id="registerPassword" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="Create a password" required>
                <p class="form-help">Password harus tepat 8 karakter</p>
                @error('password')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" id="confirmPassword" name="password_confirmation" class="form-input @error('password_confirmation') is-invalid @enderror" placeholder="Confirm your password" required>
                @error('password_confirmation')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- **TAMBAHAN PENTING:** Field Nama Perusahaan (Hanya tampil jika 'Perusahaan' dipilih) --}}
            <div class="form-group" id="companyNameGroup" 
                style="display: {{ old('user_type') == 'perusahaan' ? 'block' : 'none' }};">
                <label for="companyName" class="form-label">Nama Perusahaan</label>
                <input type="text" id="companyName" name="company_name" 
                       class="form-input @error('company_name') is-invalid @enderror" 
                       placeholder="PT Contoh Jaya Abadi" 
                       value="{{ old('company_name') }}"
                       {{ old('user_type') == 'perusahaan' ? 'required' : '' }}>
                @error('company_name')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="userType" class="form-label">Register as</label>
                <select id="userType" name="user_type" class="form-input @error('user_type') is-invalid @enderror" required>
                    <option value="">-- Select User Type --</option>
                    <option value="pelamar" {{ old('user_type') == 'pelamar' ? 'selected' : '' }}>Pelamar</option>
                    <option value="perusahaan" {{ old('user_type') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                </select>
                @error('user_type')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-checkbox-container">
                <input type="checkbox" id="terms" name="terms" class="form-checkbox @error('terms') is-invalid @enderror" required>
                <label for="terms" class="form-checkbox-label">I agree to the <a href="#" class="form-link">Terms of Service</a> and <a href="#" class="form-link">Privacy Policy</a></label>
                @error('terms')
                    <div class="invalid-feedback" style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
        
        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-text">or register with</div>
            <div class="divider-line"></div>
        </div>
        
        <div class="social-buttons">
            <button class="btn-social">
                <svg class="social-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google
            </button>
            <button class="btn-social">
                <svg class="social-icon" fill="#1877F2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </button>
        </div>
    </div>

    {{-- Script untuk mengontrol tampilan field Nama Perusahaan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeSelect = document.getElementById('userType');
            const companyNameGroup = document.getElementById('companyNameGroup');
            const companyNameInput = document.getElementById('companyName');

            function toggleCompanyNameField() {
                if (userTypeSelect.value === 'perusahaan') {
                    companyNameGroup.style.display = 'block';
                    // Kita tidak perlu mengatur 'required' di JS lagi karena sudah ada di Blade, 
                    // tapi ini adalah pengamanan.
                    companyNameInput.setAttribute('required', 'required'); 
                } else {
                    companyNameGroup.style.display = 'none';
                    companyNameInput.removeAttribute('required');
                }
            }

            userTypeSelect.addEventListener('change', toggleCompanyNameField);

            // Panggil sekali saat halaman dimuat (untuk kasus validasi gagal dan ada old data)
            toggleCompanyNameField();
        });
    </script>
@endsection