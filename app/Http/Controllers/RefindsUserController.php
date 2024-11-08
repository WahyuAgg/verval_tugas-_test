<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\RefindsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class RefindsUserController extends Controller
{
    public function getUserData(Request $request)
    {
        Log::info('Request headers: ', $request->headers->all());

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

    public function getUserData2()
    {
        $userId = auth()->id();
        $user = RefindsUser::findOrFail($userId);
        return response()->json($user);
    }


    public function updateUserData(Request $request)
    {
        // PHPDoc comment that tells Intelephense (and other IDEs) that the variable $user is an instance of the RefindsUser model.
        /** @var RefindsUser $user */
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        // Validate request data
        $request->validate([
            'nama_akun' => 'required|string|max:255',
            'nama_asli_user' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:refindsuser,email,' . $user->id_user . ',id_user',
            'no_telepon' => 'required|string|max:15',
            'url_foto_profil' => 'nullable|url|max:255',
        ]);

        // Update user information
        $user->update($request->only(['nama_akun', 'nama_asli_user', 'email', 'no_telepon', 'url_foto_profil']));

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }



}
