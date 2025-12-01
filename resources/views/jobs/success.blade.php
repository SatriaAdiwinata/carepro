@extends('layouts.app') 

@section('content')
    <div class="container" style="text-align: center; padding: 50px;">
        <h1 style="color: #28a745;">✅ Lamaran Berhasil Dikirim!</h1>
        <p class="lead">Terima kasih telah melamar. Data Anda telah berhasil kami terima dan akan segera diproses.</p>
        
        {{-- Tampilkan pesan success dari Controller --}}
        @if (session('success'))
            <div class="alert alert-success mt-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-5">
            <a href="{{ url('/') }}" class="btn btn-primary" style="padding: 10px 20px;">Kembali ke Beranda</a>
        </div>
    </div>
@endsection