<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Common\Helper;
use App\Models\User;

class UserPermissionController extends Controller
{
    //
    public function insert(Request $req){
        $Helper = new Helper;
        try {
            $params = $req->params;
            $exist = DB::table("model_has_permissions")->where([
                'permission_id' => $params['permission_id'],
                'model_id' => $params['user_id'],
            ])->first();
            if($exist) {
                return $Helper->invalid("Already taken.",$params);
            }else {
                $permissionsName = DB::table("permissions")->where('id',$params['permission_id'])->first();
                $addUserRole = User::where([
                    'id' => $params['user_id']
                ])->first();
                $addUserRole->givePermissionTo($permissionsName->name);
                return $Helper->ok("Saved",$params); 
            }
            
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function delete($user_id,$permsid){
        $Helper = new Helper;
        try {
            $exist = DB::table("model_has_permissions")->where([
                'permission_id' => $permsid,
                'model_id' => $user_id,
            ])->first();
            if($exist == null) {
                return $Helper->invalid("Details not Exist");
            }else {
                DB::table("model_has_permissions")->where([
                    'permission_id' => $permsid,
                    'model_id' => $user_id,
                ])->delete();
                return $Helper->ok("Deleted");
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }

}
