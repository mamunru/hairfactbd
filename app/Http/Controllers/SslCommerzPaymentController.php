<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\myorder;
use App\Models\mycart;
use App\Models\userwallet;
use App\Models\product;
use App\Models\User;
use App\Models\notificationhistory;
use App\Models\shippingstaus;
use Illuminate\Support\Str;


class SslCommerzPaymentController extends Controller
{

   
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $getdata=mycart::where('user','=',$request->cus_id)->get();
        
        $totalcheck=0;
        
        


        $post_data = array();
        # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); 
        
        // tran_id must be unique
        foreach ($getdata as $attribute) {
            $file = new myorder;  
          $file->userid= $request->cus_id;
          $file->name =$attribute->title;
          $file->address=$request->address;
          $file->mobile=$request->mobile;
          //$file->expected='';
          $file->qty=$attribute->qty;
          $file->rate=$attribute->comisionrate;
          $file->price=$attribute->price;
          $file->remark=$request->remark;
          $file->user_name=$request->cus_name;
          $file->image =$attribute->image;
          $file->status='Pending';
          $file->txid=$post_data['tran_id'];
          $file->save();

          $totalcheck=$totalcheck + ((float)$attribute->price * (int)$attribute->qty);

          DB::table('mycarts')->where('id','=',$attribute->id)->delete();

      }

      $post_data['total_amount'] = $totalcheck; 

        # CUSTOMER INFORMATION
        
        $post_data['cus_name'] = $request->cus_name;
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = $request->cus_id;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "HairFactBD";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
       

        
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'userid'=>$post_data['cus_postcode'],
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'userid'=>$post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $userid = $request->input('cus_postcode');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('userid','transaction_id', 'status', 'currency', 'amount')->first();
        // $myorder_detials = DB::table('myorders')
        //     ->where('txid', $tran_id)->get();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);


                $update_myproduct = DB::table('myorders')
                    ->where('txid', $tran_id)
                    ->update(['status' => 'Processing']);

                    $file = new shippingstaus;  
                    $file->txid= $tran_id;
                    $file->status ='Pending';
                    $file->done='Pending';
                    
                    //$file->expected='';
                    
                    $file->save();

                    
                    $get_myproduct = DB::table('myorders')->where('txid', $tran_id)->get();

                    $get_deviceinfo=DB::table('deviceinfos')->where('userid',$order_detials->userid)->first();
                   
                 $this->comisionfunction($get_myproduct); 
                 $this->sendNotification($get_deviceinfo->deviceid, array(
                    "title" => 'Payment Success', 
                    "body" => 'Thanks For Your Order.'
                  ));
                 

                echo "<br >Transaction is successfully Completed";
                echo "<script type='text/javascript'>Message.postMessage('Transaction is successfully Completed');</script>";
                echo "<script type='text/javascript'>Print.postMessage('1');</script>";
                
                // $client = new \GuzzleHttp\Client();
                // $body['device_token'] = $get_deviceinfo->deviceid;
                // $body['title'] = 'Payment Success';
                // $body['body'] = 'Thanks For Your Order. Your Transaction ';
                // $url = "http://localhost/hairfactbd/api/auth/send/notification";
                // $response = $client->request("POST", $url, ['form_params'=>$body]); 
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                    $update_myproduct = DB::table('myorders')
                    ->where('txid', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
                echo "<script type='text/javascript'>Message.postMessage('Transaction Fail');</script>";
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
            echo "<script type='text/javascript'>Message.postMessage('Transaction is successfully Completed');</script>";
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);

            $update_myproduct = DB::table('myorders')
                ->where('txid', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
            echo "<script type='text/javascript'>Message.postMessage('Transaction is Falied');</script>";
            
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
            echo "<script type='text/javascript'>Message.postMessage('Transaction is already Successful');</script>";
                
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            $update_myproduct = DB::table('myorders')
                ->where('txid', $tran_id)
                ->update(['status' => 'Canceled']);    
            echo "Transaction is Cancel";
            echo "<script type='text/javascript'>Message.postMessage('Transaction is Cancel');</script>";
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";

        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
            echo "<script type='text/javascript'>Message.postMessage('Transaction is already Successful');</script>";
            echo "<script type='text/javascript'>Print.postMessage('1');</script>";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);
                    
