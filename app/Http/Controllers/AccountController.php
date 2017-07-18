<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AccountController extends Controller
{
    public function __construct()
    {

    }
    
    public function index($id , $activation_code)
    {
        $user = User::find($id);

        if($user->activation_code == $activation_code)
        {
            if($user->activated == config("constants.account_status.activated"))
            {
                $message = "Account is already activated, you can now login";
            }
            else
            {
                $user->activated = config("constants.account_status.activated");
                $user->save();
                $message = "Congrats!, your account has been successfully activated. You can now login.";
            }
            
        }
        else
        {
            $message = "Invalid activation code or account does not exist.";
        }

        return view('account_activation', compact('message'));
    }


    public function forgot_account()
    {
        return view('forgot_account');
    }

    public function resend_activation(Request $request)
    {
        return view('account_resend_activation');
    }


    public function api_send_password_reset_email_post(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email' ,'=', $email)
                    ->first();
        
        if($user)
        {
            $user->reset_password_code = str_random(20);
            $user->save();

            $data =  array('reset_password_code' => $user->reset_password_code,
                        'url'        => env('APP_DOMAIN'),
                        'email'      => $user->email,
                        'from'       => env('MAIL_USERNAME'),
                        'id'         => $user->id,
                    );
            \Mail::send('email.password_reset', $data, function($message) use ($user)
            {   
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->to($user->email, $user->first_name)->subject(env('APP_NAME').' Password Reset Request');
            });

            return json_pretty(['status' => 'success']); 
        }
        else
        {
            return json_pretty(['status' => 'email_not_registered']); 
        }
    }

    public function account_password_reset($id ,$reset_password_code)
    {

        $user = User::findOrfail($id);
        if($reset_password_code == $user->reset_password_code)
        {
            return view('reset_password', compact('user'));
        }
        else
        {
            return view('errors.invalid_link');
        }
    }


    public function api_reset_password_post(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $reset_password_code = $request->input('reset_password_code');


        $user = User::where('email' , '=' , $email)
                    ->first();
        if($user->reset_password_code == $reset_password_code)
        {
        
            $user->password = bcrypt($password);
            $user->reset_password_code ='';

            if($user->save())
            {
                return json_pretty(['status' => 'success']);
            
            }
            else
            {
                return json_pretty(['status' => 'error']);
            }
        }
        else
        {
            return json_pretty(['status' => 'invalid_reset_code']);
        }
    }

    public function api_resend_account_activation(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', '=' ,$email)
                    ->first();
    
        if($user)
        {
            return $this->send_email($user);
        }
        else
        {
             return json_pretty(['status' => 'error']);
        }
    }

    public function send_email($user)
    {   
 
        $data =  array('firstname'       => $user->first_name,
                       'id'              => $user->id, 
                       'lastname'        => $user->last_name,
                       'activation_code' => $user->activation_code,
                       'url'             => env('APP_DOMAIN'),
                       'email'           => $user->email,
                       'from'            => env('MAIL_USERNAME'),
                 );

        \Mail::send('email.account_activation', $data, function($message) use ($user)
        {   
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to($user->email, $user->first_name)->subject(env('APP_NAME').' Account Activation');
        });

        return json_pretty(['status' => 'success']); 

        //return '<a href="/account/activation/'.$activation_code.'">click here</a>'; 
        
    }
}
