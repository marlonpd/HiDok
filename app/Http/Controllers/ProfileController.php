<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Clinic;
use App\Ratings;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    	 /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
      // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($account_type,$id)
    {	
    	$user = User::findOrFail($id);
        $user['clinic'] = Clinic::where('doctor_id', '=', $id)
                                ->where('default_address', '=', 1)
                                ->first();   

        $doctor_rate = $this->get_doctor_ratings($id);
    
        return view($account_type.'/profile', compact('user', 'doctor_rate'));
    }

    public function get_doctor_ratings($doctor_id)
    {
        $doctor_rate['rate_times'] = 0;
        $doctor_rate['rate_value'] = 0;
        $doctor_rate['rate_bg'] = 0;
        $doctor_rate['current_user_rating'] = 0;
        $doctor_rate = array();

        $ratings= Ratings::where('doctor_id','=', $doctor_id)
                         ->get();

        if(count($ratings) > 0)
        {
            foreach ($ratings as $rating) 
            {
                $rate_db[] = $rating;
                $sum_rates[] = $rating['rate'];
            }

            $doctor_rate['rate_times'] = count($rate_db);
            $doctor_rate['sum_rates'] = array_sum($sum_rates);
            $doctor_rate['rate_value'] =$doctor_rate['sum_rates']/$doctor_rate['rate_times'];
            $doctor_rate['rate_bg'] = (($doctor_rate['rate_value'])/5)*100;

            $current_user_rating = Ratings::where('patient_id','=', Auth::user()->id)
                                          ->where('doctor_id', '=', $doctor_id)
                                          ->first();


            if($current_user_rating)    
            {                          
                $doctor_rate['current_user_rating'] = $current_user_rating->rate;
            }
            else
            {
                $doctor_rate['current_user_rating'] = 0;
            }
        	
        }

        return $doctor_rate;
    }
}
