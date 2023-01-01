<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use Storage;
use File;
use App\Models\product;
use App\Models\productimage;
use App\Models\category;
use App\Models\subcategory;
use Carbon\Carbon;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //All Product Action
    public function allproduct_view($id){
    $value=Auth::guard('admin')->user()->id;
    if ($value==$id) {
        //$products =DB::table('products')->orderBy('title','asc')->latest()->paginate(25);
        $products=DB::table('products')
        ->select('products.id as id','products.title as title','categories.name as catname','subcategories.title as subcatname','products.description as description','products.image as image','products.rate as rate','products.price as price','products.comisionrate as comisionrate','products.qty as qnt'
        ,'products.status as status','products.created_at as created_at')
        ->leftJoin('categories', 'categories.id','=','products.catid')
        ->leftJoin('subcategories', 'subcategories.id','=','products.subcatid')
        ->latest()
        ->paginate(25);
        
        return view('admin.productpage.AllProductPage',['products'=>$products]);
    }
   

    }

    public function order_view($id){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $products =DB::table('myorders')
            ->select('myorders.*','shippingstauses.status as shipping','shippingstauses.done as done')
            ->leftJoin('shippingstauses', 'myorders.txid','=','shippingstauses.txid')
           
            ->orderBy('shippingstauses.status','desc') ->latest()
            ->paginate(25);
           
            return view('admin.myorder.allorder',['products'=>$products]);
        }
    
    }

    public function shipping_status($id,$txid,$status){
        $value = Auth::guard('admin')->user()->id;
        if ($value==$id) {

            switch($status) { 
                case 1: { 
                    DB::table('shippingstauses')->where('txid','=',$txid)->update([
                        "status"=>'Shipping',
                        
                    ]);
                } 
                break; 
               
                case 2: { 
                    DB::table('shippingstauses')->where('txid','=',$txid)->update([
                        "status"=>'Delivery',
                        "done"=>'Done',
                        
                    ]);
                } 
                break; 
                   
                case 3: { 
                    DB::table('shippingstauses')->where('txid','=',$txid)->update([
                        "status"=>'Faild',
                        "done"=>'Faild',
                        
                    ]); 
                }
                break; 
             } 
           
        
            return back()->with('message', 'Update Successfully');
            
        }
    }



    public function ledger_view($id){
        $value=Auth::guard('admin')->user()->id;
        return $value;
        
    }
    public function withdraw_view($id){
        $value=Auth::guard('admin')->user()->id;
        if($id==$value){
            $userdatas =DB::table('walethistories')
            ->select('walethistories.*' ,'userprofiles.userid as userid','userprofiles.name as name','userprofiles.mobile as mobile','userprofiles.image as image'
           ,'bankdetails.bank as bank','walethistories.created_at as created_at')
           ->leftJoin('userprofiles', 'walethistories.userid','=','userprofiles.userid')
           ->leftJoin('bankdetails', 'walethistories.userid','=','bankdetails.userid')
           ->orderBy('walethistories.status','asc')
           ->paginate(25);

          // return $data;

            return view('admin.user.withdraw',['userdatas'=>$userdatas]);
        }
       
        
    }


     public function pending_withdraw_view($id)
    {
        $value=Auth::guard('admin')->user()->id;
        if($id==$value){
            $userdatas =DB::table('walethistories')->where('status','=',0)
            ->select('walethistories.*' ,'userprofiles.userid as userid','userprofiles.name as name','userprofiles.mobile as mobile','userprofiles.image as image'
           ,'bankdetails.bank as bank','walethistories.created_at as created_at')
           ->leftJoin('userprofiles', 'walethistories.userid','=','userprofiles.userid')
           ->leftJoin('bankdetails', 'walethistories.userid','=','bankdetails.userid')
           ->orderBy('walethistories.status','asc')
           ->paginate(25);

          // return $data;

            return view('admin.user.withdraw',['userdatas'=>$userdatas]);
        }
    }


    public function withdraw_request($key, $id,$requestid){
        $value=Auth::guard('admin')->user()->id;
        if($id==$value){
            if ($key=='success') {
                DB::table('walethistories')->where('id','=',$requestid)->update([
                    "status"=>1,
                ]);

                $getdata=DB::table('walethistories')->where('id','=',$requestid)->first();
                $mes =array(
                    'title'=>"Payment Successfully Completed", 
                    'body' =>'Your Payment Request TK '.$getdata->request_balance.' has Completed'
                  
                );
               
             app('App\Http\Controllers\NotificationController')->Coustomenotification($getdata->userid,$mes);
            return back()->with('message', 'Payment Successfully Paid');
       
            }else {
                DB::table('walethistories')->where('id','=',$requestid)->update([
                    "status"=>2,
                    
                ]);
                $getdata=DB::table('walethistories')->where('id','=',$requestid)->first();
                $mes =array(
                    'title'=>"Payment  Faild", 
                    'body' =>'Your Payment Request TK '.$getdata->request_balance.' has Faild  '
                  
                );
               
             app('App\Http\Controllers\NotificationController')->Coustomenotification($getdata->userid,$mes);
                return back()->with('message', 'Payment Faild');
            }

        }
    }



    public function product_return_view($id){
        $value=Auth::guard('admin')->user()->id;
        return $value;
        
    }
    public function add_product_view($id){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $data['countries'] =DB::table('categories')->orderBy('name','asc')->get(["name", "id"]);
            $subcategories =DB::table('subcategories')->orderBy('title','asc')->get();
        
            return view('admin.productpage.AddProductPage',$data);
        }
        
        
    }

    public function save_form_product_data(Request $request){
        $validateImageData = $request->validate([
            'main_image'=>'required',
            'main_image.*' => 'mimes:jpg,png,jpeg,gif,svg',
            'gallery' => 'required',
            'gallery.*' => 'mimes:jpg,png,jpeg,gif,svg'
            ]);
        $value=Auth::guard('admin')->user()->id;
        if($image =$request->file('gallery')&&$value==$request->id){
            
            $imagename = time().'_'.$request->file('main_image')->getClientOriginalName();
            $filePath = $request->file('main_image')->storeAs('product', $imagename, 'public');
            $image = url('/storage/product/'.$imagename);
            
            $file = new product;  
            $file->title =$request->title;
            $file->description=$request->description;
            $file->catid=$request->categoty;
            $file->subcatid=$request->subcategory;
            $file->qty=$request->qnt;
            $file->rate=$request->rate;
            $file->price=$request->price;
            $file->comisionrate=$request->comisionrate;
            $file->file_real_name=$imagename;
            $file->image =$image;
            $file->remark='remark';
            $file->status=$request->status;
            $file->save();
            
            $productid= $file->id;
            foreach($request->file('gallery') as $key => $imagefile)
            {
                //$path = $file->store('public/images');
                $name = time().'_'.$imagefile->getClientOriginalName();
                $filePath = $imagefile->storeAs('product', $name, 'public');
                $url = url('/storage/product/'.$name);

                $insert[$key]['productid'] = $productid;
                $insert[$key]['file_real_name'] = $name;
                $insert[$key]['url'] = $url;
                productimage::insert($insert);
            }
            //$name = time().'_'.$request->main_image->getClientOriginalName();
            
        }
        return redirect('/admin/all/product/'.$value)->with('message', 'Save Successfuly');
       
    }

    public function edit_product_view($id, $pid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $datas =DB::table('categories')->orderBy('name','asc')->get(["name", "id"]);
            $imagefiles =DB::table('productimages')->where('productid','=',$pid)->get();
            $product=DB::table('products')->where('products.id','=',$pid)
            ->select('products.id as id','products.title as title','categories.name as catname','categories.id as catid',
            'subcategories.id as subcatid','subcategories.title as subcatname','products.description as description','products.image as image','products.file_real_name as file_real_name',
            'products.rate as rate','products.price as price','products.comisionrate as comisionrate','products.qty as qnt'
            ,'products.status as status','products.created_at as created_at')
            ->leftJoin('categories', 'categories.id','=','products.catid')
            ->leftJoin('subcategories', 'subcategories.id','=','products.subcatid') 
            ->first();

            // $alldata= [
            //     // 'product' => $product,
            //     // 'countris' => $data,
            //     // 'imagefiles' => $imagefiles,
            //     'image'=>'http://localhost/hairfactbd/storage/product/1627637106_1627125580_2021-06-29_144205.png'
            // ];

          // return $alldata;

            return view('admin.productpage.EditProductPage',['product'=>$product,'imagefiles'=>$imagefiles,'datas'=>$datas]);
        }
    }

    public function save_edit_form_product_data(Request $request){
        $value=Auth::guard('admin')->user()->id;
        if($image =$request->file('main_image') && empty($request->file('gallery')) ){

            $imagename = time().'_'.$request->file('main_image')->getClientOriginalName();
            $filePath = $request->file('main_image')->storeAs('product', $imagename, 'public');
            $image = url('/storage/product/'.$imagename);

            Storage::delete('public/articles/'.$request->file_real_name);

            DB::table('products')->where('id','=',$request->pid)->update([
                "title"=>$request->title,
                "description"=>$request->description,
                "catid"=>$request->categoty,
                "subcatid" => $request->subcategory,
                "image"=>$image,
                "file_real_name"=>$imagename,
                "rate"=>$request->rate,
                "price"=>$request->price,
                "comisionrate"=>$request->comisionrate,
                "qty"=>$request->qnt,
                "status"=>$request->status,
            ]);
            return redirect('admin/all/product/'.$value)->with('message', 'Product Update Successfully');


         //   return $request;


        }elseif($image =$request->file('gallery') && $mainimage =$request->file('main_image')){
            $productid= $request->pid; 
            $getimage=DB::table('productimages')->where('productid','=',$request->pid)->get();

            $imagename = time().'_'.$request->file('main_image')->getClientOriginalName();
            $filePath = $request->file('main_image')->storeAs('product', $imagename, 'public');
            $mainpicture = url('/storage/product/'.$imagename);

            Storage::delete('public/articles/'.$request->file_real_name);

            foreach($getimage as $key){
                Storage::delete('public/articles/'.$key->file_real_name);
                $delate=DB::table('productimages')->where('id','=',$key->id)->delete();

            }
            foreach($request->file('gallery') as $key => $imagefile)
            {
                //$path = $file->store('public/images');
                $name = time().'_'.$imagefile->getClientOriginalName();
                $filePath = $imagefile->storeAs('product', $name, 'public');
                $url = url('/storage/product/'.$name);

                $insert[$key]['productid'] = $productid;
                $insert[$key]['file_real_name'] = $name;
                $insert[$key]['url'] = $url;
                productimage::insert($insert);
            }

            DB::table('products')->where('id','=',$request->pid)->update([
                "title"=>$request->title,
                "description"=>$request->description,
                "catid"=>$request->categoty,
                "subcatid" => $request->subcategory,
                 "image"=>$mainpicture,
                 "file_real_name"=>$imagename,
                "rate"=>$request->rate,
                "price"=>$request->price,
                "comisionrate"=>$request->comisionrate,
                "qty"=>$request->qnt,
                "status"=>$request->status,
            ]);
          return redirect('admin/all/product/'.$value)->with('message', 'Product Update Successfully');


        }elseif($image =$request->file('gallery')){
            $productid= $request->pid; 
            $getimage=DB::table('productimages')->where('productid','=',$request->pid)->get();


            foreach($getimage as $key){
                Storage::delete('public/articles/'.$key->file_real_name);
                $delate=DB::table('productimages')->where('id','=',$key->id)->delete();

            }
            foreach($request->file('gallery') as $key => $imagefile)
            {
                //$path = $file->store('public/images');
                $name = time().'_'.$imagefile->getClientOriginalName();
                $filePath = $imagefile->storeAs('product', $name, 'public');
                $url = url('/storage/product/'.$name);

                $insert[$key]['productid'] = $productid;
                $insert[$key]['file_real_name'] = $name;
                $insert[$key]['url'] = $url;
                productimage::insert($insert);
            }

            DB::table('products')->where('id','=',$request->pid)->update([
                "title"=>$request->title,
                "description"=>$request->description,
                "catid"=>$request->categoty,
                "subcatid" => $request->subcategory,
                // "image"=>$mainpicture,
                // "file_real_name"=>$imagename,
                "rate"=>$request->rate,
                "price"=>$request->price,
                "comisionrate"=>$request->comisionrate,
                "qty"=>$request->qnt,
                "status"=>$request->status,
            ]);
          return redirect('admin/all/product/'.$value)->with('message', 'Product Update Successfully');


        }
        else{
            DB::table('products')->where('id','=',$request->pid)->update([
                "title"=>$request->title,
                "description"=>$request->description,
                "catid"=>$request->categoty,
                "subcatid" => $request->subcategory,
                // "image"=>,
                // "file_real_name"=>,
                "rate"=>$request->rate,
                "price"=>$request->price,
                "comisionrate"=>$request->comisionrate,
                "qty"=>$request->qnt,
                "status"=>$request->status,
            ]);
            return redirect('admin/all/product/'.$value)->with('message', 'Product Update Successfully');

            
        }
       // return $request;
    }

    public function delete_product($id,$pid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
        $detate=DB::table('products')->where('id','=',$pid)->delete();
        return redirect('admin/all/product/'.$value)->with('message', 'Product Delete Successfully');

        }
    }



    public function new_order_view($id){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $products =DB::table('myorders')->where('status','Processing')->whereDate('created_at', Carbon::today())->latest()->paginate(25);
            $codproducts =DB::table('myorders')->where('status','COD')->whereDate('created_at', Carbon::today())->latest()->paginate(25);
            
            return view('admin.myorder.neworder',['products'=>$products,'codproducts'=>$codproducts]);
        }
  //return $value;
        
    }

    public function category_view($id){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $data['categories'] =DB::table('categories')->orderBy('name','asc')->latest()->paginate(25);;
           
        
            return view('admin.productpage.CategoryPage',$data);
        }
    }

    public function category_add_view(Request $request){
       
        $value=Auth::guard('admin')->user()->id;
        if ($value==$request->authid) {
            if (!empty($request->id)) {
                $validateImageData = $request->validate([
                    'main_image' => 'required',
                    'main_image.*' => 'mimes:jpg,png,jpeg,gif,svg',
                    
                    ]);

                    $imagename = time().'_'.$request->file('main_image')->getClientOriginalName();
                    $filePath = $request->file('main_image')->storeAs('product', $imagename, 'public');
                    $image = url('/storage/product/'.$imagename);

                Storage::delete('public/product/'.$request->file_real_name);

            DB::table('categories')->where('id','=',$request->id)->update([
                "name"=>$request->name,
                "url"=>$image,
                "file_real_name"=>$imagename,
            ]);
        
            return redirect('admin/category/'.$request->authid)->with('message', 'Category '.$request->name.' Update Successfully');
            }else{

                $validateImageData = $request->validate([
                    'name'=>['required','unique:categories',],
                    'main_image' => 'required',
                    'main_image.*' => 'mimes:jpg,png,jpeg,gif,svg',
                    
                    ]);
                    $imagename = time().'_'.$request->file('main_image')->getClientOriginalName();
                    $filePath = $request->file('main_image')->storeAs('product', $imagename, 'public');
                    $image = url('/storage/product/'.$imagename);
    
                   // Storage::delete('public/articles/'.$request->file_real_name);

                $category = new category;
                $category->name =$request->name;
                
                $category->url=$image;
                $category->file_real_name=$imagename;
                $category->save();
            
                return redirect('admin/category/'.$request->authid)->with('message', 'Category '.$request->name.' Add Successfully');
                

            }
           
           }

    //     $value=Auth::guard('admin')->user()->id ;
    //     $id= $request->authid;
    //     $validatedData = $request->validate([
    //       'name' => ['required', 'max:255'],
    //       'file' => 'required',
    //   ]);
    //    if($id==$value){
    //       if (!empty($request->vid)) {
    //       if($request->file()){
          

    //       $name = time().'_'.$request->file->getClientOriginalName();  
    //       $filePath = $request->file('file')->storeAs('category', $name, 'public');
    //       $url = url('/storage/category/'.$name);
  
    //       Storage::delete('public/category/'.$request->file_real_name);
            
    //       category::where('id',$request->vid)->update([
    //           'name'=>$request->name,
    //           'url' => $url,
    //           'file_real_name'=>$name
    //         ]);
    //         return redirect('admin/category/'.$request->authid)->with('message', 'Category '.$request->name.' Update Successfully');
            
          
    //       }
            
    //     }else{
         
    //     if ($request->file()) {
          
    //       $name = time().'_'.$request->file->getClientOriginalName();
    //       $filePath = $request->file('file')->storeAs('category', $name, 'public');
    //       $url = url('/storage/category/'.$name);
  
    //       //Storage::delete('public/video/'.$request->file_real_name);
    //       $file = new category;  
    //       $file->name =$request->name;
    //       $file->file_real_name=$name;
    //       $file->url =$url;
    //       $file->save();
          
         
    //       return redirect('admin/category/'.$request->authid)->with('message', 'Category '.$request->name.' Add Successfully');
                
        
    //     }
  
      
    //   }
    // }else{
    //   return redirect('/admin');
    // }
    
    
        }

    public function category_add_byid_view($id,$catid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {

            $categories =DB::table('categories')->orderBy('name','asc')->latest()->paginate(25);
            $edit=DB::table('categories')->orderBy('name','asc')->where('id','=',$catid)->first();
        
            return view('admin.productpage.CategoryPage',['categories'=>$categories, 'edit'=>$edit]);
        }
    }

    public function category_delate_byid_view($id,$catid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {

           $detate=DB::table('categories')->where('id','=',$catid)->delete();
           return redirect('admin/category/'.$value)->with('message', 'Category Delete Successfully');
                
        }
    }

    public function subcategory_view($id){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {
            $subcategories =DB::table('subcategories')
            ->select('subcategories.*','categories.name as catname')
            ->leftJoin('categories', 'categories.id','=','subcategories.catid')
            ->latest()->paginate(25);
            
            return view('admin.productpage.SubCategoryPage',['subcategories'=>$subcategories]);
        }
    }

    public function add_subcategory_form($id){
        $data['categories'] =DB::table('categories')->orderBy('name','asc')->latest()->paginate(25);
           
        return view('admin.productpage.EditSubcategory',$data);
    }

    public function subcategory_add_view(Request $request){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$request->authid) {
            
                if (!empty($request->id)) {
                DB::table('subcategories')->where('id','=',$request->id)->update([
                    "title"=>$request->title,
                    "description"=>$request->title,
                    "catid"=>$request->categoty,

                ]);
            
                return redirect('admin/subcategory/'.$request->authid)->with('message', 'Category '.$request->name.' Update Successfully');
                }else{
    
                    $validateImageData = $request->validate([
                        'title'=>['required','unique:subcategories',],
                        ]);
    
                    $subcategory = new subcategory;
                    $subcategory->title =$request->title;
                    $subcategory->description=$request->title;
                    $subcategory->catid= $request->categoty;
                    $subcategory->save();
                
                    return redirect('admin/subcategory/'.$request->authid)->with('message', 'Category '.$request->name.' Add Successfully');
                    
    
                }
           
           }
    }


    public function subcategory_add_byid_view($id,$catid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {

            $categories =DB::table('categories')->orderBy('name','asc')->get();
            $catname=DB::table('subcategories')->where('id','=',$catid)->first('catid');
            $subcategory =DB::table('subcategories')->where('id','=',$catid)
           ->select('subcategories.*')
           
            ->first();
        
            return view('admin.productpage.EditSubcategory',['categories'=>$categories, 'subcategory'=>$subcategory]);
        }
    }

    public function subcategory_delate_byid_view($id,$catid){
        $value=Auth::guard('admin')->user()->id;
        if ($value==$id) {

           $detate=DB::table('subcategories')->where('id','=',$catid)->delete();
           return redirect('admin/subcategory/'.$value)->with('message', 'Subcategory Delete Successfully');
                
        }
    }



}
