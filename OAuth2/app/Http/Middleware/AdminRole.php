<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized. Only admin users are allowed to access this resource.',
        ], 401);
    }
}
