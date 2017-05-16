<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appointment;
use App\User;
use App\ITR;
use Illuminate\Support\Facades\Auth;

class ITRController extends Controller
{
    

	public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create_itr($consultation_type , $patient_id)
    {
        
        return view('patient/create_itr');
    }


    public function patient_itr($id)
    {
    	if(Auth::user()->is_doctor())
        {
        	$user = User::findOrFail($id);

            $appointments = Appointment::where('patient_id' , '=' ,$id )
            						   ->where('doctor_id', '=', Auth::user()->id)	
            						   ->where('confirmed' , '=' ,config('constants.appointment_status.consult') )
                                       ->get();

                           
        	return view('doctor/patient_itr', compact('user','appointments'));
        }
        else
        {
	        $appointments = Appointment::where('patient_id' , '=' ,Auth::user()->id )
		    						   ->where('confirmed' , '=' ,config('constants.appointment_status.consult') )
		                               ->get();

		    $user = Auth::user();
		                               
        	return view('patient/itr',compact('user','appointments'));
        }

        
    }


    public function api_patient_itr_get($id)
    {
    	if(Auth::user()->is_doctor())
        {
        	$user = User::findOrFail($id);

            $appointments = Appointment::where('patient_id' , '=' ,$id )
            						   ->where('doctor_id', '=', Auth::user()->id)	
            						   ->where('confirmed' , '=' ,config('constants.appointment_status.consult') )
                                       ->get();
            $appointment_itr = array();                           

            foreach ($appointments as $appointment) 
            {

                $appointment_itr[$appointment->id] = ITR::with('patient')
                                       	                ->where('appointment_id' , '=' ,$appointment->id )
                                                        ->get();
            

            }   

        	return json_pretty(['appointment_itr' => $appointment_itr]);      
        }
        else
        {


            $appointments = Appointment::where('patient_id' , '=' ,Auth::user()->id )
            						   ->where('confirmed' , '=' ,config('constants.appointment_status.consult') )
                                       ->get();
            $appointment_itr = array();                           

            foreach ($appointments as $appointment) 
            {

                $appointment_itr[$appointment->id] = ITR::with('patient')
                                       	                ->where('appointment_id' , '=' ,$appointment->id )
                                                        ->get();
            

            }   

        	return json_pretty(['appointment_itr' => $appointment_itr]);   

        }

    }


    public function api_itr_assessment_post(Request $request)
    {
    	$id = $request->input('id');
    	$assessment = $request->input('assessment');

        $itr = ITR::findOrFail($id);

        $update = $itr->update(['assessment' => $assessment]);

        if($update)
        {
        	return "success";
        }
        else
        {
        	return "error";
        }
    }


    public function api_itr_laboratory_post(Request $request)
    {
    	$id = $request->input('id');
    	$laboratory = $request->input('laboratory');

        $itr = ITR::findOrFail($id);

        $update = $itr->update(['laboratory' => $laboratory]);

        if($update)
        {
        	return "success";
        }
        else
        {
        	return "error";
        }
    }


    public function api_itr_diagnosis_post(Request $request)
    {
    	$id = $request->input('id');
    	$diagnosis = $request->input('diagnosis');

        $itr = ITR::findOrFail($id);

        $update = $itr->update(['diagnosis' => $diagnosis]);

        if($update)
        {
        	return "success";
        }
        else
        {
        	return "error";
        }
    }


    public function api_itr_treatment_post(Request $request)
    {
    	$id = $request->input('id');
    	$treatment = $request->input('treatment');

        $itr = ITR::findOrFail($id);

        $update = $itr->update(['treatment' => $treatment]);

        if($update)
        {
        	return "success";
        }
        else
        {
        	return "error";
        }
    }


    public function print_diagnosis($id)
    {
    	return '
    	<div text-align="center" width="100%">
    	<p style="text-align:center;"><b>FAMILY MEDICAL CENTER</b><br>
    	<small>JP Laurel, Bajada<br>
    	Davao City</small></p>
        </div>
    	Patient Name : <u>Marlon Dizon</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Date: ____________<br>
    	<br>
    	<br>
    	RX:

    	Paracetamol

    	<br>
    	<br>
    	Refill : ______
    	<br>
    	<br>
    	Dr: <u>Vicky Bello </u>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 	      Sign: ____________
        <br>


    	<br><br>
    	<FORM>
		<INPUT TYPE="button" onClick="window.print()" value="PRINT">
		</FORM>
    	';
    }
}
