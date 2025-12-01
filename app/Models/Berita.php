<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'beritas'; 

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'penulis',
        'slug' // Pastikan kolom ini ada di tabel jika digunakan
    ];
}