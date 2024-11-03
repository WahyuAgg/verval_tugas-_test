<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Ganti Model dengan Authenticatable
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RefindsUser extends Authenticatable // Gunakan Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable; // Tambahkan Notifiable untuk fitur notifikasi, jika diperlukan

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
        'terakhir_login'
    ];

    protected $hidden = [
        'password', // Sembunyikan password saat serialisasi
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
}
