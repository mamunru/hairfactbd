<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use File;
use App\Models\article;
use App\Models\cycllcalnutrition;
use App\Models\inclinic;
use App\Models\inclinicfile;
use App\Models\video;
use App\Models\image;
use App\Models\imageslider;
use send_notification_FCM;
use App\Models\hairtherapist;
use App\Models\givebonus;
use App\Models\userwallet;
use App\Models\userprofile;
use App\Models\notificationhistory;




class AdminPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
     public function profileControl()
    {
    	return view('admin.ViewProfile');
    }

    public function user_approve($id, $dr_id){
    	$value=Auth::guard('admin')->user()->id;
    	if ($id==$value) {
    	DB::table('users')->where('id',$dr_id)->update([
        'status'=>1
     ]);

    	
    	return redirect()->back()->with('message', 'Sucess');
    	}else{
    		return redirect()->back()->with('message', 'Unauthorized');
    	
    	}
    	
    }

    public function approve_user($id){

      $alluserdata = DB::table('users')->where('status','=',1)
      ->select('userprofiles.userid as userid','userprofiles.name as name','userprofiles.mobile as mobile','userprofiles.email as email','userprofiles.image as image'
      ,'users.status as status','userprofiles.created_at as created_at')
      ->leftJoin('userprofiles', 'users.id','=','userprofiles.userid')
      ->latest()
      ->paginate(25);
      
   return view('admin.alluser',['alluserdata'=>$alluserdata]);

    }
    
    
    
     public function user_delete($id, $dr_id){
      $value=Auth::guard('admin')->user()->id;
      if ($id==$value) {
      DB::table('users')->where('id',$dr_id)->delete();

      DB::table('userprofiles')->where('userid',$dr_id)->delete();

      return redirect()->back()->with('message', 'Account is Deleted');
      }else{
        return redirect()->back()->with('message', 'Unauthorized');
      
      }
      
    }




    public function admin_registration(Request $request){
        $admin=DB::table('admins')->where('email','=',$request->email)->first();
        $request->validate([
            'password' => 'required|min:6',
        ]);

        if(!empty($admin)){
            return redirect()->back()->with('message', 'Emain is already registered');
        }else{
        $data = array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        DB::table('admins')->insert($data);

        return view('admin.myadmin');
        }
    }

    public function admin_delete($id,$aid){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
            DB::table('admins')->where('id', '=', $aid)->delete();
            return redirect('/admin/view')->with('message', 'Success');
        }

    }



     public function user_suspend($id, $did){
      $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {

       $data1= DB::table('users')->where('id','=',$did)->update([
        'status'=>420
        ]);
       

        return redirect()->back()->with('message', 'Account Suspend Successfully');
        }

    }


    //Literatures

    public function article_view($id){
        $value=Auth::guard('admin')->user()->id ;
          if ($id==$value) {
            $articles =DB::table('articles')->orderBy('title','asc')->latest()->paginate(25);
            
            return view('admin.article',['articles'=>$articles]);
  
          }
  
      }

      public function article_add($id){
        $value=Auth::guard('admin')->user()->id ;
          if ($id==$value) {
           return view('admin.articleadd');
  
          }
  
      }

      public function article_save(Request $request){
        $value=Auth::guard('admin')->user()->id ;
        $id= $request->authid;
        $validatedData = $request->validate([
            'title' => ['required', 'unique:articles', 'max:255'],
            'file' => 'required|mimes:txt,csv,xlx,xls,pdf,docx',
        ]);
          if ($id==$value) {
          
            $file = new article;
    
            if($request->file()) { 
              if(!empty($request->incid)){
                $inclinic = new inclinicfile; 
                $name = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('inclinic', $name, 'public');
                $url = url('/storage/inclinic/'.$name);
                $inclinic->title =$request->title;
                $inclinic->inclinicid =$request->incid;
                $inclinic->details=$request->details;
                $inclinic->url = $url;
                $inclinic->file_real_name=$name;
                $inclinic->save();
    
               return redirect('/admin/inclinic/files/byid/'.$id.'/'.$request->incid)->with('message', 'File Add Successfully');
              
              }else{             
               $name = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('articles', $name, 'public');
                $url = url('/storage/articles/'.$name);
                $file->title =$request->title;
                $file->details =$request->details;
                $file->url = $url;
                $file->file_real_name=$name;
                $file->save();
    
               return redirect('/admin/article/'.$id)->with('message', 'Artical Add Successfully');
              }
              }

          }else{
              $request;
          }
  
      }

      public function article_edit($id ,$artid){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $article =DB::table('articles')->where('id','=',$artid)->first();
          //return $article;
          return view('admin.articleedit',['article'=>$article]);

        }

      }

      public function article_delete($id ,$artid){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $article =DB::table('articles')->where('id','=',$artid)->first();
          //return $article;
          Storage::delete('public/articles/'.$article->file_real_name);
              
          DB::table('articles')->where('id', '=', $artid)->delete();
         
          //return $inclinic;
        //  return view('admin.articleedit',['article'=>$inclinic]);
        return redirect()->back()->with('message', 'Delete Successfully');

        }

      }

      public function article_edit_save(Request $request){
        $value=Auth::guard('admin')->user()->id ;
        $id= $request->authid;
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => 'required|mimes:txt,csv,xlx,xls,pdf,docx',
        ]);
          if ($id==$value) {
          
            if(Storage::exists('public/articles/'.$request->file_real_name)){
              
            if($request->file()) {   

               $name = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('articles', $name, 'public');
                $url = url('/storage/articles/'.$name);

                Storage::delete('public/articles/'.$request->file_real_name);
                
                article::where('id',$request->id)->update([
                  'title'=>$request->title,
                  'details'=>$request->details,
                  'url' => $url,
                  'file_real_name'=>$name
                ]);
               return redirect('/admin/article/'.$id)->with('message', 'Artical Add Successfully');
              
            }
          }else{
            if(Storage::exists('public/inclinic/'.$request->file_real_name)){
              
              if($request->file()) {   
                if(!empty($request->incid)){
                 // return $request;
                 $name = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('inclinic', $name, 'public');
                $url = url('/storage/inclinic/'.$name);

                Storage::delete('public/inclinic/'.$request->file_real_name);
                
                inclinicfile::where('id',$request->id)->update([
                  'title'=>$request->title,
                  'details'=>$request->details,
                  'url' => $url,
                  'file_real_name'=>$name
                ]);
               return redirect('/admin/inclinic/files/byid/'.$id.'/'.$request->incid)->with('message', 'File Upload Successfully');
              
  
                }
              }else{
            return redirect()->back()->with('message', 'Something is Wrong');
                }
          }

          }
        }
      }

      //cycllcalnutrition_view

      
    public function cycllcalnutrition_view($id){
      $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $cycllcalnutrition =DB::table('cycllcalnutritions')->first();
          
          return view('admin.cycllcalnutrition',['cycllcalnutrition'=>$cycllcalnutrition]);

        }

    }

    public function cycllcalnutrition_add($id){
      $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $cycllcalnutrition =DB::table('cycllcalnutritions')->first();
        
         return view('admin.cycllcalnutritionedit',['cycllcalnutrition'=>$cycllcalnutrition]);

        }

    }

   
    

    public function cycllcalnutrition_edit_save(Request $request){
      $value=Auth::guard('admin')->user()->id ;
      $id= $request->authid;
      $validatedData = $request->validate([
          'title' => ['required', 'max:255'],
         
      ]);
        if ($id==$value) {
          $data =DB::table('cycllcalnutritions')->where('id','=',$request->id)->first();
          if(!empty($data)){
            cycllcalnutrition::where('id',$request->id)->update([
              'title'=>$request->title,
              'body'=>$request->details,
             
            ]);
          }else{
            $file = new cycllcalnutrition;
            $file->title =$request->title;
            $file->body =$request->details;
               
            $file->save();

          }
          
         return redirect('/admin/cycllcalnutrition/'.$id)->with('message', 'Post Add Successfully');

        
             }
            }

            //inclinic_view
            public function inclinic_view($id){
              $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $edit=[];
          $inclinics =DB::table('inclinics')->orderBy('name','asc')->latest()->paginate(25);
        
         return view('admin.inclinics',['inclinics'=>$inclinics,'edit'=>$edit]);

        }
            }


            public function inclinic_add($id){
              $value=Auth::guard('admin')->user()->id ;
                if ($id==$value) {
                  $inclinic=[];
                 return view('admin.inclinic.inclinicadd',['inclinic'=>$inclinic]);
        
                }
        
            }
      
            public function inclinic_save(Request $request){
              $value=Auth::guard('admin')->user()->id ;
              $id= $request->authid;
              $validatedData = $request->validate([
                  'name' => ['required', 'unique:inclinics', 'max:255'],
                 
              ]);
                if ($id==$value) {
                
                  $file = new inclinic;  
                     
                      $file->name =$request->name;
                      $file->description='';
                      $file->save();
          
                     return redirect('/admin/inclinic/'.$id)->with('message', 'Inclinic Add Successfully');
        
                  
      
                }else{
                 return redirect('/admin/inclinic/'.$id);
                }
        
            }

            public function inclinic_edit_page($id,$lid){
              $value=Auth::guard('admin')->user()->id ;
              if ($id==$value) {
              $edit=DB::table('inclinics')->where('id','=',$lid)->first();
              $inclinics = DB::table('inclinics')
                ->orderByRaw('name ASC')
                ->paginate(25);
      
            //return view('admin.refund_success',['alllist'=>$alllist]);
      
            return view('admin.inclinics',['inclinics'=>$inclinics,'edit'=>$edit]);
              }
      
          }
      
      
           public function inclinic_edit( Request $request){
      
             $validatedData = $request->validate([
              'name' => 'required|unique:inclinics|max:255',
          ]);
          $value=Auth::guard('admin')->user()->id ;
          $id=$request->authid;
              if ($id==$value) {
      
            DB::table('inclinics')->where('id','=',$request->id)->update([
              'name' => $request->name,
              
           ]);
      
            
      
            //return view('admin.refund_success',['alllist'=>$alllist]);
      
            return redirect('admin/inclinic/'.$id)->with('message', 'update Successfully');
          }
      
          }

          public function inclinic_file_by_id($id, $lid){
            $value=Auth::guard('admin')->user()->id ;
          
              if ($id==$value) {
              $inclinic=DB::table('inclinics')->where('id','=',$lid)->first();
              $inclinicfiles =DB::table('inclinicfiles')->where('inclinicid','=',$lid)->orderBy('title','asc')->latest()->paginate(25);
              return view('admin.article',['articles'=>$inclinicfiles,'inclinic'=>$inclinic]);
              }
          }

          public function inclinic_add_file_by_id($id, $incid){
            $value=Auth::guard('admin')->user()->id ;
              if ($id==$value) {
                $inclinic=DB::table('inclinics')->where('id','=',$incid)->first();
                return view('admin.articleadd',['inclinic'=>$inclinic]);
              }
          }


          public function inclinicfile_edit($id ,$incid){
            $value=Auth::guard('admin')->user()->id ;
            if ($id==$value) {
              $inclinic=DB::table('inclinicfiles')->where('id','=',$incid)->first();
              
              //return $inclinic;
              return view('admin.articleedit',['article'=>$inclinic]);
    
            }
    
          }

          public function inclinicfile_delete($id ,$incid){
            $value=Auth::guard('admin')->user()->id ;
            if ($id==$value) {
              $inclinic=DB::table('inclinicfiles')->where('id','=',$incid)->first();
              Storage::delete('public/inclinic/'.$inclinic->file_real_name);
              
              DB::table('inclinicfiles')->where('id', '=', $incid)->delete();
             
              //return $inclinic;
            //  return view('admin.articleedit',['article'=>$inclinic]);
            return redirect()->back()->with('message', 'Delete Successfully');
          
            }
    
          }


       //Video Section   

       public function video_view($id){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $videos =DB::table('videos')->orderBy('title','asc')->latest()->paginate(25);
         return view('admin.video.videoPage',['videos'=>$videos]);
        }
       }

       public function video_add_form($id){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          //$videos =DB::table('videos')->orderBy('title','asc')->latest()->paginate(25);
         return view('admin.video.videoformPage');
        }
       }

      public function video_file_save(Request $request){
        $value=Auth::guard('admin')->user()->id ;
        $id= $request->authid;

        if(!empty($request->vid)){

          //Upload Section
          if (!empty($request->url && $id==$value )) {
            $validatedData = $request->validate([
              'title' => ['required', 'max:255'],
              'url' => 'required',
          ]);
          video::where('id',$request->vid)->update([
            'title'=>$request->title,
            'url' => $request->url,
            'file_real_name'=>$request->file_real_name,
          ]);
  
         
         return redirect('/admin/video/'.$id)->with('message', 'File Upload Successfully');
          
         
          }else{
            $validatedData = $request->validate([
              'title' => ['required', 'max:255'],
              'file' => 'required|mimes:WEBM,MPG,MP2,MPEG,MPE,MPV,OGG,MP4,M4P,M4V,AVI,WMV,MOV,QT,FLV,SWF',
          ]);
          if ($id==$value && $request->file()) {
            
            $name = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('video', $name, 'public');
            $url = url('/storage/video/'.$name);
  
            Storage::delete('public/video/'.$request->file_real_name);
            
            video::where('id',$request->vid)->update([
              'title'=>$request->title,
              'url' => $url,
              'file_real_name'=>$name
            ]);
           return redirect('/admin/video/'.$id)->with('message', 'File Upload Successfully');
          
          }
  
          }
          
         // return $request;

        }else{
          if (!empty($request->url && $id==$value )) {
            $validatedData = $request->validate([
              'title' => ['required', 'max:255'],
              'url' => 'required',
          ]);
  
          $file = new video;  
                        $file->title =$request->title;
                        $file->file_real_name='url';
                        $file->url =$request->url;
                        $file->save();
                        return redirect('/admin/video/'.$id)->with('message', 'File Upload Successfully');
          
         
          }else{
            $validatedData = $request->validate([
              'title' => ['required', 'max:255'],
              'file' => 'required|mimes:WEBM,MPG,MP2,MPEG,MPE,MPV,OGG,MP4,M4P,M4V,AVI,WMV,MOV,QT,FLV,SWF',
          ]);
          if ($id==$value && $request->file()) {
            
            $name = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('video', $name, 'public');
            $url = url('/storage/video/'.$name);
  
            //Storage::delete('public/video/'.$request->file_real_name);
            $file = new video;  
                        $file->title =$request->title;
                        $file->file_real_name=$name;
                        $file->url =$url;
                        $file->save();
            
           
           return redirect('/admin/video/'.$id)->with('message', 'File Upload Successfully');
          
          }
  
          }
          
        }

        
      } 

      public function video_edit_form($id,$vid){
        $value=Auth::guard('admin')->user()->id ;
        if ($value==$id) {
          $video =DB::table('videos')->where('id','=',$vid)->first();
         return view('admin.video.videoformPage',['video'=>$video]);
        }else{
          return redirect('/admin');
        }
      }

      public function video_delete_form($id,$vid){
        $value=Auth::guard('admin')->user()->id ;
        if ($value==$id) {
          $video =DB::table('videos')->where('id','=',$vid)->first();
          Storage::delete('public/inclinic/'.$video->file_real_name);
              
          DB::table('videos')->where('id', '=', $vid)->delete();
                      
         return redirect()->back()->with('message', 'Delete Successfully');

       //  return view('admin.video.videoformPage',['video'=>$video]);
        }else{
          return redirect('/admin');
        }
      }


      //Image Section 

      public function image_view($id){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          $images =DB::table('images')->orderBy('title','asc')->latest()->paginate(25);
         return view('admin.image.imagePage',['images'=>$images]);
        }
      }

      public function image_add_form($id){
        $value=Auth::guard('admin')->user()->id ;
        if ($id==$value) {
          //$videos =DB::table('videos')->orderBy('title','asc')->latest()->paginate(25);
         return view('admin.image.imageformPage');
        }
       }

       public function image_edit_form($id,$vid){
        $value=Auth::guard('admin')->user()->id ;
        if ($value==$id) {
          $image =DB::table('images')->where('id','=',$vid)->first();
         return view('admin.image.imageformPage',['image'=>$image]);
        }else{
          return redirect('/admin');
        }
      }

      //image_delete_form
      public function image_delete_form($id,$vid){
        $value=Auth::guard('admin')->user()->id ;
        if ($value==$id) {
          $image =DB::table('images')->where('id','=',$vid)->first();
          Storage::delete('public/image/'.$image->file_real_name);
              
          DB::table('images')->where('id', '=', $vid)->delete();
             
          return redirect()->back()->with('message', 'Image Delete Successfully');
        }else{
          return redirect('/admin');
        }
      }

      public function image_file_save(Request $request){
        $value=Auth::guard('admin')->user()->id ;
        $id= $request->authid;
        $validatedData = $request->validate([
          'title' => ['required', 'max:255'],
          'file' => 'required|mimes:jpg,jpeg,png',
      ]);
       if($id==$value){
          if (!empty($request->vid)) {
          if($request->file()){
          

          $name = time().'_'.$request->file->getClientOriginalName();  
          $filePath = $request->file('file')->storeAs('image', $name, 'public');
          $url = url('/storage/image/'.$name);
  
          Storage::delete('public/image/'.$request->file_real_name);
            
            image::where('id',$request->vid)->update([
              'title'=>$request->title,
              'url' => $url,
              'file_real_name'=>$name
            ]);
           return redirect('/admin/image/'.$id)->with('message', 'File Upload Successfully');
          
          }
            
        }else{
         
        if ($request->file()) {
          
          $name = time().'_'.$request->file->getClientOriginalName();
          $filePath = $request->file('file')->storeAs('image', $name, 'public');
          $url = url('/storage/image/'.$name);
  
          //Storage::delete('public/video/'.$request->file_real_name);
          $file = new image;  
          $file->title =$request->title;
          $file->file_real_name=$name;
          $file->url =$url;
          $file->save();
          
         
         return redirect('/admin/image/'.$id)->with('message', 'File Upload Successfully');
        
        }
  
      
      }
    }else{
      return redirect('/admin');
    }
    
  }

  //image
  public function image_slider_view($id){
    $value=Auth::guard('admin')->user()->id ;
    if ($id==$value) {
      $images =DB::table('imagesliders')->orderBy('created_at','asc')->latest()->paginate(25);
     return view('admin.imageslider.imagePage',['images'=>$images]);
    }
  }

  public function image_slider_add_form($id){
    $value=Auth::guard('admin')->user()->id ;
    if ($id==$value) {
      //$videos =DB::table('videos')->orderBy('title','asc')->latest()->paginate(25);
     return view('admin.imageslider.imageformPage');
    }
   }

   public function image_slider_edit_form($id,$vid){
    $value=Auth::guard('admin')->user()->id ;
    if ($value==$id) {
      $image =DB::table('imagesliders')->where('id','=',$vid)->first();
     return view('admin.imageslider.imageformPage',['image'=>$image]);
    }else{
      return redirect('/admin');
    }
  }

  public function image_slider_delete($id,$vid){
    $value=Auth::guard('admin')->user()->id ;
    if ($value==$id) {

      $image =DB::table('imagesliders')->where('id','=',$vid)->first();
  
      Storage::delete('public/imageslider/'.$image->file_name);

      $detate=DB::table('imagesliders')->where('id','=',$vid)->delete();
     
      return redirect('/admin/imageslider/'.$id)->with('message', 'Image Slider Delete Successfully');
      
    }else{
      return redirect('/admin');
    }
  }

  public function image_slider_file_save(Request $request){
    $value=Auth::guard('admin')->user()->id ;
    $id= $request->authid;
    $validatedData = $request->validate([
      'title' => ['required', 'max:255'],
      'file' => 'required|mimes:jpg,jpeg,png',
  ]);
   if($id==$value){
      if (!empty($request->vid)) {
      if($request->file()){
      

      $name = time().'_'.$request->file->getClientOriginalName();  
      $filePath = $request->file('file')->storeAs('imageslider', $name, 'public');
      $url = url('/storage/imageslider/'.$name);

      Storage::delete('public/imageslider/'.$request->file_real_name);
        
      imageslider::where('id',$request->vid)->update([
          'title'=>$request->title,
          'url' => $url,
          'file_name'=>$name
        ]);
       return redirect('/admin/imageslider/'.$id)->with('message', 'File Upload Successfully');
      
      }
        
    }else{
     
    if ($request->file()) {
      
      $name = time().'_'.$request->file->getClientOriginalName();
      $filePath = $request->file('file')->storeAs('imageslider', $name, 'public');
      $url = url('/storage/imageslider/'.$name);

      //Storage::delete('public/video/'.$request->file_real_name);
      $file = new imageslider;  
      $file->title= $request->title;
      $file->file_name=$name;
      $file->url =$url;
      $file->save();
      
     
     return redirect('/admin/imageslider/'.$id)->with('message', 'File Upload Successfully');
    
    }

  
  }
}else{
  return redirect('/admin');
}

}


