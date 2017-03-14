<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DoctorPatient;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
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

    //api/patients/my/get 
    public function api_patients_my_get()
    {
    	if(Auth::user()->is_doctor())
    	{
    		$patients = Patient::where('doctor_id','=' , Auth::user()->id)
    						   ->get();

  			return json_pretty(['patients' => $patients]);
    	}
    }

    //api/doctors/my/get
    public function api_doctors_my_get()
    {
    	if(Auth::user()->is_patient())
    	{
    		$doctors = Patient::where('patient_id','=' , Auth::user()->id)
    						   ->get();

  			return json_pretty(['doctors' => $doctors]);
    	}
    }
}
