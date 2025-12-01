<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'pengguna_id',
        'nama_perusahaan',
        'logo',
        'industri',
        'deskripsi',
        'alamat',
        'telepon',
        'website',
    ];
    
    // Relasi Perusahaan hasMany Lowongan
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'perusahaan_id', 'id');
    }

    // Relasi Perusahaan belongsTo Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'id');
    }
}