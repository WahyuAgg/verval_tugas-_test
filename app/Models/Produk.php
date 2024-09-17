<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = true;
    protected $fillable = [
        'id_subkategori', 'id_alamat', 'id_user', 'url_teks_deskripsi', 'nama_produk',
        'harga', 'jumlah', 'tanggal_post', 'kondisi', 'status_post'
    ];

    public function subkategori()
    {
        return $this->belongsTo(SubKategori::class, 'id_subkategori');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }

    public function user()
    {
        return $this->belongsTo(RefindsUser::class, 'id_user');
    }
}
