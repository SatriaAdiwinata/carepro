<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;

    protected $table = 'pelamar';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengguna_id',
        'no_hp',
        'alamat',
        'cv',
        // 📌 KOLOM BARU UNTUK INLINE EDITING
        'pekerjaan',
        'bio',
        'instagram',
        'tiktok',
    ];

    /**
     * Get the user that owns the pelamar.
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}