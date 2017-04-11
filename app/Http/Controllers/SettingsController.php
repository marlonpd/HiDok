<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Image;

//use App\hidok\Photo;


class SettingsController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }


    public function index()
    {
        //session()->flash('flash_message', 'test');
        $account_type = config('constants.account_type_rev.'.Auth::user()->account_type);

    	return view($account_type.'.settings');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($request->hasFile('photo')) {
            $public_path = public_path();
            $public_path = 'images/photo';
            $fileName = str_random(30);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $safename = $fileName.'.'.$extension;

            $request->file('photo')->move($photo_dir, $safename);
            Image::make($public_path.'/'.$photo_dir.'/'.$safename)->resize(200, 200)->save($public_path.'/'.$photo_dir.'/thumb/'.$safename);
            $user->update(['photo' => $photo_dir.'/'.$safename,
                           'thumbnail' => $photo_dir.'/thumb/'.$safename]);

        }

       
        $user->update($request->all());       

        return redirect('settings');
    }

    public function update_photo(){
        if($request->hasFile('photo')) 
        {            
        }
    }

    protected function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())->move($file);
    }
}
