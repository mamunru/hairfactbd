<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class InclinicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_inclinic_name(){
		$data=DB::table('inclinics')->orderBy('name','asc')->get();
		return response()->json($data);	   
    }

    public function get_inclinic_file($id){
        $data=DB::table('inclinicfiles')->where('inclinicid','=',$id)->get();
		return response()->json($data);
    }
}
