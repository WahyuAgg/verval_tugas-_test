<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_produk',
        'id_alamat',
        'id_user_pembeli',
        'tanggal_transaksi_dibuat',
        'deskripsi',
        'harga',
        'jumlah',
        'harga_total',
        'tgl_konfirm_penjual',
        'tgl_pembatalan_pembeli',
        'tgl_pembatalan_penjual',
        'tgl_konfirm_selesai_pembeli',
        'tgl_konfirm_selesai_penjual',
        'status_transaksi',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function userPembeli()
    {
        return $this->belongsTo(User::class, 'id_user_pembeli');
    }
}

