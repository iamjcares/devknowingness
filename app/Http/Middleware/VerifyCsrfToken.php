<?php

namespace Knowingness\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{

    //add an array of Routes to skip CSRF check
    protected $except = ['stripe/webhook', 'paypal.*', 'payment/*'];

}
