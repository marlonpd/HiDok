<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index($account_type)
    {
        return view($account_type.'/register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           // 'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
         //   'id'    => Uuid::generate(),
            'lastname'     => $data['lastname'],
            'firstname'    => $data['firstname'],
            'middlename'   => $data['middlename'],
            'email'        => $data['email'],
            'account_type' => $data['account_type'],
            'password'     => bcrypt($data['password']),
            'photo'        => config('constants.default_photo'),
        ]);
    }

    protected function create_non_human_account(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'account_type' => $data['account_type'],
            'password' => bcrypt($data['password']),
        ]);
    }


    protected function post_register(request $request)
    {
        $this->validator($request->all())->validate();

        $account_type = $request->input('account_type');
        
        if($account_type == config('constants.account_type.patient') || $account_type == config('constants.account_type.doctor') )
        {
            event(new Registered($user = $this->create($request->all())));
        }
        else
        {
            event(new Registered($user = $this->create_non_human_account($request->all())));
        }
        
        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    
    }


}
