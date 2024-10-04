<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Sanctum\HasApiTokens; // Pastikan ini ada

class RefindsUser extends Model
{
    use HasFactory; // Tambahkan HasApiTokens di sini

    protected $table = 'refindsuser';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $fillable = [
        'nama_akun', 'nama_asli_user', 'email', 'password', 'no_telepon', 'tanggal_registrasi',
        'url_foto_profil', 'status_akun', 'terakhir_login'
    ];

    public function alamat()
    {
        return $this->hasMany(Alamat::class, 'id_user');
    }

    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'id_user');
    }
}
