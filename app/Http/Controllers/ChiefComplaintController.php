<?php

namespace App\Http\Controllers;
use App\ChiefComplaint;
use App\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChiefComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {


    }

    // '/api/chief/complaint/post'
    public function api_chief_complaint_post(Request $request)
    {
        $symptoms = $request->input('symptoms');
        $patient_id = $request->input('patient_id');
        $consultation_id = $request->input('consultation_id');
        $chief_complaint = ChiefComplaint::where('consultation_id','=',$consultation_id)->first();

        

        if($chief_complaint != null)
        {
            $chief_complaint = ChiefComplaint::where('consultation_id','=',$consultation_id)->delete();
        }

        foreach ($symptoms as $symptom) 
        {
            $cc = new ChiefComplaint(); 
            $cc->patient_id = $patient_id;
            $cc->doctor_id =Auth::user()->id;
            $cc->consultation_id = $consultation_id;
            $cc->symptom = $symptom;
            $cc->save();
        }

        return json_pretty(['status' => 'success']);
    }

    // /api/chief/complaint/get
    public function api_chief_complaint_get($consultation_id)
    {
        $chief_complaints = ChiefComplaint::where('consultation_id','=',$consultation_id)
                                         ->get();

       return json_pretty(['status'   => 'success',
                           'symptoms' => $chief_complaints,
              ]);                                  
    }

    // '/api/symptom/delete/post''
    public function api_symptom_delete_post(Request $request)
    {
        $id = $request->input('id');
        $chief_complaints = ChiefComplaint::where('id','=',$id)
                                          ->delete();
        
        return json_pretty(['status'   => 'success']);
    }

}
