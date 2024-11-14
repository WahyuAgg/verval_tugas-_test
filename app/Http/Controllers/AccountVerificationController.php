<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountVerification;
use App\Models\RefindsUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccountVerificationController extends Controller
{
    /**
     * Generate a verification token and send it to the user.
     */
    public function sendVerificationToken(Request $request)
    {
        // Validasi data request
        $request->validate([
            'email' => 'required|email|exists:refindsuser,email',
        ]);

        // Cari user berdasarkan email
        $user = RefindsUser::where('email', $request->email)->first();

        // Buat token verifikasi baru
        $token = Str::random(60);

        // Simpan atau update token verifikasi di database
        AccountVerification::updateOrCreate(
            ['id_user' => $user->id_user],
            [
                'verification_token' => $token,
                'expires_at' => Carbon::now()->addHours(24),
                'status' => 'pending',
            ]
        );

        // Kirimkan token ke pengguna (misal: melalui email)
        // Untuk tutorial ini, kita hanya mengembalikan token dalam response
        return response()->json([
            'message' => 'Verification token generated.',
            'verification_token' => $token
        ]);
    }


    public function verifyAccount(Request $request)
    {
        // Validasi request token
        $request->validate([
            'token' => 'required|string'
        ]);

        // Cari token di tabel account_verifications
        $verification = AccountVerification::where('verification_token', $request->token)->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid verification token.'], 404);
        }

        // Cek jika token sudah kadaluarsa
        if (Carbon::now()->greaterThan($verification->expires_at)) {
            $verification->update(['status' => 'expired']);
            return response()->json(['message' => 'Verification token has expired.'], 400);
        }

        // Verifikasi akun pengguna
        $verification->update(['status' => 'verified']);
        $verification->user->update([
            'status_akun' => 'active',
            'verification_date' => Carbon::now() // Mengisi tanggal verifikasi
        ]);

        return response()->json(['message' => 'Account successfully verified.']);
    }

}
