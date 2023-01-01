<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ImageSliderContoller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['imageslider']]);
    }

    public function imageslider(){
		$data=DB::table('imagesliders')->orderBy('created_at','desc')->get();
		return response()->json($data);
    }
    
}
