<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * HANYA MENAMBAHKAN KOLOM YANG BELUM ADA.
     */
    public function up(): void
    {
        Schema::table('lamaran', function (Blueprint $table) {
            
            // Kolom Detail Pelamar yang HARUS ditambahkan:
            $table->date('tanggal_lahir')->nullable()->after('nama_lengkap'); 
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('tanggal_lahir');
            $table->string('alamat', 500)->nullable()->after('jenis_kelamin');
            
            // Kolom Pendidikan Tambahan
            $table->string('jurusan')->nullable()->after('pendidikan_terakhir');
            $table->string('universitas')->nullable()->after('jurusan');
            $table->year('tahun_lulus')->nullable()->after('universitas');
            $table->string('ipk', 10)->nullable()->after('tahun_lulus');
            $table->string('posisi_dilamar')->nullable()->after('ipk');

            // Kolom untuk File Upload
            $table->string('file_cv')->nullable()->after('posisi_dilamar'); // Path CV
            $table->string('file_cover_letter')->nullable()->after('file_cv'); // Path Cover Letter (nullable)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->dropColumn([
                // Kolom yang ditambahkan di fungsi up()
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat',
                'jurusan',
                'universitas',
                'tahun_lulus',
                'ipk',
                'posisi_dilamar',
                'file_cv',
                'file_cover_letter',
            ]);
        });
    }
};