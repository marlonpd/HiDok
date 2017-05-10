<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Clinic;
use App\Ratings;
use Illuminate\Support\Facades\Auth;
use Image;

class ProfileController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($account_type,$id)
    {	
        if($account_type == config('constants.account_type_rev.1'))
        {
            $user = User::findOrFail($id);
            $user['clinic'] = Clinic::where('doctor_id', '=', $id)
                                    ->where('default_address', '=', 1)
                                    ->first();   

            $doctor_rate = $this->get_doctor_ratings($id);
        
            return view($account_type.'/profile', compact('user', 'doctor_rate'));
        }
        elseif($account_type == config('constants.account_type_rev.0'))
        {
            $user = User::findOrFail($id);        
            return view($account_type.'/profile', compact('user'));
        }
        else
        { 
            return "ongoing!!".config('constants.account_type_rev.0');
        }
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

            $doctor_rate['current_user_rating'] = 0;

            if($current_user_rating)    
            {                          
                $doctor_rate['current_user_rating'] = $current_user_rating->rate;
            }
        	
        }

        return $doctor_rate;
    }


    //'/api/update/profile/post'
    public function api_update_profile_post(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($request->hasFile('photo')) {
            $public_path = public_path();
            $photo_dir = '/images/photo';
            $fileName = str_random(30);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $safename = $fileName.'.'.$extension;

            $request->file('photo')->move($photo_dir, $safename);
            Image::make($public_path.'/'.$photo_dir.'/'.$safename)->resize(200, 200)->save($public_path.'/'.$photo_dir.'/thumb/'.$safename);
            $user->update(['photo' => $photo_dir.'/'.$safename,
                           'thumbnail' => $photo_dir.'/thumb/'.$safename]);
        }

       
        $user->update($request->all());       

        if($user)
        {
            return json_pretty(['status' => 'success',
                                'user'   => $user,
                              ]);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }

    public function api_upload_user_photo(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($request->hasFile('photo')) 
        {
            $public_path = public_path();
            $photo_dir = 'images/photo';
            $fileName = str_random(30);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $safename = $fileName.'.'.$extension;

            $request->file('photo')->move($photo_dir, $safename);
            Image::make($public_path.'/'.$photo_dir.'/'.$safename)->resize(200, 200)->save($public_path.'/'.$photo_dir.'/thumb/'.$safename);
            $user->update(['photo' => $photo_dir.'/'.$safename,
                           'thumbnail' => $photo_dir.'/thumb/'.$safename]);

            if($user)
            {
                return json_pretty(['status' => 'success',
                                    'user'   => $user,
                                ]);
            }
            else
            {
                return json_pretty(['status' => 'error']);
            }
        }
    }


}
