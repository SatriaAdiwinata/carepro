<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'perusahaan_id',
        'lamaran_id',
        'nama_karyawan',
        'posisi',
        'email',
        'no_telepon',
        'tanggal_bergabung',
        'status',
        
        // Kolom Detail dari Lamaran
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'pendidikan_terakhir',
        'jurusan', 
        'universitas',
        'tahun_lulus',
        'ipk',
    ];

    /**
     * Relasi ke perusahaan (company)
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    
    /**
     * Relasi ke lamaran (application)
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class);
    }
}