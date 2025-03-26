<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Ganti Model dengan Authenticatable
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;


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

    // Fungsi untuk mendapatkan atribut dengan transformasi URL foto profil
    public function getTransformedAttributes()
    {
        // Transformasi atribut
        $attributes = $this->attributesToArray();

        // Ubah url_foto_profil menjadi URL lengkap
        $attributes['url_foto_profil_full'] = $this->url_foto_profil ? url($this->url_foto_profil) : null;

        return $attributes;
    }



    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_user', 'id_user');
    }

    // Relasi ke Transaksi melalui Produk
    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaksi::class,
            Produk::class,
            'id_user',      // Foreign key di Produk
            'id_produk',    // Foreign key di Transaksi
            'id_user',      // Local key di RefindsUser
            'id_produk'     // Local key di Produk
        );
    }

    // Relasi ke Ulasan melalui Transaksi
    public function ulasan()
    {
        return $this->hasManyThrough(
            Ulasan::class,
            Transaksi::class,
            'id_produk',        // Foreign key di Transaksi
            'id_transaksi',     // Foreign key di Ulasan
            'id_user',          // Local key di RefindsUser
            'id_transaksi'      // Local key di Transaksi
        );
    }


    public function getAverageRating()
    {
        // Gunakan Query Builder untuk menghitung rata-rata rating
        $averageRating = DB::table('ulasan')
            ->join('transaksi', 'ulasan.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('produk', 'transaksi.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_user', $this->id_user)
            ->avg('ulasan.rating');

        return $averageRating ?: 0; // Kembalikan 0 jika tidak ada rating
    }

    public function getUserById($id_user)
    {
        // Ambil data user dengan alamat dan produk
        $user = RefindsUser::with(['alamat', 'produk'])->find($id_user);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Tambahkan rata-rata rating sebagai atribut ke user
        $user->average_rating = $user->getAverageRating();

        return response()->json($user);
    }


}

