<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_image_files(){
		$data=DB::table('images')->orderBy('created_at','desc')->get();
		return response()->json($data);
    }
}
