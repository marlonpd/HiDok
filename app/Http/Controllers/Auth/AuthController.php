<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }


    public function api_auth_user_get()
    {
    	$user = Auth::user();
    	$user['avatar'] = Auth::user()->avatar();
    	$user['fullname'] = Auth::user()->fullname();

    	return response()->json(['user' =>$user]);
    }

}
