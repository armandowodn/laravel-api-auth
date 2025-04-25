<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function index(Request $req){
        return 'verified auth';
    }
    public function save(Request $req){
        return 'saved';
    }
}
