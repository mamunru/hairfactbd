<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_category(){
		$data=DB::table('categories')->get();
		return response()->json($data);	   
    }
   
}
