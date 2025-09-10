<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s+(.+)/', $authHeader, $matches)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $matches[1];
        $tokenHash = hash('sha256', $token);

        $user = User::where('api_token', $tokenHash)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // thiết lập user cho hệ thống auth/request
        Auth::loginUsingId($user->id);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
