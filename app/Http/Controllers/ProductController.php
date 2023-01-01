<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['get_product']]);
    }

    public function get_product(){
        // $dataarray=array();
		// // $data=DB::table('products')
        // // ->select('products.*','productimages.*')
        // // ->Join('productimages', 'products.id','=','productimages.productid')
        // // ->orderBy('products.created_at','desc')->get();
        // $data=DB::table('products')->get();
        // foreach ($data as $div) 
        // {
        // $dataarray[] = $div ;
        // $imagefiles=DB::table('productimages')->where('productid','=',$div->id)->get();
        // $dataarray[]= $imagefiles;
        // }

        $productdata=DB::table('products')->where('status','=',1)->orderBy('created_at','desc')->get();
        $producimage=DB::table('productimages')->orderBy('created_at','desc')->get();
		return response()->json([
            'productdata'=>$productdata,
            'productimage'=>$producimage,
        ]);
    }
}
