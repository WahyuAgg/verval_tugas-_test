<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    public $incrementing = true;
    protected $fillable = ['id_pesanan', 'rating', 'komentar', 'tanggal_ulasan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
