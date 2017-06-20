<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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


    // api/post/post
    // /api/posts/get
  // /api/post/update/post
    // /api/post/delete/post
    // /api/post/post
    public function api_post_post(Request $request)
    {
        //return $request->input();
    	//$post = $this->create_post($request->input());

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

    /*public function api_posts_get()
    {
        if(Auth::user()->is_patient())
        {
            $posts = post::where('user_id' , '=' , Auth::user()->id)
                                ->orderBy('created_at', 'DESC')
                                ->get();
                       
        }
        else
        {

        }                        

        return json_pretty(['posts' => $posts]);                    
  
    }*/
 // /api/post/update/post
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
            

            if($lastdate == '')
            {
                $posts = Post::where('user_id','=' , Auth::user()->id)
                                        ->take(10)
                                        ->orderBy('created_at', 'DESC')
                                        ->get();
            }
            else
            {
                $posts = Post::where('user_id','=' , Auth::user()->id)
                                             ->where('created_at', '>' , $lastdate)
                                             ->take(10)
                                             ->orderBy('created_at', 'DESC')
                                             ->get();
            }

            $remaining = 0;
            $lastitem = $posts->last();
            
            if($lastitem)
            {
                $remaining = Post::where('user_id','=' , Auth::user()->id)
                                          ->where('created_at', '>' , $lastitem->created_at)
                                          ->count();
            }                      

  			return json_pretty(['posts'  => $posts ,
                                'remaining' => $remaining,
                            ]);
    	}
    }
}
