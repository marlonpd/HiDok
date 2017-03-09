<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    	 /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
      // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($account_type,$id)
    {	
    	$user = User::findOrFail($id);
    
        return view($account_type.'/profile', compact('user'));
    }
}
