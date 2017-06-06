<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndividualTreatmentRecord;
use Illuminate\Support\Facades\Auth;

class IndividualTreatmentRecordController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function index()
    {

    }

    //'/api/itr/post'
    public function api_itr_post(Request $request)
    {
        $value = $request->input('value');
        $type = $request->input('type');
        $patient_id = $request->input('patient_id');
        $consultation_id = $request->input('consultation_id');
        $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id)->first();
        
        /*if($itr != null)
        {
            $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id)
                                            ->where('type', '=' , $type)
                                            ->delete();
        }*/
        if(is_array($value))
        {
            foreach ($value as $item) 
            {
                $itr = new IndividualTreatmentRecord(); 
                $itr->patient_id = $patient_id;
                $itr->doctor_id =Auth::user()->id;
                $itr->consultation_id = $consultation_id;
                $itr->value = $item;
                $itr->type = $type;
                $itr->save();
            }
        }
        else
        {
             $itr = new IndividualTreatmentRecord(); 
             $itr->patient_id = $patient_id;
             $itr->doctor_id =Auth::user()->id;
             $itr->consultation_id = $consultation_id;
             $itr->value = $value;
             $itr->type = $type;
             $itr->save();
        }

        return json_pretty(['status' => 'success']);
    }

     // /api/itr/get
    public function api_itr_get($consultation_id,$type)
    {
        $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id)
                                        ->where('type', '=', $type)
                                        ->get();

       return json_pretty(['status'   => 'success',
                           $type => $itr,
              ]);                                  
    }

    // '/api/itr/delete/post''
    public function api_itr_delete_post(Request $request)
    {
        $id = $request->input('id');
        $itr = IndividualTreatmentRecord::where('id','=',$id)
                                        ->delete();
        
        return json_pretty(['status'   => 'success']);
    }


    public function show_print( $type , $id)
    {
        return view("print/$type");
    }

}
