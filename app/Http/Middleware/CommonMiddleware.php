<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = Auth::user();

            $allowedRoles = ['USER', 'ADMIN'];

            if (in_array($user->role, $allowedRoles)) {
                return $next($request);
            }

            return response()->json([
                'message' => 'You (' . strtolower($user->role) . ') are not allowed. Allowed roles are: ' . implode(', ', array_map('strtolower', $allowedRoles)),
            ], 401);

        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Unauthorized: ' . $exception->getMessage(),
            ], 401);
        }
    }

}
