<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\RefindsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class RefindsUserController extends Controller
{
    /**
     * untuk menagmbil user data
     */
    public function getUserData(Request $request)
    {
        // Log::info('Request headers: ', $request->headers->all());

        // mengambil data user dengan alamat yangterkait
        $user = RefindsUser::with('alamat')->find($request->user());

        if ($user) {

            //logging
            // Log::info('User Data: ', $user->toArray());
            // Log::info('LogUser Ditemukan');
            return response()->json($user);
        }

        return response()->json(['error' => 'User not found'], 404);
        Log::info('Log User Tidak Ditemukan');
    }



    /**
     * untuk mengupdate user data
     */
    public function updateUserData(Request $request)
    {
        /** @var RefindsUser $user */

        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Pengguna belum terautentikasi.'], 401);
        }

        $request->validate([
            'nama_akun' => 'required|string|max:255',
            'nama_asli_user' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:refindsuser,email,' . $user->id_user . ',id_user',
            'no_telepon' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        try {
            // Tangani upload foto profil jika ada
            if ($request->hasFile('foto_profil')) {

                Log::info("Ada foto profil yang diunggah.");

                $path = $request->file('foto_profil')->store('pfp_images', 'public');

                // Log path foto profil yang telah diunggah
                Log::info("Foto profil baru diunggah.", ['path' => $path]);

                // Menyimpan path relatif foto profil
                $user->url_foto_profil = 'storage/' . $path;
            }

            // Update data pengguna
            $user->update($request->only(['nama_akun', 'nama_asli_user', 'email', 'no_telepon']));

            return response()->json([
                'status' => 'success',
                'message' => 'Pengguna berhasil diperbarui',
                'data' => ['user' => $user],
            ], 200);
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            Log::error('Gagal memperbarui pengguna:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan, coba lagi nanti.'], 500);
        }
    }


}
