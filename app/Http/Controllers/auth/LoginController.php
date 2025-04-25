<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Common\Helper;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function index(Request $req){
        $Helper = new Helper;
        try {
            $email = $req->email;
            $password = $req->password;

            $check_user = User::where(['email' => $email ])->select(['id','password'])->first();
            if($check_user) {
                if(!Hash::check($password, $check_user->password)) {
                    return $Helper->invalid("Incorrect Password.");
                }
                else {
                    $user = User::where('id', $check_user->id)->first();
                    $token = $user->createToken('API Token')->plainTextToken;
                    return $Helper->info([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                }
            }else {
                return $Helper->invalid("Email not found.",[
                    'email' => $email
                ]);
            }
        }catch (\Exception $e) {
            return $Helper->error();
        }
    }
}
