<?php


// app/Http/Controllers/UlasanController.php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * untuk membuat ulasan dari transaksi terpilih
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required|exists:transaksi,id_transaksi',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'tanggal_ulasan' => 'required|date',
        ]);

        Ulasan::create([
            'id_transaksi' => $request->id_transaksi,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'tanggal_ulasan' => $request->tanggal_ulasan,
        ]);

        return response()->json(['message' => 'Ulasan berhasil disimpan.'], 201);
    }
}
