<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;



use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function login_post(Request $request)
    {
        if($request->isMethod('post'))
        {
            $email = $request->input("email");
            $password = $request->input("password");

            $user = User::where('email' , '=' , $email)->first();

            if($user)
            {
                if($user->activated == 0)
                {
                    return "not_activated"; 
                }

                if(Auth::attempt(['email' => $email, 'password' => $password])) 
                {
                    return "success";
                } else {
                    return "error";
                }
            }
            else
            {
                    return "error";
                
            }
        }
    }
}
