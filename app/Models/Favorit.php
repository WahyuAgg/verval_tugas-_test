<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    use HasFactory;

    protected $table = 'favorit';
    protected $primaryKey = null; // No primary key because this is a pivot table
    public $incrementing = false;
    protected $fillable = [
        'id_user',
        'id_produk',
        'tanggal_favorit'
    ];

    public function user()
    {
        return $this->belongsTo(RefindsUser::class, 'id_user');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
