<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VitalSign;
use Illuminate\Support\Facades\Auth;

class VitalSignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {


    }

    // '/api/vitalsign/post'
    public function api_vital_sign_post(Request $request)
    {
        $vital_signs = $request->input('vitalSigns');
        $patient_id = $request->input('patient_id');
        $consultation_id = $request->input('consultation_id');
        $vital_sign = VitalSign::where('consultation_id','=',$consultation_id)->first();

        

        if($vital_sign != null)
        {
            $vital_sign = VitalSign::where('consultation_id','=',$consultation_id)->delete();
        }

        foreach ($vital_signs as $vital_sign) 
        {
            $vs = new VitalSign(); 
            $vs->patient_id = $patient_id;
            $vs->doctor_id =Auth::user()->id;
            $vs->consultation_id = $consultation_id;
            $vs->vital_sign = $vital_sign;
            $vs->save();
        }

        return json_pretty(['status' => 'success']);
    }

    // /api/vitalsign/get
    public function api_vital_sign_get($consultation_id)
    {
        $vital_signs = VitalSign::where('consultation_id','=',$consultation_id)
                                         ->get();

       return json_pretty(['status'   => 'success',
                           'vital_signs' => $vital_signs,
              ]);                                  
    }

    // '/api/vitalsign/delete/post''
    public function api_vital_sign_delete_post(Request $request)
    {
        $id = $request->input('id');
        $vital_sign = VitalSign::where('id','=',$id)
                                          ->delete();
        
        return json_pretty(['status'   => 'success']);
    }
}
