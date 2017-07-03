<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\DoctorPatient;
use DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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

    // /api/post/post
    public function api_post_post(Request $request)
    {
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->content = $request->input('content');
        $post->public = $request->input('public') ? 1 : 0;

        if($post->save())
        {
            return json_pretty(['status' => 'success',
                                'post' => $post,
                            ]);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }
    }

    protected function create_post(array $data)
    {
        return Post::create([
				            'user_id' => Auth::user()->id,
				            'content' => $data['content'],
				            'public' => $data['public'] ? 1 : 0,
				        ]);
    }

    // /api/post/delete/post
    public function api_post_delete_post(Request $request)
    {
        $id = $request->input('id');
        
        $post = Post::where('id', '=' , $id)
                          ->delete();


        if($post)
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }                  
    }

    // /api/post/update/post
    public function api_post_update_post(Request $request)
    {
        $post = Post::find($request->input('id'));
        $post->content = $request->input('content');
        $post->public = $request->input('public') ? 1 : 0;

        if($post->save())
        {
            return json_pretty(['status' => 'success']);
        }
        else
        {
            return json_pretty(['status' => 'error']);
        }   
    }


     // /api/patient/consultation/get
    public function api_posts_get(Request $request)
    {
    	if(Auth::user()->is_patient() || Auth::user()->is_doctor())
    	{
            $lastdate= $request->input('lastdate');
            $filter = $request->input('filter');
            
            if($lastdate == '')
            {
                // if filter == 1, fetch only users post, else fetch doctors post too
                if($filter == 1)
                {    

                    $posts = DB::table('posts')
                               ->join('users', 'posts.user_id', '=','users.id') 
                               ->select('posts.content', 'posts.id as post_id' ,'posts.created_at','users.id','users.lastname', 'users.firstname','users.middlename','users.thumbnail') 
                               ->where('user_id','=' , Auth::user()->id)
                               ->take(10)
                               ->orderBy('created_at', 'DESC')
                               ->get();
                }
                else
                {
                    if(Auth::user()->is_patient())
                    {
                        $posts = DB::table('posts')
                                    ->leftjoin('doctor_patient', 'posts.user_id', '=' , 'doctor_patient.doctor_id')
                                    ->join('users', 'posts.user_id', '=','users.id')
                                    ->select('posts.content' ,'posts.created_at', 'posts.id as post_id' ,'users.id','users.lastname', 'users.firstname','users.middlename','users.thumbnail') 
                                    ->orwhere('doctor_patient.patient_id', '=', ''.Auth::user()->id.'')
                                    ->orWhere('posts.user_id', '=', ''.Auth::user()->id.'')
                                    ->take(10)
                                    ->orderBy('posts.created_at', 'DESC')
                                    ->get(); 
                    }
                    else
                    {
                        $posts = DB::table('posts')
                                   ->leftjoin('doctor_patient','doctor_patient.patient_id', '=' , 'posts.user_id' )
                                   ->join('users', 'posts.user_id', '=','users.id')
                                   ->select('posts.content' ,'posts.created_at', 'posts.id as post_id','users.id','users.lastname', 'users.firstname','users.middlename','users.thumbnail') 
                                   ->where('doctor_patient.doctor_id', '=', ''.Auth::user()->id.'')
                                   ->orWhere('posts.user_id', '=', ''.Auth::user()->id.'')
                                   ->take(10)
                                   ->orderBy('posts.created_at', 'DESC')
                                   ->get();                        
                    }

                }
            }
            else
            {
                if($filter == 1)
                {  
                    $posts = Post::with(array('users'=>
                                            function($query){
                                                $query->select('id',
                                                               'lastname',
                                                               'firstname',
                                                               'middlename',
                                                               'thumbnail');
                                            }
                                         ))
                                 ->where('user_id','=' , '"'.Auth::user()->id.'')
                                 ->where('created_at', '<' , $lastdate)
                                 ->take(10)
                                 ->orderBy('created_at', 'DESC')
                                 ->get();
                }
                else
                {
                    if(Auth::user()->is_patient())
                    {
                        $posts = DB::table('posts')
                                    ->leftjoin('doctor_patient','doctor_patient.doctor_id', '=' ,  'posts.user_id')
                                    ->join('users', 'posts.user_id', '=','users.id')
                                    ->select('posts.content', 'posts.id as post_id' ,'posts.created_at','users.id','users.lastname', 'users.firstname','users.middlename','users.thumbnail') 
                                    ->where(function($query){
                                            $query->where('doctor_patient.patient_id', '=', ''.Auth::user()->id.'');
                                            $query->orWhere('posts.user_id', '=', ''.Auth::user()->id.'');    
                                        })
                                    ->where('posts.created_at', '<' , $lastdate)
                                    ->take(10)
                                    ->orderBy('posts.created_at', 'DESC')
                                    ->get(); 
                    }
                    else
                    {
                        $posts = DB::table('posts')
                                   ->join('doctor_patient', 'doctor_patient.patient_id', '=' ,'posts.user_id' )
                                   ->join('users', 'posts.user_id', '=','users.id')
                                   ->select('posts.content', 'posts.id as post_id' ,'posts.created_at','users.id','users.lastname', 'users.firstname','users.middlename','users.thumbnail') 
                                   ->where(function($query){
                                            $query->where('doctor_patient.doctor_id', '=', ''.Auth::user()->id.'');
                                            $query->orwhere('posts.user_id', '=', ''.Auth::user()->id.'');    
                                        })
                                   ->where('posts.created_at', '<' , $lastdate)
                                   ->take(10)
                                   ->orderBy('posts.created_at', 'DESC')
                                   ->get(); 
                    }                
                }
            }

            $remaining = 0;
            $lastitem = $posts->last();

            
            if($lastitem)
            {
                if($filter == 1)
                {
                    if(Auth::user()->is_patient())
                    {
  

                        $remaining = DB::table('posts')
                                       ->leftjoin('doctor_patient', 'doctor_patient.doctor_id', '=' , 'posts.user_id')
                                       ->join('users', 'posts.user_id', '=','users.id')
                                       ->orWhere('posts.user_id', '=', '"'.Auth::user()->id.'"')
                                       ->where('posts.created_at', '<' , $lastitem->created_at)
                                       ->count(); 
                    }
                    else
                    {
                        $remaining = DB::table('posts')
                                       ->leftjoin('doctor_patient', 'posts.user_id', '=' , 'doctor_patient.patient_id')
                                       ->join('users', 'posts.user_id', '=','users.id')
                                       ->where(function($query){
                                            $query->where('doctor_patient.doctor_id', '=', '"'.Auth::user()->id.'"');
                                            $query->orWhere('posts.user_id', '=', '"'.Auth::user()->id.'"');    
                                        })
                                       ->where('posts.created_at', '<' , $lastitem->created_at)
                                       ->count();  
                    }
                }
                else
                {

                    if(Auth::user()->is_patient())
                    {
                        $remaining = DB::table('posts')
                                        ->leftjoin('doctor_patient','doctor_patient.doctor_id', '=' ,  'posts.user_id')
                                        ->join('users', 'posts.user_id', '=','users.id')
                                        ->where('posts.created_at', '<' , $lastitem->created_at)
                                        ->where(function($query){
                                            $query->where('doctor_patient.patient_id', '=',''.Auth::user()->id.'');
                                            $query->orWhere('posts.user_id', '=', ''.Auth::user()->id.'');    
                                        })
                                        ->count();  
                    }
                    else
                    {
                        $remaining = DB::table('posts')
                                        ->leftjoin('doctor_patient', 'posts.user_id', '=' , 'doctor_patient.patient_id')
                                        ->join('users', 'posts.user_id', '=','users.id')
                                        ->where('posts.created_at', '<' , $lastitem->created_at)
                                        ->where(function($query){
                                            $query->where('doctor_patient.doctor_id', '=', '"'.Auth::user()->id.'"');
                                            $query->orWhere('posts.user_id', '=', '"'.Auth::user()->id.'"');    
                                        })
                                        ->count();    
                    } 
                }                    
            }                      

  			return json_pretty(['posts'  => $posts ,
                                'remaining' => $remaining,
                            ]);
    	}
    }


    public function post($id)
    {
        $post = Post::findOrFail($id);

        return view('post', compact('post'));
    }
}
