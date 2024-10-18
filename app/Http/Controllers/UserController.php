<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\RefindsUser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserData(Request $request)
    {
        Log::info('Request headers: ', $request->headers->all());
        $user = RefindsUser::with('alamat')->find($request->user());

        if ($user) {

            //logging
            Log::info('User Data: ', $user->toArray());
            Log::info('LogUser Ditemukan');
            return response()->json($user);
        }

        return response()->json(['error' => 'User not found'], 404);
        Log::info('LogUser Tidak Ditemukan');
    }
}

