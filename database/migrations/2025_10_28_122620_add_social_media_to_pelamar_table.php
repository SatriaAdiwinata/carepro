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
        // Pastikan tabelnya adalah 'pelamar'
        Schema::table('pelamar', function (Blueprint $table) {
            // Tambahkan kolom instagram
            $table->string('instagram', 50)->nullable()->after('alamat'); 
            
            // Tambahkan kolom tiktok
            $table->string('tiktok', 50)->nullable()->after('instagram');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelamar', function (Blueprint $table) {
            // Hapus kolom saat rollback
            $table->dropColumn(['instagram', 'tiktok']);
        });
    }
};