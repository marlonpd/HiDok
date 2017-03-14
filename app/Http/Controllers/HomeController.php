<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Appointment;
use App\Clinic;

class HomeController extends Controller
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
    public function index()
    {
        if(!Auth::check())
        {
            return view('pages/home');
        }
        else
        {
            if(Auth::user()->is_patient())
            {
                $appointments = Appointment::where('patient_id' , '=' ,Auth::user()->id )
                                           ->where('confirmed' , '=' ,config('constants.appointment_status.consult') )
                                           ->get();

                $user = Auth::user();
                                    
                return view(config('constants.account_type_rev.'.Auth::user()->account_type).'/home',compact('user','appointments'));
            }
            else
            {
                $clinics = Clinic::where('doctor_id' , '=' ,Auth::user()->id)
                                 ->get();

                return view(config('constants.account_type_rev.'.Auth::user()->account_type).'/home',compact('clinics'));
            }
        }

    }


    public function header()
    {
        return view('header');
    }
}
