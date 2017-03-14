<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PublicController extends Controller
{

    public function api_constants_get(Request $request)
    {	
    	$key= $request->input('key');
    	$cons = config('constants.constants');
    	$cons_arr = array();

        foreach ($cons as $con) 
        {
        	
        	$get = $request->input($con);

        	if($get == 1) 
        	{
        		$cons_arr[$con]	= config('constants.'.$con);
        	}

        }

        return json_pretty(['constants' => $cons_arr]);
    }
}
