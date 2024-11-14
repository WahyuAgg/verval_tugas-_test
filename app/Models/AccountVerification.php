<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AccountVerification extends Model
{
    use HasFactory;

    protected $table = 'account_verifications';

    protected $fillable = [
        'id_user',
        'verification_token',
        'expires_at',
        'status',
    ];

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
