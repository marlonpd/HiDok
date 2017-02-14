<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('doctor/schedule');
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
        $schedule = $this->createSchedule($request->input());

        if($schedule)
        {
            return "success";
        }
        else
        {
            return "error";
        }
    }


    protected function createSchedule(array $data)
    {
        return Schedule::create([
            'user_id' => Auth::user()->id,
            'from_time' => $data['from_time'],
            'to_time' => $data['to_time'],
            'from_day' => $data['from_day'],
            'to_day' => $data['to_day'],
            'address' => $data['address'],
            'default_address' => $data['default_address'],
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
            'id' => $data['id'],
            'user_id' => Auth::user()->id,
            'from_time' => $data['from_time'],
            'to_time' => $data['to_time'],
            'from_day' => $data['from_day'],
            'to_day' => $data['to_day'],
            'address' => $data['address'],
            'default_address' => $data['default_address'],
        ]);
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

        $schedule = Schedule::find($request->input('id'));
        $schedule->update($request->input());

        if($schedule)
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
        $schedule = Schedule::destroy($request->input());

        if($schedule)
        {
            return "success";
        }
        else{
            return "error";
        }
    }


    public function api_schedules_get($id)
    {
        $id = $id > 0 ? $id : Auth::user()->id;

        $schedules = Schedule::where('user_id' , '=' ,$id)
                             ->get();

        return json_pretty(['schedules' => $schedules]);
    }


}
