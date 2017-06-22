<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\User;
use App\DoctorPatient;
use App\IndividualTreatmentRecord;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index($consultation_type , $patient_id)
    {
        $consultation = new Consultation();
        $consultation->patient_id = $patient_id;
        $consultation->doctor_id = Auth::user()->id;
        $consultation->type = $consultation_type;
        $patient = User::findOrFail($patient_id);
        
        if($consultation->save())
        {
            $this->add_patient($patient_id);
            return view('patient/create_itr', compact('patient','consultation'));
        }
        else
        {

        }
         
    }

    // /healthhistory
    public function health_history()
    {
        return view('patient/health_history');
    }

    // /consultations

    public function consultations()
    {
        /*$consultations = Consultation::with('patient') 
                                    ->where('doctor_id','=' ,  Auth::user()->id)
                                    ->first();*/

        return view('doctor/consultations');
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
                                             ->where('doctor_id','=' , Auth::user()->id)
                                             ->take(10)
                                             ->orderBy('created_at', 'ASC')
                                             ->get();
            }
            else
            {
                $consultations = Consultation::with('patient')
                                             ->where('doctor_id','=' , Auth::user()->id)
                                             ->where('created_at', '>' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'ASC')
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


    public function consultation($id)
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
    }


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
                                             ->orderBy('created_at', 'ASC')
                                             ->get();
            }
            else
            {
                $consultations = Consultation::with('patient')
                                             ->with('doctor')
                                             ->where('patient_id','=' , Auth::user()->id)
                                             ->where('created_at', '>' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'ASC')
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

    public function add_patient( $patient_id)
    {
        $patient = new DoctorPatient();
        $patient->patient_id = $patient_id;
        $patient->doctor_id = Auth::user()->id;
        $patient->save();
    }

}
