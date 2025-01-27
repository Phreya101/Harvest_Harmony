<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If the request expects JSON, return a 401 Unauthorized response
        if (!$request->expectsJson()) {
            return route('login');
        }

        // If the request expects JSON, return a JSON response indicating the user is unauthorized
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }
}
