<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ratings;
use App\Events\NotifyUser;
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

                event(new NotifyUser($current_rating->doctor_id,$current_rating->patient_id, 'rate' ,$current_rating->id ,'rate'));
                //__construct($recepient_id, $sender_id, $action, $item_id,$type)


                return json_pretty(['status' => 'success']);
            }
            else
            {
                $new_rating = new Ratings();
                $new_rating->doctor_id = $doctor_id;
                $new_rating->patient_id =Auth::user()->id;
                $new_rating->rate = $rating;
                $new_rating->save();

                event(new NotifyUser($new_rating->doctor_id,$new_rating->patient_id, 'rate' ,$new_rating->id ,'rate'));
                //__construct($recepient_id, $sender_id, $action, $item_id,$type)

                return json_pretty(['status' => 'success']);
            }

            return json_pretty(['status' => 'error']);
        }
    }

    



}
