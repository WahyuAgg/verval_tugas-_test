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
        // Validate input
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);

        // Check credentials using 'email' instead of 'nama_akun'
        $user = RefindsUser::where('email', $request->email)->first();

        if ($user && password_verify($request->password, $user->password)) {
            // Create a token for the user
            $token = $user->createToken('UserRegister')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401); // Use 401 for unauthorized access
    }
}

