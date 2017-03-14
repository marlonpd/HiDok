<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ratings;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    

    /**
    * Set a rate
    */
    public function api_rate_post(Request $request)
    {
        $doctor_id = $request->input('doctor_id');
        $rating = $request->input('rating');

        if($rating <= 5.0)
        {
            $current_rating = Ratings::where('doctor_id','=',$doctor_id)
                                     ->where('patient_id', '=', Auth::user()->id)
                                     ->first();
            
            if($current_rating)
            {
                $current_rating->rate = $rating;
                $current_rating->save();

                return json_pretty(['status' => 'success']);
            }
            else
            {
                $new_rating = new Ratings();
                $new_rating->doctor_id = $doctor_id;
                $new_rating->patient_id =Auth::user()->id;
                $new_rating->rate = $rating;
                $new_rating->save();

                return json_pretty(['status' => 'success']);
            }

            return json_pretty(['status' => 'error']);
        }
    }

    



}
