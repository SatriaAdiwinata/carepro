<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran'; 
    protected $primaryKey = 'id';
    
    // Pastikan semua kolom yang diperlukan ada di sini
    protected $fillable = [
        'pelamar_id',
        'lowongan_id',
        'nama_lengkap',
        'email',
        'no_telepon',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'pendidikan_terakhir',
        'jurusan',
        'universitas',
        'tahun_lulus',
        'ipk',
        'posisi_dilamar',
        'pengalaman_kerja',
        'file_cv',
        'file_cover_letter',
        'surat_pengantar',
        'status', // 'menunggu', 'diterima', 'ditolak'
    ];
    
    /**
     * Relasi ke Lowongan (Wajib untuk filter di LamaranMasukController)
     */
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }
    
    /**
     * Relasi ke Pelamar
     */
    public function pelamar()
    {
        // Asumsi Anda memiliki model Pelamar
        return $this->belongsTo(Pelamar::class, 'pelamar_id');
    }
}