<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Common\Helper;

class RoleMasterController extends Controller
{
    public function list(Request $req){
        $Helper = new Helper;
        try {
            $params = $req->params;
            $data = [];
            return $Helper->info($data);
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function get($id){
        $Helper = new Helper;
        try {
            $params = $id;
            $data = [];
            return $Helper->info($data);
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function insert(Request $req){
        $Helper = new Helper;
        try {
            $params = $req->params;
            $exist = DB::table('roles')->where('name',$params['name'])->first();
            if($exist) {
                return $Helper->invalid("Already taken.",$params);
            }else {
                Role::create(['name' => $params['name'], 'guard_name' => 'web']);
                return $Helper->ok("Saved",$params);
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function update($id,$name){
        $Helper = new Helper;
        try {
            $exist = DB::table('roles')
            ->where('name', $name)
            ->where('id', '!=', $id)
            ->first();
            if($exist) {
                return $Helper->invalid("Already taken.");
            }else {
                DB::table('roles')->where('id',$id)->update([
                    'name' => $name
                ]);
                return $Helper->ok("Update");
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
    public function delete($id){
        $Helper = new Helper;
        try {
            $exist = DB::table('roles')->where('id',$id)->first();
            if($exist) {
                DB::table('roles')->where('id',$id)->delete();
                return $Helper->ok("Deleted");
            }else {
                return $Helper->invalid("Details not Exist");
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
}