public function notifyUser(Request $request){
 
  $user = User::where('id', $request->id)->first();

  $notification_id = $user->notification_id;
  $title = "Greeting Notification";
  $message = "Have good day!";
  $id = $user->id;
  $type = "basic";

  $res = send_notification_FCM($notification_id, $title, $message, $id,$type);

  if($res == 1){

     // success code

  }else{

    // fail code
  }
   

}


public function hairtherapi_view ($id){

  $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $dates =DB::table('hairtherapists')
           ->latest()->paginate(25);
            
            return view('admin.hairteatment.hairteatment',['dates'=>$dates]);
        }
 
}


public function add_therapist_form ($id){
  //$data['categories'] =DB::table('categories')->orderBy('name','asc')->latest()->paginate(25);
  $therapists=[];
  return view('admin.hairteatment.edithairteatment',[ 'therapists'=>$therapists]);
}

public function therapist_add_view(Request $request){
  $value=Auth::guard('admin')->user()->id;
  if ($value==$request->authid) {
      
          if (!empty($request->id)) {
          DB::table('hairtherapists')->where('id','=',$request->id)->update([
              "title"=>$request->title,
              "url"=>$request->url,
             

          ]);
      
          return redirect('admin/hairtherapi/'.$value)->with('message', $request->title.' Update Successfully');
          }else{

              $validateImageData = $request->validate([
                  'title'=>['required'],
                  ]);

              $subcategory = new hairtherapist;
              $subcategory->title =$request->title;
              $subcategory->url=$request->url;
              $subcategory->save();
          
              return redirect('admin/hairtherapi/'.$value)->with('message', $request->title.' Add Successfully');
              

          }
     
     }
}


