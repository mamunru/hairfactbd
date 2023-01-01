<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\myorder;
use App\Models\paymentsuccess;
use App\Models\userwallet;
use App\Models\product;
use App\Models\deviceinfo;
use App\Models\shippingstaus;
use Illuminate\Support\Str;
use App\Models\notificationhistory;


class MyorderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function order_history($id){
        $value=Auth::guard('api')->user()->id;
        if ($value==$id) {
            $data=DB::table('myorders')->where('userid','=',$id)
            ->select('myorders.*','shippingstauses.status as shipping','shippingstauses.done as done')
            ->leftJoin('shippingstauses', 'myorders.txid','=','shippingstauses.txid')
            ->latest()->get();
		    return response()->json($data);
        }
    }

    public function order_request(Request $request){
        $value =Auth::guard('api')->user()->id;
        
        $uniqid = Str::random(9);
        $role = $this->barcodeNumberExists($uniqid);
        if ($role) {
            return order_request($request);
        }

        //$validateImageData = $uniqid->validate(['required','unique:myorders',]);
        $getcomision=product::where('id','=',$request->pid)->first();
    

        if ($value==$request->userid) {
            $file = new myorder;  
            $file->userid= $value;
            $file->name =$request->name;
            $file->address=$request->address;
            $file->mobile=$request->mobile;
            //$file->expected='';
            $file->qty=$request->qty;
            $file->rate=$getcomision->comisionrate;
            $file->price=$request->price;
            $file->remark=$request->remark;
            $file->user_name=$request->userName;
            $file->image =$request->image;
            $file->status="COD";
            $file->txid= 'cod'.$uniqid;
            $file->save();

            $shipfile = new shippingstaus;  
            $shipfile->txid='cod'.$uniqid;
            $shipfile->status ='Pending';
            $shipfile->done='Pending';
            $shipfile->save();

           // $get_deviceinfo=DB::table('deviceinfos')->where('userid',$value)->first();
                   
            
            $this->onsuccess($uniqid,$request);
             $this->comisionfunction($request);

             $checkcon= $this->setnotification($uniqid,$value);

            return response()->json($checkcon);


        }
    }

    function comisionfunction($request){

        $check=userwallet::where('userid','=',$request->userid)->exists();
        $getcomision=product::where('id','=',$request->pid)->first();

    
        if ($check) {
            $getdata=userwallet::where('userid','=',$request->userid)->first();
            $getcomision=product::where('id','=',$request->pid)->first();
            
            $comisionrate=(float)$getcomision->	comisionrate;
            $total=(float)$request->price * (int)$request->qty * $comisionrate /100;
            
            $newprice= (float)$getdata->price + (float)$total;

            DB::table('userwallets')->where('userid','=',$request->userid)->update([
                "price"=>(string)$newprice,

            ]);
            return response()->json($newprice);
           
        }else{
            $comision= new userwallet;
            $comisionrate=(float)$getcomision->	comisionrate;
            $total=(float)$request->price * (int)$request->qty * $comisionrate /100;
            $comision->userid=$request->userid;
            $comision->name=$request->name;
            $comision->mobile=$request->mobile;
            $comision->price=(int)$total;
            $comision->save();
        }

       
    }

    function barcodeNumberExists($number) {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return myorder::where('txid','=',$number)->exists();
    }

    function onsuccess($uniqid,$request){
        $value =Auth::guard('api')->user()->id;
        $qty=(int) $request->qty;
        $price=(float)$request->price;
        
        $file = new paymentsuccess;  
        $file->userid= $value;
        $file->mobile=$request->mobile;
        $file->qty=$request->qty;
        $file->price=$request->price;
        $file->totalprice= $qty*$price;
        $file->status=1;
        $file->txid=$uniqid;
        $file->save();
    }

    public function save_deviceid(Request $request){
        $value =Auth::guard('api')->user()->id;
        $check=deviceinfo::where('userid','=',$value)->exists();
        if ($check) {
            DB::table('deviceinfos')->where('userid','=',$value)->update([
                "deviceid"=>$request->deviceid,

            ]);
        }else{
            $file = new deviceinfo;  
        $file->userid= $value;
        $file->deviceid=$request->deviceid;
        $file->save();
        }
        
    }

    public function setnotification($uniqid,$id)
    {

        $get_deviceinfo=DB::table('deviceinfos')->where('userid',$id)->first();
       
        notificationhistory::create([
            'userid'=>$id,
            'title'=>"Thanks For Your Order", 
            'body' =>'Your Order Successfully Received tax id cod'.$uniqid,
        ]);

        return $this->sendNotification($get_deviceinfo->deviceid, array(
          "title" => "Thanks For Your Order", 
          "body" => 'Your Order Successfully Received tax id cod'.$uniqid
        ));
    }
  
    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAvjlKGHs:APA91bEW5zbcmYktNcLBvOmPlEHJmftfE2Y7GkMpmmzk-6Y32eFgy-4QsQnCrGXhxmGEd0DDn0YZ6_jhbU6tNObg9lk7hPlzKw_fZMBoaEwuQAgn_sYLCA0HigwwFVQLyfrF0f85fjv-';
  
        // payload data, it will vary according to requirement
                   
        $data = [
            "to" => $device_token, // for single device id
            "notification" => $message
        ];
        $dataString = json_encode($data);
        
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
    }
}
