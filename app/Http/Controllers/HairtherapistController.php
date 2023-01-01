<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HairtherapistController extends Controller
{
    public function get_therapist_list(){
        $data=DB::table('hairtherapists')->get();
        return response()->json($data);
    }

   
}
