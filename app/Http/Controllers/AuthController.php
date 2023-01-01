<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DB;
use App\Models\userprofile;
use App\Models\passwordreset;
use App\Models\userwallet;
use App\Models\bankdetail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot_password']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('mobile', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            $user_data = DB::table('users')->where('mobile', '=', $credentials['mobile'])->first();

            $status = $user_data->status;
            $id = $user_data->id;
            $name = $user_data->name;
            $mobile = $credentials['mobile'];

            return $this->respondWithToken($token, $id, $name, $status, $mobile);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    //profile image
    public function save_profile_image(Request $request)
    {
        $value = Auth::guard('api')->user()->id;
        if ($image = $request->file('image') && $value == $request->id) {
            $imagename = time() . '_' . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('profile', $imagename, 'public');
            $image = url('/storage/profile/' . $imagename);

            DB::table('userprofiles')->where('userid', '=', $request->id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "image" => $image,
                "file_real_name" => $imagename,
                "address" => $request->address,
                'dateofbirth' => $request->dateofbirth
            ]);

            DB::table('users')->where('id', '=', $request->id)->update([
                "name" => $request->name,

            ]);

            return response()->json('450');
        } else {

            DB::table('userprofiles')->where('userid', '=', $request->id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "address" => $request->address,
                'dateofbirth' => $request->dateofbirth
            ]);

            DB::table('users')->where('id', '=', $request->id)->update([
                "name" => $request->name,

            ]);

            return response()->json('450');
        }
    }

    public function get_profile_data($id)
    {
        $value = Auth::guard('api')->user()->id;
        if ($value == $id) {
            $user_data = DB::table('userprofiles')->where('userid', '=', $id)->first();
            return response()->json($user_data);
        } else {
            $user_data = DB::table('userprofiles')->where('userid', '=', $value)->first();
            return response()->json($user_data);
        }
    }

    public function register(Request $request)
    {


        $validation = DB::table('users')->where([['mobile', '=', $request->mobile]])->first();

        if (!empty($validation)) {

            return response()->json(140);
        } else {

            $data = array();
            $data['name'] = $request->name;
            $data['mobile'] = $request->mobile;
            $data['password'] = Hash::make($request->password);
            $data['status'] = 0;
            DB::table('users')->insert($data);

            $user_data = DB::table('users')->where('mobile', '=', $request->mobile)->first();
            $id = $user_data->id;

            $Patient =  userprofile::create([
                'name' => $request->name,
                'userid' => $id,
                'image' => 'https://hairfactbd.porasunabd.com/storage/profile/demoprofile.png',
                'file_real_name' => 'demo',
                'mobile' => $request->mobile,
                'email' => 'test@test.com',
                'address' => 'address',
                'dateofbirth' => '1993-01-31',
                'bmdc' => $request->bmdc,

            ]);
            userwallet::create([
                'name' => $request->name,
                'userid' => $id,
                'mobile' => $request->mobile,
                'price' => '0'

            ]);

            bankdetail::create([
                'userid' => $id,
                'bank' => 'Please enter bank details'
            ]);


            return response()->json('Test');

            //return $this->login($request);
        }
    }

    public function forgot_password(Request $request)
    {
        $uniqid = Str::random(4);

        $user_data = DB::table('users')->where('mobile', '=', $request->mobile)->first();
        if (!empty($user_data)) {
            $Patient =  passwordreset::create([
                'name' => $user_data->name,
                'userid' => $user_data->id,
                'mobile' => $request->mobile,
                'token' => 'pas' . $uniqid,
            ]);

            return response()->json(200);
        } else {
            return response()->json(404);
        }
    }

    public function notification_history()
    {
        $value = Auth::guard('api')->user()->id;
        $data = DB::table('notificationhistories')->where('userid', $value)->orderBy('id', 'desc')->take(20)->get();
        return response()->json($data);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $id, $name, $status, $mobile)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'id' => $id,
            'name' => $name,
            'status' => $status,
            'mobile' => $mobile,
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
