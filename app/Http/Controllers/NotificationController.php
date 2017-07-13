<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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

    // /api/notifications/all/get
    // /api/notifications/unread/get
    // /notification
    public function api_notifications_all_get(Request $request)
    {
        $lastdate= $request->input('lastdate');
        
        if($lastdate == '')
        {
            $notifications = Notification::with('sender')
                                         ->where('recepient_id','=' , Auth::user()->id)
                                         ->take(10)
                                         ->orderBy('created_at', 'DESC')
                                         ->get();
        }
        else
        {
            $notifications = Notification::with('sender')
                                         ->where('recepient_id','=' , Auth::user()->id)
                                         ->where('created_at', '>' , $lastdate)
                                         ->take(10)
                                         ->orderBy('created_at', 'DESC')
                                         ->get();
        }

        $remaining = 0;
        $lastitem = $notifications->last();
        
        if($lastitem)
        {
            $remaining = Notification::where('recepient_id','=' , Auth::user()->id)
                                     ->where('created_at', '>' , $lastitem->created_at)
                                     ->count();
        }                      

        return json_pretty(['status'        => 'success',
                            'notifications' => $notifications,
                            'remaining'     => $remaining,
                            ]); 
    }


    // /api/notifications/unread/get
    public function api_notifications_unread_get()
    {
        $notifications = Notification::with('sender')
                                     ->where('recepient_id', '=' ,Auth::user()->id)
                                     ->where('read' ,'=' , '0')   
                                     ->orderBy('created_at', 'DESC')
                                     ->get();

        $unread_notification_count =Notification::where('recepient_id', '=' ,Auth::user()->id)
                                                ->where('read' ,'=' , '0')   
                                                ->count();

        return json_pretty(['status'                    => 'success',
                            'notifications'             => $notifications,
                            'unread_notification_count' => $unread_notification_count,
                            ]); 
    }

    // /notification
    public function notifications()
    {
        $this->mark_read_notification();
        return view('notification');
    }

    public function api_mark_read_notification_post()
    {
        return $this->mark_read_notification();
    }

    public function mark_read_notification()
    {
        $timestamp = Carbon::now();
        $user_id = Auth::user()->id;

        $update = Notification::where('recepient_id', '=' ,Auth::user()->id)
                              ->where('read' ,'=' , '0')   
                              ->update(['read' => '1']);

        if($update){
            return json_pretty(['status' => 'success',]);
        }else{
            return json_pretty(['status' => 'error',]);
        }
    }


}
