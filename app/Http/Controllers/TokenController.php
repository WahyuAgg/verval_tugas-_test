<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function verifyToken(Request $request)
    {
        // If the user is authenticated, the token is valid
        return response()->json(['message' => 'Token is valid'], 200);
    }
}
