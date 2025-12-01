<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Tambahkan kolom slug, pastikan unik dan dapat diisi (nullable jika perlu)
            $table->string('slug')->unique()->after('penulis'); 
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Hapus kolom slug jika migrasi di-rollback
            $table->dropColumn('slug');
        });
    }
};
