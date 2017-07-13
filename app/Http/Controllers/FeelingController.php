<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    // /api/feelings/get
  // /api/feeling/update/post
    // /api/feeling/delete/post
    // /api/feeling/post
    public function api_feeling_post(Request $request)
    {
        //return $request->input();
    	//$feeling = $this->create_feeling($request->input());

        $feeling = new Feeling();
        $feeling->patient_id = Auth::user()->id;
        $feeling->content = $request->input('content');
        $feeling->public = $request->input('public') ? 1 : 0;

        if($feeling->save())
        {
            return json_pretty(['status' => 'success',
                                'feeling' => $feeling,
            ]);
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
				            'public' => $data['public'] ? 1 : 0,
				        ]);
    }

 
    // /api/feeling/delete/post
    public function api_feeling_delete_post(Request $request)
    {
        $id = $request->input('id');
        
        $feeling = Feeling::where('id', '=' , $id)
                          ->delete();


        if($feeling)
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }                  
    }

    // /api/feeling/update/post
    public function api_feeling_update_post(Request $request)
    {
        $feeling = Feeling::find($request->input('id'));
        $feeling->content = $request->input('content');
        $feeling->public = $request->input('public') ? 1 : 0;

        if($feeling->save())
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }   
    }


     // /api/patient/consultation/get
    public function api_feelings_get(Request $request)
    {
    	if(Auth::user()->is_patient())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $feelings = Feeling::where('patient_id','=' , Auth::user()->id)
                                        ->take(10)
                                        ->orderBy('created_at', 'DESC')
                                        ->get();
            }
            else
            {
                $feelings = Feeling::where('patient_id','=' , Auth::user()->id)
                                             ->where('created_at', '>' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }

            $remaining = 0;
            $lastitem = $feelings->last();
            
            if($lastitem)
            {
                $remaining = Feeling::where('patient_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['feelings'  => $feelings ,
                                'remaining' => $remaining,
                            ]);
    	}
    }
}
