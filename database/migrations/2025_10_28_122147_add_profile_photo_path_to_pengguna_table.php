<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            // Tambahkan kolom untuk menyimpan path foto profil
            $table->string('profile_photo_path', 2048)->nullable()->after('password');
            
            // Tambahkan kolom untuk Instagram dan TikTok di tabel pelamar
            // Anda perlu membuat migrasi terpisah untuk ini, tetapi jika Anda ingin 
            // menempatkannya di sini (tidak disarankan), pastikan tabel pelamar ada.
            // Solusi: Asumsi Anda akan membuat migrasi lain untuk tabel 'pelamar'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path');
        });
    }
};