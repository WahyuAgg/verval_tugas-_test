<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    use HasFactory;

    protected $table = 'subkategori';
    protected $primaryKey = 'id_subkategori';
    public $incrementing = true;
    protected $fillable = [
        'id_kategori',
        'nama_subkategori',
        'deskripsi_subkategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
