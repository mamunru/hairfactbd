<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_articles(){
        
		$data=DB::table('articles')->orderBy('created_at','desc')->get();
		
		return response()->json($data);
		   
		
    }


    
}
