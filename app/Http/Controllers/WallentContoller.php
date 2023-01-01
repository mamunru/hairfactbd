<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\walethistory;
use App\Models\userwallet;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\bankdetail;


class WallentContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_wallet($id){
        $value=Auth::guard('api')->user()->id;
        if ($value==$id) {
            $data=DB::table('userwallets')->where('userid','=',$id)->first();
		    return response()->json($data);
        }
    }

    public function balancewithdrow(Request $request){
        $value =Auth::guard('api')->user()->id;
        $uniqid = Str::random(9);
        $role = $this->barcodeNumberExists($uniqid);
        if ($role) {
            return order_request($request);
        }
        $getdata=userwallet::where('userid','=',$request->userid)->first();
       

        $totalbalance=(int)$getdata->price-(int)$request->request_balance;
        $data=DB::table('walethistories')->where('userid','=',$value)->whereDate('created_at', Carbon::today())->first();
        $checkvalidation = (int)$getdata->price >=(int)$request->request_balance; 
        if ($value==$request->userid && empty($data)&& $checkvalidation && $getdata->price !='0' && $request->request_balance>99) {
            $file = new walethistory;  
            $file->userid= $value;
            $file->request_balance =(int)$request->request_balance;
            $file->amount=$getdata->price;
            $file->totalbalance=$totalbalance;
            $file->txid=$uniqid;
            $file->status='prnding';
           
            $file->save();

           
            $this->updatemywallet($request);


            return response()->json([
                'code' => 200,
                
                'message'=>"Withdraw Request Accept Successfuly",
                 ]);


        }else{
            return response()->json(
                [
                    'code' => 111,
                    
                    'message'=>"You have a Padding Request Or Something is Wrong",
                     ]
            ); 
        }


    }


    function barcodeNumberExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return walethistory::where('txid','=',$number)->exists();
    }

    function updatemywallet($request){
        $getdata=userwallet::where('userid','=',$request->userid)->first();
        $withdrowamount= $request->request_balance;
        $newprice= (int)$getdata->price - (int)$withdrowamount;

        DB::table('userwallets')->where('userid','=',$request->userid)->update([
                "price"=>$newprice,

            ]);
    }


    public function save_bank_detals (Request $request){
        $value =Auth::guard('api')->user()->id;


        if ($value==$request->id) {
            $check=DB::table('bankdetails')->where('userid','=',$value)->exists();
            if ($check) {
                DB::table('bankdetails')->where('userid','=',$request->id)->update([
                    'bank' =>$request->bank,
    
                ]);
            }else{
                $file = new bankdetail;  
                $file->userid= $value;
                $file->bank =$request->bank;
                $file->save();
            }

            $data=DB::table('bankdetails')->where('userid','=',$value)->first();

            return response()->json($data);
           
        }
    }

    public function get_bank_detals($id){
        $value =Auth::guard('api')->user()->id;
        if ($value==$id) {
            $data=DB::table('bankdetails')->where('userid','=',$value)->first();

            return response()->json($data);
        }
    }
}
