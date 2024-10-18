<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';
    public $incrementing = true;
    protected $fillable = [
        'id_user',
        'nama_lokasi',
        'nama_penerima',
        'url_map',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'kode_pos',
        'deskripsi',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(RefindsUser::class, 'id_user');
    }
}
