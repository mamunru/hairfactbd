<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\mycart;

class MycartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function cart_save_data(Request $request,$id){
      $file = new mycart;  
            $file->user= $id;
            $file->title =$request->title;
            $file->description=$request->description;
            $file->catid=$request->catid;
            $file->subcatid=$request->subcatid;
            $file->qty=$request->qty;
            $file->rate=$request->rate;
            $file->price=$request->price;
            $file->comisionrate=$request->comisionrate;
            $file->file_real_name=$request->file_real_name;
            $file->image =$request->image;
            $file->remark='remark';
            $file->status=1;
            $file->save();
		//$data=DB::table('subcategories')->orderBy('id','asc')->get();
		return response()->json($id);	   
    }
}
