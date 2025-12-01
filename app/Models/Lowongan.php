<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'perusahaan_id',
        'posisi',
        'tipe_pekerjaan',
        'lokasi',
        'gaji_min',
        'gaji_max',
        'deskripsi',
        'tanggung_jawab',
        'kualifikasi',
        'status',
        'batas_lamaran', 
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}