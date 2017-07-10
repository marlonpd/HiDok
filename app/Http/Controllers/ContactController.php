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
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $inquiry = $request->input('message');
    
        $data = array('name'    => $name,
                      'subject' => $subject, 
                      'email'   => $email,
                      'inquiry' => $inquiry, 
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
