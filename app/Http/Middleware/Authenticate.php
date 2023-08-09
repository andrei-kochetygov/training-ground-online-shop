<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        $response = response()->json([
            'message' => 'Unauthenticated.',
        ], 401);

        throw new HttpResponseException($response);
    }
}