public function therapist_add_byid_view($id,$tid){
  $value=Auth::guard('admin')->user()->id;
  if ($value==$id) {

     
      $therapists =DB::table('hairtherapists')->where('id','=',$tid)
     ->select('hairtherapists.*')
     
      ->first();
  
      return view('admin.hairteatment.edithairteatment',[ 'therapists'=>$therapists]);
  }
}

public function therapist_delate_byid_view($id,$tid){
  $value=Auth::guard('admin')->user()->id;
  if ($value==$id) {

     $detate=DB::table('hairtherapists')->where('id','=',$tid)->delete();
     return back()->with('message', 'Delete Successfully');
          
  }
}

//Bonus Section

public function bonus_page($id){
  $value=Auth::guard('admin')->user()->id;
  if ($value==$id) {
    $datas =DB::table('givebonuses')
    ->select('userprofiles.userid as userid','userprofiles.name as name','userprofiles.mobile as mobile','userprofiles.email as email','userprofiles.image as image'
      ,'givebonuses.amount as amount','givebonuses.note as note','admins.name as admin','givebonuses.created_at as created_at')
      ->leftJoin('userprofiles', 'givebonuses.userid','=','userprofiles.userid')
      ->leftJoin('admins', 'givebonuses.adminid','=','admins.id')
      
      ->latest()->paginate(25);
           return view('admin.givebonus.givebonushistory',[ 'datas'=>$datas]);
  
  }
}

