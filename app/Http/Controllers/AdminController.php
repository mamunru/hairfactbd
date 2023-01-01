<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Artisan;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Artisan::call('storage:link');
        $alluserdata = DB::table('users')->where('status','!=',1)
           ->select('userprofiles.userid as userid','userprofiles.name as name','userprofiles.mobile as mobile','userprofiles.email as email','userprofiles.image as image'
           ,'users.status as status','userprofiles.bmdc as bmdc','userprofiles.created_at as created_at')
           ->leftJoin('userprofiles', 'users.id','=','userprofiles.userid')
           ->latest()
           ->paginate(25);
           
        return view('admin.AdminFile',['alluserdata'=>$alluserdata]);
    }
}