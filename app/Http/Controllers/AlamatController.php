<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;

class AlamatController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'id_user' => 'required|exists:refindsuser,id_user',
            'nama_lokasi' => 'required|string|max:255',
            'url_map' => 'nullable|url|max:255',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'deskripsi' => 'nullable|string|max:500',
            'is_default' => 'nullable|boolean'
        ]);

        // Create a new address record
        $alamat = Alamat::create($validatedData);

        // Return response
        return response()->json([
            'message' => 'Alamat berhasil ditambahkan',
            'data' => $alamat
        ], 201);
    }
}

