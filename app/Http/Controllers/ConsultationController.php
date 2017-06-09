<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\User;
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

}
