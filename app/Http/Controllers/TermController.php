<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Term;

class TermController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function index()
    {

    }

    // '/api/terms/get/{type}'
    public function api_terms_get(Request $request)
    {

        $term_type = config('constants.term_type');
        $terms = array();

        foreach($term_type as $type)
        {
            $terms[$type] = Term::where('type', '=' , $type)
                                ->pluck('name')->toArray();
                               //->get(['name']);
        }

        return json_pretty($terms);
    }

    public function api_terms_vitalsign_get()
    {
        $vital_sign = ["BR","BP", "TEMP"];

        $vital_sign =array('id' => 'asdfasdf', 'label'=> 'labels', 'value' => 'vals');

        return json_pretty($vital_sign);
    }
}
