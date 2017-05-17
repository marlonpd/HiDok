<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Symptom;

class SymptomController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function index()
    {

    }


    public function api_symptoms_get()
    {
        $symptoms = Symptom::all();

        return json_pretty(['symptoms' => $symptoms]);
    }

    public function api_symptoms_selected_post(Request $request)
    {
        $symptoms = $request->input('symptoms');
        $patient_id = $request->input('patient_id');
        $consultation_id = $request->input('consultation_id');
        $consultation = ChiefComplaint::findOrFail($consultation_id);

        $post = Consultation::find($consultation_id);

        if($consultation)
        {


        }
        else
        {
            $complaints = array();
            foreach ($symptoms as $symptom) 
            {
                
                
            }
        }

        return json_pretty(['symptoms' => $symptoms, 'patient_id' => $patient_id]);
    }
}
