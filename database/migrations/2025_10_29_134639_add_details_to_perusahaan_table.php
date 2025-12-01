<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            
            // Tambahkan pengecekan sebelum menambahkan kolom
            if (!Schema::hasColumn('perusahaan', 'alamat')) {
                $table->text('alamat')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('perusahaan', 'telepon')) {
                $table->string('telepon', 20)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('perusahaan', 'website')) {
                $table->string('website')->nullable()->after('telepon');
            }
            // Kolom ini yang menyebabkan error, jadi pastikan ia belum ada
            if (!Schema::hasColumn('perusahaan', 'logo')) { 
                $table->string('logo')->nullable()->after('website'); 
            }
        });
    }

    // Metode down() dibiarkan tetap seperti semula, karena hanya menghapus kolom.
    public function down(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'telepon', 'website', 'logo']);
        });
    }
};