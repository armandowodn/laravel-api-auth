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

    public function DBupdate_single($table = "",$arr,$whereClause,$conn = "mysql"){
        try {
            $set_string = "";
            $whereClause_string = "";
            foreach ($arr as $key => $val) {
                $set_string .= $key." = '".$val."',";
            }

            foreach ($whereClause as $key) {
                $aa = "";
                foreach ($key as $j => $val) {
                    if((count($key) - 1) == $j) {
                        $val = '"'.$val.'"';
                    }
                    $aa .= $val." ";
                }
                $whereClause_string .= $aa." AND ";
            }
            
            $set_string = rtrim($set_string, ',');
            $whereClause_string = " WHERE ".rtrim($whereClause_string, ' AND ');
            $query = "UPDATE ".$table." SET ".$set_string." ".$whereClause_string.";";
            DB::connection($conn)->update($query);
            return true;
        }catch (\Exception $e) {
            return false;
        }
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
        $error_status = 500;
        $response_message = Config::get('constants.response_message');
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
