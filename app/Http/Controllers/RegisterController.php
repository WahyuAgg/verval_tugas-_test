<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RefindsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * untuk mengupload data registrasi
     */
    public function register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_akun' => 'required|string|max:255',
            'nama_asli_user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:refindsuser',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat pengguna baru
        $user = RefindsUser::create([
            'nama_akun' => $request->nama_akun,
            'nama_asli_user' => $request->nama_asli_user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_registrasi' => now(),
            'status_akun' => 'active',
        ]);

        // Kembalikan respons sukses tanpa token
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user], 201);
    }
}
