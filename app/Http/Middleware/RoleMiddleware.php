<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        $response_message = Config::get('constants.response_message');
        try {
            $requestFromAjax = $request->ajax();
            $user = Auth::user();
            foreach ($role as $permission) {
                if ($user && Auth::user()->hasRole($role)) {
                    return $next($request);
                }
            }
            $error_status = 403;
            $error = $response_message[$error_status];
            $data = [
                'msg' => $error['msg'],
                'data' => [],
                'success' => false,
                'msgType' => $error['msgType'],
                'msgTitle' => $error['msgTitle'],
            ];
            return response()->json($data, $error_status);
        }catch (\Exception $e) {
            $error_status = 500;
            $error = $response_message[$error_status];
            $data = [
                'msg' => $error['msg'],
                'data' => [],
                'success' => false,
                'msgType' => $error['msgType'],
                'msgTitle' => $error['msgTitle'],
            ];
            return response()->json($data, $error_status);
        }
    }
}
