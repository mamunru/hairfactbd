<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_video_files(){
		$data=DB::table('videos')->orderBy('created_at','desc')->get();
		return response()->json($data);
    }

}
