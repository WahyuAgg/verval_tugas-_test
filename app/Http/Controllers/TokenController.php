<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * untuk verifikasi token
     */
    public function verifyToken(Request $request)
    {
        //
        return response()->json(['message' => 'Token is valid'], 200);
    }
}
