<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Config;

class CustomUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response_message = Config::get('constants.response_message');
        try {
            
            $user = Auth::user();
            $now = Carbon::now()->toDateTimeString();
            $lastActivity= $user->login_dateTime;
            $isExpired = $now >= $lastActivity;
            if($isExpired) {
                $error_status = 401;
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
            return $next($request);
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