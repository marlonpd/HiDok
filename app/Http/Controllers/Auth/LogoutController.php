<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class LogoutController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect('home');
    }
    
}
