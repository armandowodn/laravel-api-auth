<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CommonUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $isExpired = false;
        $hasRole = $user->hasRole('common_user');

        if($isExpired) {
            $data = [
                'msg' => 'Session Expired, Please Login',
                'data' => [],
                'success' => false,
                'msgType' => 'error',
                'msgTitle' => 'Error!'
            ];
            return response()->json($data, 401);
        }else if($hasRole == false) {
            $data = [
                'msg' => 'You do not have permission to access this resource.',
                'data' => [],
                'success' => false,
                'msgType' => 'error',
                'msgTitle' => 'Access Denied'
            ];
            return response()->json($data, 403);
        }
        return $next($request);
    }
}