                    $update_myproduct = DB::table('myorders')
                        ->where('txid', $tran_id)
                        ->update(['status' => 'Processing']);    

                    echo "Transaction is successfully Completed";
                    echo "<script type='text/javascript'>Message.postMessage('Transaction is Successfully Completed');</script>";
                    echo "<script type='text/javascript'>Print.postMessage('1');</script>";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);
                    $update_myproduct = DB::table('myorders')
                        ->where('txid', $tran_id)
                        ->update(['status' => 'Failed']);                

                    echo "validation Fail";
                    echo "<script type='text/javascript'>Message.postMessage('Transaction Fail');</script>";
                    echo "<script type='text/javascript'>Print.postMessage('1');</script>";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
                echo "<script type='text/javascript'>Message.postMessage('Transaction is already Successful');</script>";
                echo "<script type='text/javascript'>Print.postMessage('1');</script>";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }

        
    }

    public function text(Request $request){
         $data=array() ;
         $decoded = $request->product; 
         $getdata=mycart::where('user','=',$request->cus_id)->get();
        foreach ($getdata as $attribute) {
              $file = new myorder;  
            $file->userid= $request->cus_id;
            $file->name =$attribute->name;
            $file->address='dlkfkdf';
            $file->mobile='17530000';
            //$file->expected='';
            $file->qty=$attribute->qty;
            $file->rate='10';
            $file->price=$attribute->price;
            $file->remark='kdjjkadf';
            $file->user_name='dadafd';
            $file->image =$attribute->image;
            $file->status=$attribute->status;
            $file->txid='12ss5';
            $file->save();

        }
        //for($count = 0; $count < count($decoded); $count++){
          //  $data = $decoded;
            // $file = new myorder;  
            // $file->userid= 1;
            // $file->name =$attribute['title'];
            // $file->address='dlkfkdf';
            // $file->mobile='17530000';
            // //$file->expected='';
            // $file->qty=$attribute["qty"];
            // $file->rate='10';
            // $file->price=$attribute["price"];
            // $file->remark='kdjjkadf';
            // $file->user_name='dadafd';
            // $file->image =$attribute["image"];
            // $file->status=$attribute["status"];
            // $file->txid='12ss5';
            // $file->save();
       // }
        
        return $request;
    }


    function comisionfunction($data){

        
       foreach ($data as $key) {
        $check=userwallet::where('userid','=',$key->userid)->exists();
        $getcomision=product::where('title','=',$key->name)->first();
    
        if ($check) {
            $getdata=userwallet::where('userid','=',$key->userid)->first();
            //$getcomision=product::where('id','=',$request->pid)->first();
            
            $comisionrate=(float)$getcomision->	comisionrate;
            $total=(float)$key->price * (int)$key->qty * $comisionrate /100;
            
            $newprice= (float)$getdata->price + (float)$total;

            DB::table('userwallets')->where('userid','=',$key->userid)->update([
                "price"=>(int)$newprice,

            ]);
           // return response()->json([$newprice]);
           
        }else{
            $comision= new userwallet;
            $comisionrate=(float)$getcomision->	comisionrate;
            $total=(float)$key->price * (int)$key->qty * $comisionrate /100;
            $comision->userid=$key->userid;
            $comision->name=$key->name;
            $comision->mobile=$key->mobile;
            $comision->price=(int)$total;
            $comision->save();
        }

       }
       
    }


    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAvjlKGHs:APA91bEW5zbcmYktNcLBvOmPlEHJmftfE2Y7GkMpmmzk-6Y32eFgy-4QsQnCrGXhxmGEd0DDn0YZ6_jhbU6tNObg9lk7hPlzKw_fZMBoaEwuQAgn_sYLCA0HigwwFVQLyfrF0f85fjv-';
  
        // payload data, it will vary according to requirement
                   
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);
        $get_deviceinfo=DB::table('deviceinfos')->where('deviceid',$device_token)->first();
       
        notificationhistory::create([
            
            'userid'=>$get_deviceinfo->userid,
            'title'=>'Payment Success', 
            'body' =>'Thanks For Your Order.',
        ]);
    
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
      
       // return $response;
    }

}
