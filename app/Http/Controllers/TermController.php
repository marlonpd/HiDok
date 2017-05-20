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
    public function api_terms_get()
    {
        $term_type = config('constants.term_type');
        $terms = array();

        foreach($term_type as $type)
        {
            $terms[$type] = Term::where('type', '=' , $type)
                               ->get();
        }

        return json_pretty($terms);
    }
}
