<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Common\Helper;
use App\Models\User;

class UserRoleController extends Controller
{
    public function insert(Request $req){
        $Helper = new Helper;
        try {
            $params = $req->params;
            $exist = DB::table('model_has_roles')->where([
                'role_id' => (int)$params['role_id'],
                'model_id' => (int)$params['user_id'],
            ])->first();
            $exist_role = DB::table('roles')->where([
                'id' => (int)$params['role_id']
            ])->first();
            if($exist) {
                return $Helper->invalid("Already taken.",$params);
            }else if($exist_role == null){
                return $Helper->invalid("Role is not Exist",$params);
            }else {
                $userInfo = User::where([
                    'id' => (int)$params['user_id']
                ])->first();
                $userInfo->assignRole($exist_role->name);
                return $Helper->ok("Saved",$params); 
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function delete($user_id,$role_id){
        $Helper = new Helper;
        try {
            $exist = DB::table('model_has_roles')->where([
                'role_id' => $role_id,
                'model_id' => $user_id,
            ])->first();
            if($exist) {
                DB::table('model_has_roles')->where([
                    'role_id' => $role_id,
                    'model_id' => $user_id,
                ])->delete();
                return $Helper->ok("Deleted");
            }else {
                return $Helper->invalid("Details not Exist");
            }
            
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
}
