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

}
