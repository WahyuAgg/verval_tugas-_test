<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // mengecualikan CSRF untuk semua api/
        'api/*'
        // 'api/register',
        // 'api/csrf-token',
        // 'api/login',
        // 'api/data'
    ];

}
