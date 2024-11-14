<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        // Mengambil URL backend dari .env (APP_URL)
        $backendUrl = config('app.url');

        return $this->subject('Account Verification')
                    ->view('emails.account_verification')
                    ->with([
                        'verificationUrl' => "{$backendUrl}/verify_account/{$this->token}",
                    ]);
    }
}

