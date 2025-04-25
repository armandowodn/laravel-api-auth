<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        $requestFromAjax = $request->ajax();
        $user = Auth::user();
        foreach ($role as $permission) {
            if ($user && Auth::user()->hasRole($role)) {
                return $next($request);
            }
        }
        return response()->json([
            'msg' => 'You do not have access rights this resource.',
            'data' => [],
            'success' => false,
            'msgType' => 'error',
            'msgTitle' => 'Access Denied'
        ], 403);
    }
}
