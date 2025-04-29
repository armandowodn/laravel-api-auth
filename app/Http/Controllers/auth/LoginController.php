<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Common\Helper;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
class LoginController extends Controller
{
    //
    public function index(Request $req){
        $Helper = new Helper;
        try {
            $username = $req->username;
            $password = $req->password;

            $check_user = User::where(['user_name' => $username ])->select(['id','password'])->first();
            if($check_user) {
                if(!Hash::check($password, $check_user->password)) {
                    return $Helper->invalid("Incorrect Password.");
                }
                else {
                    $LOGIN_SESSION_TIME_OUT = Config::get('constants.LOGIN_SESSION_TIME_OUT');
                    $lastActivity = Carbon::now()->addMinutes($LOGIN_SESSION_TIME_OUT)->toDateTimeString();
                    
                    $table = "users";
                    $upt_setarr["updated_at"] = $lastActivity;
                    $upt_setarr["login_dateTime"] = $lastActivity;

                    $upt_wherearr = [];
                    array_push($upt_wherearr,['id','=',$check_user->id]);

                    $success = $Helper->DBupdate_single($table,$upt_setarr,$upt_wherearr);

                    $user = User::where('id', $check_user->id)->first();
                    $token = $user->createToken('API Token')->plainTextToken;
                    return $Helper->info([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                }
            }else {
                return $Helper->invalid("User Name not found.",[
                    'user_name' => $username
                ]);
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
}
