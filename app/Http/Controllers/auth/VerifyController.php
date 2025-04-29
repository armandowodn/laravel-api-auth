<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Common\Helper;

class VerifyController extends Controller
{
    public function index(Request $req){
        $Helper = new Helper;
        return $Helper->info([
            'access_token' => 'test',
        ]);
    }
    public function save(Request $req){
        return 'saved';
    }
}
