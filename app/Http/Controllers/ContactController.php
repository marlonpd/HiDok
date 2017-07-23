<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages/contact');
    }


    public function send_message(Request $request)
    {
    
        $data = array('name'    => $request->input('name'),
                      'subject' => $request->input('subject'), 
                      'email'   => $request->input('email'),
                      'inquiry' => $request->input('message'), 
        );
        Mail::send('mail', $data, function($message) use($name,$email,$subject,$inquiry) {
            $message->to('hidokinc@gmail.com', 'Contact-'.$subject)->subject
                ('Contact-'.$subject);
            $message->from('hidok@hi-dok.com','Contact Page');
            $message->replyTo($email, $name);
        });
       
        return json_pretty(['status' => 'success']);
    }
}