public function edit_bonus_page($id){

  $value=Auth::guard('admin')->user()->id;
  if ($value==$id){
    $data['userprofiles'] =DB::table('users')->where('status','=',1)
    ->select('userprofiles.*')
    ->leftJoin('userprofiles', 'users.id','=','userprofiles.userid')
    ->orderBy('name','asc')->get();
           
    return view('admin.givebonus.sendbonus',$data);
  }
}

public function send_bonus(Request $request){
  $value=Auth::guard('admin')->user()->id;
  if ($value ==$request->authid) {
    $validateImageData = $request->validate([
      'amount'=>['required'],
      ]);

  $bonus = new givebonus;
  $bonus->adminid =$request->authid;
  $bonus->userid=$request->userid;
  $bonus->amount=$request->amount;
  $bonus->note=$request->note;
  $bonus->save();



  $this->comisionfunction($request);

  return redirect('admin/give/bonus/'.$value)->with('message', ' Bonus Send Successfully');
  

  }
}


function comisionfunction($request){
   // 

  $check=userwallet::where('userid','=',$request->userid)->exists();
  


  if ($check) {
      $getdata=userwallet::where('userid','=',$request->userid)->first();
      
      $total=(float)$request->amount;
      
      $newprice= (float)$getdata->price + (float)$total;

      DB::table('userwallets')->where('userid','=',$request->userid)->update([
          "price"=>(int)$newprice,

      ]);
      
     // return response()->json([$newprice]);
     
  }else{
    $getdata=DB::table('userprofiles')->where('userid',$request->userid)->first();
    // 
      $comision= new userwallet;
      $total=(float)$request->amount;
     
      
      $comision->userid=$request->userid;
      $comision->name=$getdata->name;
      $comision->mobile=$getdata->mobile;
      $comision->price=(int)$total;
      $comision->save();
      
  }
  
  $this->setnotification($request);

 
}


 public function setnotification($request)
    {

        $get_deviceinfo=DB::table('deviceinfos')->where('userid',$request->userid)->first();
       
        notificationhistory::create([
            
            'userid'=>$get_deviceinfo->userid,
            'title'=>"Congratulations ", 
            'body' =>'Your have Successfully Received Bonus '.$request->amount,
        ]);

         $this->sendNotification($get_deviceinfo->deviceid, array(
          'title'=>"Congratulations ", 
          'body' =>'Your have Successfully Received Bonus '.$request->amount,
          
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
