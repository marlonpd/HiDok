<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndividualTreatmentRecord;
use Illuminate\Support\Facades\Auth;
use App\Clinic;
use App\User;

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

        if(is_array($value) ){
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
            
        }else{

            if($type == 'treatment' || $type=='vital_sign')
            {
                $itr = new IndividualTreatmentRecord(); 
                $itr->patient_id = $patient_id;
                $itr->doctor_id =Auth::user()->id;
                $itr->consultation_id = $consultation_id;
                $itr->value = $value;
                $itr->type = $type;
                $itr->save();
            }
            else
            {
                $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id )
                                            ->where('type' , '=' ,$type)
                                            ->first();
                if($itr)
                {
                    $itr->value = $value;
                    $itr->save();
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
            }

        }

        return json_pretty(['status' => 'success']);
    }

     // /api/itr/get
    public function api_itr_get($consultation_id, $type)
    {
        $itr = array();
        $itr_type = config('constants.individual_treatment_record_type');

        if($type == 'all')
        {
            foreach($itr_type as $key=>$value)
            {
                $itr[$key] = IndividualTreatmentRecord::with('patient')
                                                    ->where('type', '=', $key)
                                                    ->where('consultation_id','=',$consultation_id)
                                                    ->get();
            }

            return json_pretty(['status' => 'success',
                                'itr'    => $itr,
                        ]);       
        }
        else
        {
            $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id)
                                        ->where('type', '=', $type)
                                        ->get();

            return json_pretty(['status'   => 'success',
                                $type => $itr,
                    ]);  
        }



                                   
    }
    
    /*public function api_itr_get($consultation_id,$type)
    {
        $itr = IndividualTreatmentRecord::where('consultation_id','=',$consultation_id)
                                        ->where('type', '=', $type)
                                        ->get();

       return json_pretty(['status'   => 'success',
                           $type => $itr,
              ]);                                  
    }*/

    // '/api/itr/delete/post''
    public function api_itr_delete_post(Request $request)
    {
        $id = $request->input('id');
        $itr = IndividualTreatmentRecord::where('id','=',$id)
                                        ->delete();
        
        return json_pretty(['status'   => 'success']);
    }


    public function show_print( $type, $id , $patient_id)
    {
        if($type == "consultation")
        {
            $itr = array();

            $itr_type = config('constants.individual_treatment_record_type');

            
            foreach($itr_type as $key=>$value)
            {
                $itr[$key] = IndividualTreatmentRecord::with('patient')
                                                       ->where('type', '=', $key)
                                                       ->where('consultation_id','=',$id)
                                                       ->get();
            }
            

            
        }
        else
        {
            $itr = IndividualTreatmentRecord::with('patient')
                                            ->where('consultation_id','=',$id)
                                            ->where('type','=' , $type)
                                            ->get();
        }

        $patient = User::where('id', '=', $patient_id)
                       ->first();

        $clinic = Clinic::where('doctor_id', '=',''+Auth::user()->id+'')
                        ->where('default_address', '=', '1')
                        ->first();
        
        
        if($type == "consultation")
        {                
            return view("print/$type", compact('itr','type', 'itr_type' ,'clinic', 'patient'));
        }
        else
        {
            return view("print/$type", compact('itr','type', 'clinic', 'patient'));
        }
    }




}
