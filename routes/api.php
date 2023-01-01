<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('login/info', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('forgot-password', 'AuthController@forgot_password');

    Route::post('save/profile/image','AuthController@save_profile_image');
    Route::get('get/profile/data/{id}','AuthController@get_profile_data');


    //article
    Route::get('get/articles','ArticleController@get_articles');
    Route::get('get/cyclinical/nutration','CycllcalnutritionController@get_post');
    Route::get('get/inclenic/name','InclinicController@get_inclinic_name');
    Route::get('get/inclenic/file/{id}','InclinicController@get_inclinic_file');
    Route::get('get/video','VideoController@get_video_files');
    Route::get('get/image','ImageController@get_image_files');

    Route::get('get/therapist/list','HairtherapistController@get_therapist_list');

    //Product section
    Route::get('get/product','ProductController@get_product');
    Route::get('get/category','CategoryController@get_category');
    Route::get('get/subcategory','SubcategoryController@get_subcategory');
    
    //Order Section
    Route::post('get/save/cart/{id}','MycartController@cart_save_data');

    Route::get('get/order/history/{id}','MyorderController@order_history');
    Route::post('order/request','MyorderController@order_request');
    
    //Wallets
    Route::get('get/user/wallet/{id}','WallentContoller@get_wallet');
    Route::post('request/withdrow','WallentContoller@balancewithdrow');
    Route::post('save/bank/details','WallentContoller@save_bank_detals');
    Route::get('get/bank/details/{id}','WallentContoller@get_bank_detals');

    //Image
    Route::get('/imageslider','ImageSliderContoller@imageslider');

    Route::post('save/deviceid','MyorderController@save_deviceid');

    //send notification
    Route::post('send/notification', 'NotificationController@send');

    Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
    Route::post('/test', [SslCommerzPaymentController::class, 'text']);
    // Get Notification history
    Route::get('notification/history','AuthController@notification_history');
}
);