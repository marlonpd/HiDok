<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;
use Illuminate\Support\Facades\Auth;


class FeedbackController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('doctor/feedback');
    }

    public function store(Request $request)
    {
    	$feedback = $this->createFeedback($request->input());

        if($feedback)
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }



    protected function createFeedback(array $data)
    {
        return Feedback::create([
				            'doctor_id' =>  $data['doctor_id'],
				            'patient_id' => Auth::user()->id,
				            'content' => $data['content'],
				            'approved' => 0,
				        ]);
    }

    //api/feedback/get
    public function api_feedbacks_get(Request $request)
    {
    	if(Auth::user()->is_doctor())
    	{
            $lastdate= $request->input('lastdate');
            

            if($lastdate == '')
            {
                $feedbacks = Feedback::with('patient') 
                                         ->where('doctor_id' , '=' , Auth::user()->id)
                                         ->take(10)
                                         ->orderBy('created_at', 'ASC')
                                         ->get();
            }
            else
            {
                $feedbacks = Feedback::with('patient')
                                        ->where('doctor_id' , '=' , Auth::user()->id)
                                        ->where('created_at', '>' , $lastdate)
                                        ->take(10)
                                        ->orderBy('created_at', 'ASC')
                                        ->get();
            }

            $remaining = 0;
            $lastitem = $feedbacks->last();
            
            if($lastitem)
            {
                $remaining = Feedback::where('doctor_id','=' , Auth::user()->id)
                                     ->where('created_at', '>' , $lastitem->created_at)
                                     ->count();
            }                      

  			return json_pretty(['feedbacks'  => $feedbacks ,
                                'remaining' => $remaining,
                            ]);
    	}
    }


    public function api_feedback_approved_get($id)
    {
        $feedbacks = Feedback::with('patient')
                             ->where('doctor_id' , '=' , $id)
                             ->where('approved','=' , 1)
                             ->get();

        return response()->json(['feedbacks' => $feedbacks]);
    }

    //api/feedback/approved/post
    public function api_feedback_approve_post(Request $request)
    {
    	$id = $request->input('id');

        $feedback = Feedback::findOrFail($id);

    	$feedback->update(['approved' => 1]);

    	if($feedback)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }

    //api/feedback/delete/post
    public function api_feedback_delete_post(Request $request)
    {
    	$feedback = Feedback::destroy($request->input());

        if($feedback)
        {
            return "success";
        }
        else{
            return "error";
        }
    }




}
