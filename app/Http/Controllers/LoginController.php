<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefindsUser;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefindsUser;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email
        $user = RefindsUser::where('email', $request->email)->first();

        if ($user) {
            // Periksa apakah verification_date kosong (akun belum diverifikasi)
            // if (is_null($user->verification_date)) {
            //     return response()->json([
            //         'message' => 'Account is not verified.',
            //         'user_id' => $user->id_user,
            //         'email' => $user->email
            //     ], 403); // 403 Forbidden untuk akun yang belum diverifikasi
            // }

            // Verifikasi password
            if (password_verify($request->password, $user->password)) {
                // Buat token untuk user
                $token = $user->createToken('UserLogin')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token
                ], 200);
            }
        }

        // Respon jika kredensial tidak valid
        return response()->json(['message' => 'Invalid credentials'], 401); // 401 untuk akses tidak sah
    }


}

