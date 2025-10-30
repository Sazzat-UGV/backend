<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        if ($user->email_verified_at === null) {
            return response()->json([
                'message' => 'Your account is not verified. Please verify your email to access this resource.',
            ], 403);
        }

        return $next($request);
    }
}
