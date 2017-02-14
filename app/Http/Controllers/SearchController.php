<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;


class SearchController extends Controller
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
    public function index(Request $request)
    {	
    	$key= $request->input('key');

    	$doctors = User::where('lastname', 'like',  '%'.$key.'%')
   					->where('firstname', 'like', '%'.$key.'%' )
   					->where('middlename', 'like', '%'.$key.'%' )
   					->where('account_type', '=', config('constants.account_type.doctor'))	
   					->get();

   		$medical_facilities = User::where('name', 'like', '%' . $key . '%')
   								  ->where('account_type', '=', config('constants.account_type.medical_facility'))	
   								  ->get();



        return view('pages/search', compact('doctors' ,'medical_facilities'));
    }
}
