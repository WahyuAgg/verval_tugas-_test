<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProduk extends Model
{
    use HasFactory;

    protected $table = 'gambar_produk';
    protected $primaryKey = 'id_gambar_produk';
    public $incrementing = true;
    protected $fillable = [
        'id_produk',
        'url_gambar_produk'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
