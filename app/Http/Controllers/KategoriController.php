<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * get kategory data
     */
    public function getKategori(){
        $kategori = Kategori::get();

        return response()->json($kategori);
    }

    /**
     * get subkategori data
     */
    public function getSubkategori(){
        $subkategori = SubKategori::get();

        return response()->json($subkategori);
    }


    // hardcode fungsi





}
