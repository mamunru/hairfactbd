<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Models\notificationhistory;
  
class NotificationController extends Controller
{

    public function test($id){
        return $id;
    }

    public function notification_page(){

        $datas =DB::table('notificationhistories')
        ->select('notificationhistories.*','userprofiles.name as name')
      ->leftJoin('userprofiles', 'notificationhistories.userid','=','userprofiles.userid')
        ->latest()->paginate(25);
        return view('admin.notification.notificationhistory',['datas'=>$datas]);
    }

    public function add_notification_page(){
        $data['userprofiles'] =DB::table('users')->where('status','=',1)
    ->select('userprofiles.*')
    ->leftJoin('userprofiles', 'users.id','=','userprofiles.userid')
    ->orderBy('name','asc')->get();
    return view('admin.notification.sendnotification',$data);
    }

    public function send_notification(Request $request){

        

        if ($request->userid==0) {
            $get_deviceinfo=DB::table('deviceinfos')->get();
            foreach($get_deviceinfo as $key){
                notificationhistory::create([
                    'userid'=>$key->userid,
                    'title'=>$request->title, 
                    'body' =>$request->message,
                ]);
        
                 $this->sendNotification($key->deviceid, array(
                  "title" => $request->title, 
                  "body" => $request->message
                ));

                return redirect('admin/all/notification/'.$request->userid)->with('message', 'Messange Send Successfully');


            }
        }else{
            $get_deviceinfo=DB::table('deviceinfos')->where('userid','=',$request->userid)->first();
            notificationhistory::create([
                'userid'=>$get_deviceinfo->userid,
                'title'=>$request->title, 
                'body' =>$request->message,
            ]);
    
             $this->sendNotification($get_deviceinfo->deviceid, array(
              "title" => $request->title, 
              "body" => $request->message
            ));

            return redirect('admin/all/notification/'.$request->userid)->with('message', 'Messange Send Successfully');

        }

        
       
        
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function send(Request $request)
    {

       $get_deviceinfo=DB::table('deviceinfos')->where('userid',$request->id)->first();
       
        notificationhistory::create([
            
            'userid'=>$get_deviceinfo->userid,
            'title'=>$request->title, 
            'body' =>$request->body,
        ]);

        return $this->sendNotification($get_deviceinfo->deviceid,
            //'fSzRA6WaRpyOwdbFaN_1R5:APA91bGjzEIQEm_wjc55D8dBB-gqJInnOjpd3HPEsfGdpozbLB1RsP3A6iEVQJD497V2M8bgZnqyy2gyUtYXaIsxZc_M8hJEVUaS48NGTV_GJKZYxeSQLzgGIQwfwZS9HBHBAc87YlFt', 
        array(
          "title" => $request->title, 
          "body" => $request->body
        ));
    }


    public function setnotification($id,$tx)
    {

        $get_deviceinfo=DB::table('deviceinfos')->where('userid',$id)->first();
       
        notificationhistory::create([
            
            'userid'=>$get_deviceinfo->userid,
            'title'=>"Thanks For Your Order", 
            'body' =>'Your Order Successfully Received. Txt cod'.$tx,
        ]);

        return $this->sendNotification($get_deviceinfo->deviceid, array(
          "title" => $request->title, 
          "body" => $request->body,
          "click_action" =>'/message'
        ));
    }

    public function Coustomenotification($id,$message)
    {

        $get_deviceinfo=DB::table('deviceinfos')->where('userid',$id)->first();

        notificationhistory::create([
            
            'userid'=>$get_deviceinfo->userid,
            'title'=>$message['title'], 
            'body' =>$message['body'],
        ]);

     return  $this->sendNotification($get_deviceinfo->deviceid, array(
            'title'=>$message['title'], 
            'body' =>$message['body'],
          "click_action" =>'/notification'
        ));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAvjlKGHs:APA91bEW5zbcmYktNcLBvOmPlEHJmftfE2Y7GkMpmmzk-6Y32eFgy-4QsQnCrGXhxmGEd0DDn0YZ6_jhbU6tNObg9lk7hPlzKw_fZMBoaEwuQAgn_sYLCA0HigwwFVQLyfrF0f85fjv-';
        //$SERVER_API_KEY='AAAAj8XBRtI:APA91bFEIgTaEqFf7EznL39u_112oI7XiEicosrUWzNxGTjzS88t9fLWS-QAyqSQcJTO8hWKY01NwbYG0OzeLdy8BelfElJ5IvaUcl2rHJQSHaDpJgHmf0TxgymkkVW8bJM2IqhejJu5';
        // payload data, it will vary according to requirement
        $data = [
            "to"=>$device_token,
            //"to" => 'f_f47WpoRmu35BlRsn2GhD:APA91bGIBrCBHdBErjb2MnCQ_VDm51rmSerQyD_2rbHF4hoPiRDoROCGM51k2NtuLJfq--zGcXty6mJj2NtreRN68k5W7oKrPWQ9TRS-EAWF5MC8xPVTdQA82p05KWNLE2ZuiZ1Ujgr5',
            "notification" => $message,
            'priority'=> 'high',
          'data'=> array(
            'id'=> '1',
            'status'=> 'done',
          ),
           // "data"=>array("onclick"=>'/message')
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