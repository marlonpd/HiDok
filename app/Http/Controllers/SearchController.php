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
    	$account= $request->input('account');
      $name= trim($request->input('name'));
      $location= trim($request->input('location'));

      if($account == 'doctor')
      {
          $specialization = trim($request->input('specialization'));
          $doctors = array();

          if($name != '' && $specialization == '' && $location == '')
          {
              $doctors = User::orWhere('lastname', 'like',  '%'.$name.'%')
                             ->orWhere('firstname', 'like', '%'.$name.'%' )
                             ->orWhere('middlename', 'like', '%'.$name.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))  
                             ->get();

          }elseif ($name != '' && $specialization != '' && $location == '') {
              $doctors = User::orWhere('lastname', 'like',  '%'.$name.'%')
                             ->orWhere('firstname', 'like', '%'.$name.'%' )
                             ->orWhere('middlename', 'like', '%'.$name.'%' )
                             ->where('specialization', 'like', '%'.$specialization.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))  
                             ->get();
          }elseif ($name != '' && $specialization != '' && $location != '') {
              $doctors = User::orWhere('lastname', 'like',  '%'.$name.'%')
                             ->orWhere('firstname', 'like', '%'.$name.'%' )
                             ->orWhere('middlename', 'like', '%'.$name.'%' )
                             ->where('specialization', 'like', '%'.$specialization.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))  
                             ->where('address', 'like', '%'.$location.'%' )
                             ->get();

          }elseif ($name == '' && $specialization == '' && $location == '') {
              $doctors =array();
            # code...
          }elseif ($name == '' && $specialization != '' && $location == '') {
              $doctors = User::where('specialization', 'like', '%'.$specialization.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor')) 
                             ->get();
          }elseif ($name == '' && $specialization != '' && $location != '') {
              $doctors = User::where('specialization', 'like', '%'.$specialization.'%' )
                             ->where('address', 'like', '%'.$location.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))  
                             ->get();  
          }elseif ($name == '' && $specialization == '' && $location != '') {
              $doctors = User::where('address', 'like', '%'.$location.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))   
                             ->get();
          }elseif ($name != '' && $specialization == '' && $location != '') {
              $doctors = User::orWhere('lastname', 'like',  '%'.$name.'%')
                             ->orWhere('firstname', 'like', '%'.$name.'%' )
                             ->orWhere('middlename', 'like', '%'.$name.'%' )
                             ->orWhere('address', 'like', '%'.$location.'%' )
                             ->where('account_type', '=', config('constants.account_type.doctor'))  
                             ->get();
          }

          return view('doctor/search', compact('doctors','name','location', 'specialization'));

      }
      else
      {
        if($location != '' && $name != '')
        {
            $non_humans = User::where('name', 'like',  '%'.$name.'%')
                              ->where('address', 'like', '%'.$location.'%' )
                              ->where('account_type', '=', config('constants.account_type.'.$account)) 
                              ->get();
        }
        elseif ($location == '' && $name != '') 
        {
            $non_humans = User::where('name', 'like',  '%'.$name.'%')
                              ->where('account_type', '=', config('constants.account_type.'.$account)) 
                              ->get();
        
        }
        elseif ($location != '' && $name == '') 
        {
            $non_humans = User::where('address', 'like',  '%'.$location.'%')
                              ->where('account_type', '=', config('constants.account_type.'.$account)) 
                              ->get();
        
        }

        return view('pages/search', compact('non_humans','name','location', 'account'));
      }

    	
    }
}
