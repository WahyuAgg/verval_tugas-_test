<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Ganti Model dengan Authenticatable
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RefindsUser extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'refindsuser';
    protected $primaryKey = 'id_user';
    public $incrementing = true;

    protected $fillable = [
        'nama_akun',
        'nama_asli_user',
        'email',
        'password',
        'no_telepon',
        'tanggal_registrasi',
        'url_foto_profil',
        'status_akun',
        'terakhir_login',
        'verification_date'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definisikan relasi dengan model lain
    public function alamat()
    {
        return $this->hasMany(Alamat::class, 'id_user');
    }

    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'id_user');
    }

    // Fungsi untuk mendapatkan atribut dengan transformasi URL foto profil
    public function getTransformedAttributes()
    {
        // Transformasi atribut
        $attributes = $this->attributesToArray();

        // Ubah url_foto_profil menjadi URL lengkap
        $attributes['url_foto_profil_full'] = $this->url_foto_profil ? url($this->url_foto_profil) : null;

        return $attributes;
    }
}

