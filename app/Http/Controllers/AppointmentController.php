<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appointment;
use App\Clinic;
use App\ITR;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\DoctorPatient;

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
            $clinics = Clinic::where('doctor_id' , '=' ,Auth::user()->id)
                                 ->get();

        	return view('doctor/appointment', compact('clinics'));
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
            return json_pretty(['status'      => 'success',
                                'appointment' => $appointment]);
        }
        else
        {
            return json_pretty(['status'      => 'error',
                                'appointment' => $appointment]);
        }
    }

    protected function createAppointment(array $data)
    {
        return Appointment::create(['clinic_id'         => $data['clinic_id'],			
                                    'doctor_id'         => $data['doctor_id'],
                                    'patient_id'        => Auth::user()->id,
                                    'creator_id'        => 0,
                                    're_schedule_by_id' => 0, 
                                    'appointment_date'  =>  date("Y-m-d H:i:s", strtotime($data['appointment_date'])),
                                    'note'              => '',
				   			]);
    }


    public function api_auth_appointment_get($clinic_id)
    {

        if(Auth::user()->is_doctor())
        {
            $appointments = Appointment::with('patient')
                                       ->where('clinic_id' , '=' ,$clinic_id )
                                       ->get();

        }
        else
        {                          
            $appointments = Appointment::with('doctor')
                                       ->where('clinic_id' , '=' ,$clinic_id )
                                       ->get();
        }                

        return json_pretty(['appointments' => $appointments]);
    }


    public function api_auth_appointment_patient_get()
    {
        if(Auth::user()->is_patient())
        {    
            $appointments = Appointment::with('doctor')
                                       ->get();

             return json_pretty(['appointments' => $appointments]);
        }                
    }

  /*  public function api_auth_appointment_get()
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
 
    }*/


    public function api_auth_appointment_all_get()
    {
        $user_id = Auth::user()->id;
        $appointments = array();

        if(Auth::user()->is_doctor())
        {
            $clinics = Clinic::where('doctor_id', '=', $user_id)
                              ->get();

            foreach ($clinics as $clinic) 
            {
                $appointments[$clinic->id] = Appointment::with('patient')
                                                        ->where('clinic_id' , '=' ,$clinic->id )
                                                        ->get();
            }
        }
        else
        {
            $appointments = Appointment::with('doctor')
                                       ->where('patient_id' , '=' ,$user_id )
                                       ->get();
        }


        return json_pretty(['appointments' => $appointments]);                     
    }

    // /' /api/appointments/get'
    public function api_appointments_get(Request $request)
    {
        if(Auth::user()->is_patient())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $appointments = Appointment::with('patient')
                                           ->with('doctor') 
                                           ->with('clinic')  
                                           ->where('patient_id','=' , Auth::user()->id)
                                           ->take(10)
                                           ->orderBy('created_at', 'ASC')
                                           ->get();
            }
            else
            {
                $appointments = Appointment::with('patient')
                                            ->with('doctor')
                                            ->with('clinic')
                                            ->where('patient_id','=' , Auth::user()->id)
                                            ->where('created_at','>' , $lastdate)
                                            ->take(10)
                                            ->orderBy('created_at', 'ASC')
                                            ->get();
            }
            $remaining = 0;
            $lastitem = $appointments->last();
            
            if($lastitem)
            {
                $remaining = Appointment::with('doctor')
                                        ->with('clinic')
                                        ->where('patient_id','=' , Auth::user()->id)
                                        ->where('created_at', '>' , $lastitem->created_at)
                                        ->count();
            }                      

  			return json_pretty(['appointments'  => $appointments ,
                                'remaining'     => $remaining,
                            ]);
    	}
        else
        {
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $appointments = Appointment::with('patient')
                                           ->with('clinic')
                                           ->where('doctor_id','=' , Auth::user()->id)
                                           ->take(10)
                                           ->orderBy('created_at', 'ASC')
                                           ->get();
            }
            else
            {
                $appointments = Appointment::with('patient')
                                            ->with('clinic')
                                            ->where('doctor_id','=' , Auth::user()->id)
                                            ->where('created_at', '>' , $lastdate)
                                            ->take(10)
                                            ->orderBy('created_at', 'ASC')
                                            ->get();
            }
            $remaining = 0;
            $lastitem = $appointments->last();
            
            if($lastitem)
            {
                $remaining = Appointment::with('patient')
                                        ->with('clinic')
                                        ->where('doctor_id','=' , Auth::user()->id)
                                        ->where('created_at', '>' , $lastitem->created_at)
                                        ->count();
            }                      

  			return json_pretty(['appointments'  => $appointments ,
                                'remaining'     => $remaining,
                            ]);
        }
    }

    //api/appointment/confirm/post
    public function api_appointment_confirm_post(Request $request)
    {
    	$id = $request->input('id');
        $appointment = Appointment::findOrFail($id);
    	$appointment->update(['confirmed' => config('constants.appointment_status.confirm')]);

    	if($appointment)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }


    public function add_patient( $patient_id)
    {
        $is_friend = DoctorPatient::where('patient_id' , '=' ,$patient_id)
                                  ->where('doctor_id' , '=',  Auth::user()->id)
                                  ->count();

        if($is_friend == 0)
        { 
            $patient = new DoctorPatient();
            $patient->patient_id = $patient_id;
            $patient->doctor_id = Auth::user()->id;
            $patient->save();
        }
    }

    //api/appointment/consult/post
    public function api_appointment_consult_post(Request $request)
    {
        $id = $request->input('id');
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['confirmed' => config('constants.appointment_status.consult')]);
        $timestamp = Carbon::now();

        ITR::create(['doctor_id'      => Auth::user()->id, 
                     'appointment_id' => $id,  
                     'patient_id'     => $appointment->patient_id , 
                     'assessment'     => '' ,
                     'laboratory'     => '' ,
                     'diagnosis'      => '' ,
                     'treatment'      => '',
                     'created_at'     => $timestamp,
                     'updated_at'     => $timestamp,
                    ]);


        if($appointment)
        {
            $this->add_patient($appointment->patient_id);
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


        $appointment->update(['appointment_date'  => date("Y-m-d H:i:s", strtotime($request->input('appointment_date'))),
                              'note'              =>  $request->input('note'),
                              're_schedule_by_id' => Auth::user()->id,
                      ]);

        if($appointment)
        {
             return json_pretty(['status'      => 'success',
                                 'appointment' => $appointment]);
        }
        else
        {
            return json_pretty(['status' => 'error']);
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


}
