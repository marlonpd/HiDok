<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appointment;
use App\Schedule;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{
   	

   	public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {   
    	if(Auth::user()->is_doctor())
        {

            $schedules = Schedule::where('user_id' , '=' ,Auth::user()->id)
                                 ->get();

        	return view('doctor/appointment', compact('schedules'));
        }
        else
        {
        	return view('patient/appointment');
        }
    }

    public function api_appointment_request_post(Request $request)
    {

    	$appointment = $this->createAppointment($request->input());

        if($appointment)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }

    protected function createAppointment(array $data)
    {
        return Appointment::create([
        	 			    'schedule_id' => $data['schedule_id'],			
				            'doctor_id'   => $data['doctor_id'],
				            'patient_id'  => Auth::user()->id,
                            'creator_id'  => 0,
                            're_schedule_by_id' => 0, 
				            'appointment_date' =>  date("Y-m-d H:i:s", strtotime($data['appointment_date'])),
				            'note'     => '',
				   			]);
    }


    public function api_auth_schedule_appointment_get($schedule_id)
    {

        if(Auth::user()->is_doctor())
        {
            $appointments = Appointment::with('patient')
                                    ->where('schedule_id' , '=' ,$schedule_id )
                                    ->get();

        }
        else
        {                        
            $appointments = Appointment::with('doctor')
                                       ->where('schedule_id' , '=' ,$schedule_id )
                                       ->get();
        }                

        return json_pretty(['appointments' => $appointments]);
    }

    public function api_auth_appointment_get()
    {
    	$user_id = Auth::user()->id;

    	if(Auth::user()->is_doctor())
    	{
        	$appointments = Appointment::with('patient')
                                       ->where('doctor_id' , '=' ,$user_id )
    								   ->get();
    	}
        else
        {
        	$appointments = Appointment::with('doctor')
                                       ->where('patient_id' , '=' ,$user_id )
						  			   ->get();
        }


        return $this->json_pretty(['appointments' => $appointments]);                    
 
    }

    //api/appointment/update/post
    /*public function api_appointment_update_post(Request $request)
    {
    	$id = $request->input('id');

        $appointment = Appointment::findOrFail($id);

    	$appointment->update(['note' => $request->input('note'),
    						  'appointment_date' => $request->input('note'),	
    						]);

    	if($appointment)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }*/

    //api/appointment/confirm/post
    public function api_appointment_confirm_post(Request $request)
    {
    	$id = $request->input('id');

        $appointment = Appointment::findOrFail($id);

    	$appointment->update(['confirmed' => 1]);

    	if($appointment)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }

    //api/appointment/reschedule/post
    public function api_appointment_reschedule_post(Request $request)
    {
        $id = $request->input('id');

        $appointment = Appointment::findOrFail($id);

        $appointment->update(['appointment_date' => date("Y-m-d H:i:s", strtotime($request->input('appointment_date'))),
                              'note' =>  $request->input('note'),
                      ]);

        if($appointment)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }


    //api/appointment/delete/post
    public function api_appointment_delete_post(Request $request)
    {

    	$appointment = Appointment::destroy($request->input());

        if($appointment)
        {
            return "success";
        }
        else{
            return "error";
        }
    }


  /*  public function json_pretty($str)
    {
        return \Response::make(json_encode($str, JSON_PRETTY_PRINT))
                        ->header('Content-Type', "application/json");
    }
*/
}
