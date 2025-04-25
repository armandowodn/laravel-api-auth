<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $requestFromAjax = $request->ajax();
        $user = Auth::user();
        foreach ($permissions as $permission) {
            if ($user && Auth::user()->can($permissions)) {
                return $next($request);
            }
        }
        return response()->json([
            'msg' => 'You do not have permission to access this resource.',
            'data' => [],
            'success' => false,
            'msgType' => 'error',
            'msgTitle' => 'Access Denied'
        ], 403);
        
    }
}
