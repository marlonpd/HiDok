<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\User;
use App\DoctorPatient;
use App\Appointment;
use App\IndividualTreatmentRecord;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Events\NotifyUser;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    // /healthhistory
    public function health_history()
    {
        return view('patient/health_history');
    }

    // /consultations
    public function consultations()
    {
        return view('doctor/consultations');
    }


    public function patient_consultations($id)
    {
        $patient = User::where('id', '=' , $id)
                       ->first();
                       
        $consultations = Consultation::where('patient_id', '=', $patient->id)
                                     ->get();
        
        return view('patient/consultations', compact('patient' , 'consultations'));
    }


    public function api_consultations_get(Request $request)
    {
        

        $lastdate= $request->input('lastdate');
        $patient_id = $request->input('patient_id');

        if($lastdate == '')
        {
            $consultations = Consultation::with('doctor')
                                         ->where('patient_id','=' ,$patient_id)
                                         ->take(10)
                                         ->orderBy('created_at', 'DESC')
                                         ->get();
        }
        else
        {
            $consultations = Consultation::with('doctor')
                                         ->where('patient_id','=' ,$patient_id)
                                         ->where('created_at', '>' , $lastdate)
                                         ->take(10)
                                         ->orderBy('created_at', 'DESC')
                                         ->get();
        }
        $remaining = 0;
        $lastitem = $consultations->last();
        
        if($lastitem)
        {
            $remaining = Consultation::where('patient_id','=' ,$patient_id)
                                     ->where('created_at', '>' , $lastitem->created_at)
                                     ->count();
        }                      

        return json_pretty(['consultations'  => $consultations,
                            'remaining'      => $remaining,
                        ]);
    }

    // /api/doctor/consultations/get
    public function api_doctor_consultations_get(Request $request)
    {
    	if(Auth::user()->is_doctor())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $consultations = Consultation::with('patient')  
                                             ->with('doctor')
                                             ->where('doctor_id','=' , Auth::user()->id)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }
            else
            {
                $consultations = Consultation::with('patient')
                                             ->with('doctor')
                                             ->where('doctor_id','=' , Auth::user()->id)
                                             ->where('created_at', '>' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }
            $remaining = 0;
            $lastitem = $consultations->last();
            
            if($lastitem)
            {
                $remaining = Consultation::where('doctor_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['consultations'  => $consultations ,
                                'remaining' => $remaining,
                            ]);
    	}
    }

   
    public function api_consultation_create(Request $request)
    {
        
        $patient_id = $request->input('patient_id');

        $consultation = new Consultation();
        $consultation->patient_id = $patient_id;
        $consultation->doctor_id = Auth::user()->id;
        $consultation->type = 0;
        $consultation->hospital = ''; 

        
        if($consultation->save())
        {
            event(new NotifyUser($consultation->patient_id,$consultation->doctor_id, 'create_consultation' ,$consultation->id ,'consultation'));
            //__construct($recepient_id, $sender_id, $action, $item_id,$type)
            $this->insert_vital_sign_set($patient_id , $consultation->id);

            $this->add_patient($patient_id);
            $consultation = Consultation::with('doctor')
                                        ->with('patient')
                                        ->where('id' ,'=' , $consultation->id)
                                        ->first();

            

            return json_pretty(['status'        => 'success' ,
                                'consultation'  => $consultation,
                                ]);
        }
        else
        {
            return json_pretty(['status'  =>  'error']);
        }
    }

    public function insert_vital_sign_set($patient_id , $consultation_id)
    {
        /*$data = array(
            array('patient_id'=>$patient_id, 'doctor_id' => Auth::user()->id , 'consultation_id' => $consultation_id ,'value' => '', 'type' => 'vital_sign' , 'name' => 'Blood Pressure'),
            array('patient_id'=>$patient_id, 'doctor_id' => Auth::user()->id , 'consultation_id' => $consultation_id ,'value' => '', 'type' => 'vital_sign' , 'name' => 'Respiratory Rate'), 
            array('patient_id'=>$patient_id, 'doctor_id' => Auth::user()->id , 'consultation_id' => $consultation_id ,'value' => '', 'type' => 'vital_sign' , 'name' => 'Respiratory Rate''Pulse Rate'), 
            array('patient_id'=>$patient_id, 'doctor_id' => Auth::user()->id , 'consultation_id' => $consultation_id ,'value' => '', 'type' => 'vital_sign' , 'name' => 'Respiratory Rate''Pulse Rate''Body Temperature'), 
        );

        IndividualTreatmentRecord::insert($data);*/

        $itr = new IndividualTreatmentRecord(); 
        $itr->patient_id = $patient_id;
        $itr->doctor_id =Auth::user()->id;
        $itr->consultation_id = $consultation_id;
        $itr->name = 'blood_pressure';
        $itr->type = 'vital_sign';
        $itr->value = 'bp1';
        $itr->save();

        $itr = new IndividualTreatmentRecord(); 
        $itr->patient_id = $patient_id;
        $itr->doctor_id =Auth::user()->id;
        $itr->consultation_id = $consultation_id;
        $itr->name = 'respiratory_rate';
        $itr->type = 'vital_sign';
        $itr->value = 'rr1';
        $itr->save();

        $itr = new IndividualTreatmentRecord(); 
        $itr->patient_id = $patient_id;
        $itr->doctor_id =Auth::user()->id;
        $itr->consultation_id = $consultation_id;
        $itr->name = 'pulse_rate';
        $itr->type = 'vital_sign';
        $itr->value = 'pr1';
        $itr->save();


        $itr = new IndividualTreatmentRecord(); 
        $itr->patient_id = $patient_id;
        $itr->doctor_id =Auth::user()->id;
        $itr->consultation_id = $consultation_id;
        $itr->name = 'body_temperature';
        $itr->type = 'vital_sign';
        $itr->value = 'bt1';
        $itr->save();
    }

    public function consultation_create($consultation_type , $patient_id, $appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        $appointment->confirmed = config('constants.appointment_status.consult'); // change later to consult
        $appointment->save();

        return redirect("/patient/consultations/$patient_id");

        /*$consultation = new Consultation();
        $consultation->patient_id = $patient_id;
        $consultation->doctor_id = Auth::user()->id;
        $consultation->type = $consultation_type;
        $patient = User::findOrFail($patient_id);
        if($consultation->save())
        {
            $consultation = $consultation->id;
            $this->add_patient($patient_id);

            return redirect("/patient/consultations/$patient_id");
        }
        else
        {
            return "else";
        }*/
         
    }

    public function consultation_new($consultation_id)
    {   
        $consultation = Consultation::with('patient')
                                    ->with('doctor')   
                                    ->where('id','=' , $consultation_id)
                                    ->first();
        $itr = array();
        $itr_type = config('constants.individual_treatment_record_type');

        foreach($itr_type as $key=>$value)
        {
            $itr[$key] = IndividualTreatmentRecord::with('patient')
                                                  ->where('type', '=', $key)
                                                  ->where('consultation_id','=',$id)
                                                  ->get();
        }

        return view('patient/consultation', compact('consultation', 'itr' , 'itr_type'));
    }


    /*public function consultation($id)
    {
        
        $consultation = Consultation::with('patient')
                                    ->with('doctor')   
                                    ->where('id','=' , $id)
                                    ->first();
        
        $itr = IndividualTreatmentRecord::where('consultation_id' ,'=' , $id)
                                        ->get();

        $itr = array();

        $itr_type = config('constants.individual_treatment_record_type');


        foreach($itr_type as $key=>$value)
        {
            $itr[$key] = IndividualTreatmentRecord::with('patient')
                                                ->where('type', '=', $key)
                                                ->where('consultation_id','=',$id)
                                                ->get();
        }

        return view('patient/consultation', compact('consultation', 'itr' , 'itr_type'));
    }*/


    // /api/patient/consultation/get
    public function api_patient_consultation_get(Request $request)
    {
    	if(Auth::user()->is_patient())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $consultations = Consultation::with('patient')
                                             ->with('doctor')   
                                             ->where('patient_id','=' , Auth::user()->id)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }
            else
            {
                $consultations = Consultation::with('patient')
                                             ->with('doctor')
                                             ->where('patient_id','=' , Auth::user()->id)
                                             ->where('created_at', '<' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }
            $remaining = 0;
            $lastitem = $consultations->last();
            
            if($lastitem)
            {
                $remaining = Consultation::where('patient_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['consultations'  => $consultations ,
                                'remaining' => $remaining,
                            ]);
    	}
    }

    // /api/consultation/delete/post
    public function api_consultation_delete_post(Request $request)
    {
        $id = $request->input('id');
        $consultation = Consultation::where('id','=',$id)
                                    ->delete();

        if($consultation)
        {
            
            return json_pretty(['status' => 'success']);
        }
        else{
            return json_pretty(['status' => 'error']);
        }
    }

    public function api_consultation_admit_patient_post(Request $request)
    {
        $id = $request->input('id');
        $admit = $request->input('admit');
        $consultation = Consultation::where('id','=',$id)
                                    ->first();
        $consultation->admit = $admit;

        if($consultation->save())
        {
           	return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }

    public function api_consultation_doctors_order_post(Request $request)
    {
        $id = $request->input('id');
        $doctors_order = $request->input('doctors_order');
        $consultation = Consultation::where('id','=',$id)
                                    ->first();
        $consultation->doctors_order = $doctors_order;

        if($consultation->save())
        {
           	return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }

    public function api_consultation_assign_hospital_post(Request $request)
    {
        $id = $request->input('id');
        $hospital = $request->input('hospital');
        $consultation = Consultation::where('id','=',$id)
                                    ->first();
        $consultation->hospital = $hospital;

        if($consultation->save())
        {
           	return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
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

}
