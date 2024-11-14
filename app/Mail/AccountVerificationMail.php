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
        $frontendUrl = config('app.frontend_url'); // Ambil URL frontend dari .env

        return $this->subject('Account Verification')
                    ->view('emails.account_verification')
                    ->with([
                        'verificationUrl' => "{$frontendUrl}/verify_account/{$this->token}",
                    ]);
    }
}
