<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Clinic;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller
{
    

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('doctor/clinic');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clinic = $this->createClinic($request->input());

        if($clinic)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }



    protected function createClinic(array $data)
    {
        return Clinic::create([
        	'name'   => $data['name'],
            'doctor_id' => Auth::user()->id,
            'from_time' => $data['from_time'],
            'to_time' => $data['to_time'],
            'open_sunday' => $data['open_sunday'] != 1 ? 0 : 1 ,
            'open_monday' => $data['open_monday']  != 1 ? 0 : 1,
            'open_tuesday' => $data['open_tuesday']  != 1 ? 0 : 1,
            'open_wednesday' => $data['open_wednesday']  != 1 ? 0 : 1,
            'open_thursday' => $data['open_thursday']  != 1 ? 0 : 1,
            'open_friday' => $data['open_friday']  != 1 ? 0 : 1,
            'open_saturday' => $data['open_saturday']  != 1 ? 0 : 1,
            'address' => $data['address'],
            'default_address' => $data['default_address'],
            'gmap_lat' => $data['gmap_lat'],
            'gmap_lng' => $data['gmap_lng'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function updateSchedute(array $data)
    {
        return Schedule::update([
            'name'            => $data['name'],
            'user_id'         => Auth::user()->id,
            'from_time'       => $data['from_time'],
            'to_time'         => $data['to_time'],
            'open_sunday'     => $data['open_sunday'],
            'open_monday'     => $data['open_monday'],
            'open_tuesday'    => $data['open_tuesday'],
            'open_wednesday'  => $data['open_wednesday'],
            'open_thursday'   => $data['open_thursday'],
            'open_friday'     => $data['open_friday'],
            'open_saturday'   => $data['open_saturday'],
            'address'         => $data['address'],
            'default_address' => $data['default_address'],
            'gmap_lat'        => $data['gmap_lat'],
            'gmap_lng'        => $data['gmap_lng'],
        ]);
    }


    public function setDefaultClinic($clinic)
    {
        Clinic::where('doctor_id', '=' , $clinic->doctor_id)
              ->update(['default_address' => 0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $clinic = Clinic::find($request->input('id'));

        if($request->input('default_address') == 1 && $clinic->default_address == 0 )
        {
            $this->setDefaultClinic($clinic);
        }

        $clinic->update($request->input());

        if($clinic)
        {
            return "success";
        }
        else
        {
            return "error";
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $clinic = Clinic::destroy($request->input());

        if($clinic)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }


    public function api_clinics_get($id)
    {
        $id = $id > 0 ? $id : Auth::user()->id;

        $clinics = Clinic::where('doctor_id' , '=' ,$id)
                         ->get();

        return json_pretty(['clinics' => $clinics]);
    }


}
