<?php
namespace App\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
class Helper
{
    public function updatedBy($arr = []){
        $arr['updated_at']  = Carbon::now('UTC');
        return $arr;
    }

    public function ok($msg = "",$data = []){
        $data = [
            'msg'      => $msg,
            'data'     => $data,
            'success'  => true,
            'msgType'  => 'success',
            'msgTitle' => 'Success!'
        ];
        return response()->json($data, 200);
    }
    public function invalid($msg = "",$data = []){
        $data = [
            'msg'      => $msg,
            'data'     => $data,
            'success'  => false,
            'msgType'  => 'invalid',
            'msgTitle' => 'Invalid!'
        ];
        return response()->json($data, 400);
    }
    public function info($data = []){
        $data = [
            'data' => $data,
            'success' => true,
        ];
        return response()->json($data, 200);
    }
    public function error(){
        $data = [
            'msg' => 'An error occured while processing your request. Please refresh the page and try again.',
            'data' => [],
            'success' => false,
            'msgType' => 'error',
            'msgTitle' => 'Error!'
        ];
        return response()->json($data, 500);
    }
}
