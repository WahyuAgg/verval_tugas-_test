<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefindsUser;

class LoginController extends Controller
{
    //
    public function login(Request $request){

        // validaasi input
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        // check kredensial
        $user = RefindsUser::where('nama_akun', $request->nama_akun)->first();

        if ($user && password_verify($request->password, $user->password)) {
            $token = $user->createToken('UserRegister')->plainTextToken;

            return response()->json(['message' => 'login succcesful', 'token' => $token]);
        }

        return response()->json(['message' => 'invalid credentials']);
    }
}
