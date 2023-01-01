<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CycllcalnutritionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_post(){
        
		$data=DB::table('cycllcalnutritions')->first();
		
		return response()->json($data);
		   
		
    }
}
