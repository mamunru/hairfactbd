<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_subcategory(){
      $data=[];
      $data11=DB::table('subcategories')->orderBy('id','asc')->get();
      
      foreach ($data11 as $sku) {
      $array = [
         'id' => (int)$sku->id,
         'title' => $sku->title,
         'catid'=>$sku->catid,
         'description'=>$sku->description,
     ];
     array_push($data, $array);
    
      }
          
          
      return response()->json($data);	   
      }	   
    
}
