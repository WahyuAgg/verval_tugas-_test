<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function getKategori(){
        $kategori = Kategori::get();

        return response()->json($kategori);
    }

    public function getSubkategori(){
        $subkategori = SubKategori::get();

        return response()->json($subkategori);
    }


    // hardcode fungsi

    public function updateKategoriDanSubkategori()
    {
        // Data kategori dan subkategori
        $data = [
            [
                'id_kategori' => 1,
                'nama_kategori' => 'elektronik',
                'subkategori' => [
                    ['id_subkategori' => 1, 'nama_subkategori' => 'laptop'],
                    ['id_subkategori' => 2, 'nama_subkategori' => 'mouse'],
                    ['id_subkategori' => 3, 'nama_subkategori' => 'keyboard'],
                    ['id_subkategori' => 4, 'nama_subkategori' => 'hp'],
                ],
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'furniture',
                'subkategori' => [
                    ['id_subkategori' => 5, 'nama_subkategori' => 'kursi'],
                    ['id_subkategori' => 6, 'nama_subkategori' => 'lampu'],
                    ['id_subkategori' => 7, 'nama_subkategori' => 'meja'],
                    ['id_subkategori' => 8, 'nama_subkategori' => 'rak'],
                ],
            ],
            [
                'id_kategori' => 3,
                'nama_kategori' => 'pakaian',
                'subkategori' => [
                    ['id_subkategori' => 9, 'nama_subkategori' => 'topi'],
                    ['id_subkategori' => 10, 'nama_subkategori' => 'sepatu'],
                    ['id_subkategori' => 11, 'nama_subkategori' => 'celana'],
                    ['id_subkategori' => 12, 'nama_subkategori' => 'baju'],
                ],
            ],
            [
                'id_kategori' => 4,
                'nama_kategori' => 'alat rumah tangga',
                'subkategori' => [
                    ['id_subkategori' => 13, 'nama_subkategori' => 'piring'],
                    ['id_subkategori' => 14, 'nama_subkategori' => 'gelas'],
                    ['id_subkategori' => 15, 'nama_subkategori' => 'wajan'],
                    ['id_subkategori' => 16, 'nama_subkategori' => 'mangkok'],
                ],
            ],
        ];

        DB::transaction(function () use ($data) {
            foreach ($data as $kategoriData) {
                // Update data kategori
                Kategori::where('id_kategori', $kategoriData['id_kategori'])
                    ->update(['nama_kategori' => $kategoriData['nama_kategori']]);

                // Update data subkategori
                foreach ($kategoriData['subkategori'] as $subkategoriData) {
                    SubKategori::where('id_subkategori', $subkategoriData['id_subkategori'])
                        ->update(['nama_subkategori' => $subkategoriData['nama_subkategori']]);
                }
            }
        });

        return response()->json(['message' => 'Kategori dan subkategori berhasil diperbarui.']);
    }



}
