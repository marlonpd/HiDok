<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotifyUser  extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($recepient_id, $sender_id, $action, $item_id,$type)
    {
        //event(new NotifyUser($appointment->doctor_id,$appointment->patient_id, 'request_appointment' ,$appointment->id ,'appointment'));
        
        $sender = User::findOrFail($sender_id);

        $notification = new Notification();
        $notification->recepient_id = $recepient_id;
        $notification->sender_id = $sender_id;
        $notification->content = config('constants.notification_action.'.$action);
        $notification->item_id = $item_id;
        $notification->type = $type;

        /*if($type == 'rate'){
            $type= 'doctor/profile/0';
        }else if($type == 'consultation'){
            $type= 'patient/consultations/'.$recepient_id;
        }*/

        $type = ( $action == 'create_consultation' || $action == 'cancel_consultation' ) ? '/patient/consultations/'.$recepient_id : '/'.$type;        
        $notification->url = 'http://'.env('APP_DOMAIN').$type;
        $notification->read = 0;
        $notification->save();

        $unread_notification_count =Notification::where('recepient_id', '=' ,Auth::user()->id)
                                                ->where('read' ,'=' , '0')   
                                                ->count();

        $this->data['name'] = $sender->fullname();
        $this->data['thumbnail'] = $sender->thumbnail;
        $this->data['action'] = config('constants.notification_action.'.$action);
        $this->data['url'] = $notification->url;
        $this->data['created_at'] = $notification->created_at;
        $this->data['recepient_id'] = $notification->recepient_id;
        $this->data['unread_notification_count'] = $unread_notification_count;
        $this->data['notification'] = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notification-channel'];
        //return new PrivateChannel('notification-channel');
    }
}
