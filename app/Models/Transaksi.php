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
        'tgl_konfirm_penjual',
        'tgl_pembatalan_pembeli',
        'tgl_pembatalan_penjual',
        'tgl_konfirm_selesai_pembeli',
        'tgl_konfirm_selesai_penjual',
        'status_transaksi',
    ];

    // Relasi



    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function userPembeli()
    {
        return $this->belongsTo(User::class, 'id_user_pembeli');
    }


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'id_transaksi', 'id_transaksi');
    }

    // Fungsi untuk konfirmasi penjual
    public function konfirmasiPenjual()
    {
        $this->tgl_konfirm_penjual = now();
        $this->save();
    }

    // Fungsi untuk pembatalan oleh penjual
    public function batalkanOlehPenjual()
    {
        $this->tgl_pembatalan_penjual = now();
        $this->save();
    }

    // Fungsi untuk pembatalan oleh pembeli
    public function batalkanOlehPembeli()
    {
        $this->tgl_pembatalan_pembeli = now();
        $this->save();
    }

    // Fungsi untuk konfirmasi selesai oleh penjual
    public function konfirmasiSelesaiOlehPenjual()
    {
        $this->tgl_konfirm_selesai_penjual = now();
        $this->save();
    }

    // Fungsi untuk konfirmasi selesai oleh pembeli
    public function konfirmasiSelesaiOlehPembeli()
    {
        $this->tgl_konfirm_selesai_pembeli = now();
        $this->save();
    }
}
