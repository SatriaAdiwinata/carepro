<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL; 

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database sesuai skema SQL Anda
    protected $table = 'pengguna'; 

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran', // <--- Kolom 'peran' yang menyimpan tipe pengguna
        'profile_photo_path', 
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Jika Anda menggunakan Model ini untuk autentikasi Laravel, pastikan Anda juga 
    // mendefinisikan relasi-relasi yang mungkin terkait dengan pengguna.
    
    /**
     * Accessor untuk mendapatkan URL publik dari foto profil.
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Jika path foto ada, gunakan Storage::url
        if ($this->profile_photo_path) {
            return Storage::url($this->profile_photo_path);
        }

        // Jika tidak ada, kembalikan avatar default
        return URL::asset('images/default-avatar.png'); 
    }

    /**
     * Mendapatkan record pelamar yang terkait dengan pengguna (jika peran adalah 'pelamar').
     */
    public function pelamar()
    {
        // Asumsi Model Pelamar ada dan foreign key adalah 'pengguna_id'
        return $this->hasOne(Pelamar::class, 'pengguna_id');
    }

    /**
     * Mendapatkan record perusahaan yang terkait dengan pengguna (jika peran adalah 'perusahaan').
     */
    public function perusahaan()
    {
        // Asumsi Model Perusahaan ada dan foreign key adalah 'pengguna_id'
        return $this->hasOne(Perusahaan::class, 'pengguna_id');
    }
}