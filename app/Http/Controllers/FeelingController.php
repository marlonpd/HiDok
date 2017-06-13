<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feeling;

class FeelingController extends Controller
{
    

    /**
    * Create a new controller instance.
    *
    * @return void
    */

    public function __construct()
    {
        $this->middleware('auth');
    }


    // api/feeling/post
    public function api_feeling_post(Request $request)
    {
    	$feeling = $this->create_feeling($request->input());

        if($feeling)
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }

    protected function create_feeling(array $data)
    {
        return Feeling::create([
				            'patient_id' => Auth::user()->id,
				            'content' => $data['content'],
				            'status' => 1,
				        ]);
    }

    public function api_feelings_get()
    {
        if(Auth::user()->is_patient())
        {
            $feelings = Feeling::where('doctor_id' , '=' , Auth::user()->id)
                                ->get();
        }
        else
        {

        }                        

        return json_pretty(['feedbacks' => $feelings]);                    
  
    }
}
