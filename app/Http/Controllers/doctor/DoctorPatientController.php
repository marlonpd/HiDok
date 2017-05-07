<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DoctorPatient;


class DoctorPatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        if(Auth::user()->is_patient())
    	{
            return view('patient/doctors');
        }
        else if(Auth::user()->is_doctor())
        {
            return view('doctor/patients');
        }
    }

    ///api/patient/remove/post
    public function api_patient_remove_post(Request $request)
    {
    	$patient = Patient::findOrFail($request->input('id'));
    	
    	if($patient->destroy())
    	{
 			return json_pretty(['status' => 'success']);  
        }
        else
        {
 			return json_pretty(['status' => 'error']);
        }
    }

    //api/user/patients/get 
    public function api_user_patients_get(Request $request)
    {
    	if(Auth::user()->is_doctor())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $patients = DoctorPatient::with('patient')
                                         ->where('doctor_id','=' , Auth::user()->id)
                                         ->take(10)
                                         ->orderBy('created_at', 'ASC')
                                         ->get();
                
                
            }
            else
            {
                $patients = DoctorPatient::with('patient')
                                         ->where('doctor_id','=' , Auth::user()->id)
                                         ->where('created_at', '>' , $lastdate)
                                         ->take(10)
                                         ->orderBy('created_at', 'ASC')
                                         ->get();
            }
            $remaining = 0;
            $lastitem = $patients->last();
            
            if($lastitem)
            {
                $remaining = DoctorPatient::where('doctor_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['patients'  => $patients ,
                                'remaining' => $remaining,
                            ]);
    	}
    }

    //api/user/doctors/get
    public function api_user_doctors_get(Request $request)
    {
    	if(Auth::user()->is_patient())
    	{
            $lastdate= $request->input('lastdate');
            $searchkey = $request->input('searchkey');

            if($lastdate == '')
            {
                $doctors = DoctorPatient::with('doctor')
                                         ->where('patient_id','=' , Auth::user()->id)
                                         ->take(10)
                                         ->orderBy('created_at', 'ASC')
                                         ->get();
                
                /*Person::join('phoneboookentry', 'person.id', '=', 'phoneboookentry.person_id')
                        `                    ->get('person.*');*/
                
            }
            else
            {
                $doctors = DoctorPatient::with('doctor')
                                         ->where('patient_id','=' , Auth::user()->id)
                                         ->where('created_at', '>' , $lastdate)
                                         ->take(10)
                                         ->orderBy('created_at', 'ASC')
                                         ->get();
            }
            $remaining = 0;
            $lastitem = $doctors->last();
            
            if($lastitem)
            {
                $remaining = DoctorPatient::where('patient_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['doctors'  => $doctors ,
                                'remaining' => $remaining,
                            ]);
    	}
    }

    public function api_request_connect()
    {
        if(Auth::user()->is_patient())
    	{
    		$doctors = DoctorPatient::where('patient_id','=' , Auth::user()->id)
    						        ->get();
            
            if($doctors)
            {
                return json_pretty(['status' => 'error']);
            }
            else
            {
                //$patient = New 

                //return json_pretty(['status' => 'success']);
            }

  			
    	}
    }
}
