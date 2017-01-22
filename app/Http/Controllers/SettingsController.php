<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;


class SettingsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }


    public function index()
    {
        //session()->flash('flash_message', 'test');
    	return view('patient.settings');
    }


   


    public function profile(ProfileRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);

/*
        if($request->input('password') != "")
        {

            if( ($request->input('password_confirmation') == $request->input('password'))  )
            {

                return redirect('settings')
                               ->withInput()
                               ->withErrors(array('message' => 'Invalid new password.'));               
            }
        }*/

        $request->replace(array('password' => bcrypt($request->input('password'))));


        $user->update($request->all());       

        return redirect('settings');
    }

    public function makePhoto(UploadedFile $file)
    {


    }
}
