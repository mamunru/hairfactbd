<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin');
});

//Route::get('/home', [HomeController::class,'index'])->name('home');

//Admin
Route::prefix('admin')->group(function() {
    Route::get('/login',[App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('logout/final', [App\Http\Controllers\Auth\AdminLoginController::class,'logout'])->name('admin.logout');
   // Route::get('/register/admin', [App\Http\Controllers\Auth\RegisterController::class,'showAdminRegisterForm']);
    //Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class,'createAdmin']);
    Route::get('/',[App\Http\Controllers\AdminController::class,'index'])->name('admin.dashboard');

    Route::get('/profile', [App\Http\Controllers\AdminPanelController::class,'profileControl']);
    Route::get('user/approve/{id}/{userid}',[App\Http\Controllers\AdminPanelController::class,'user_approve']);
    Route::get('user/delete/{id}/{userid}',[App\Http\Controllers\AdminPanelController::class,'user_delete']);
    Route::get('approve/user/{id}',[AdminPanelController::class,'approve_user']);

    Route::get('/registration', function () {
        return view('admin.adminreg');
    });
     //Registration 
     Route::get('/view', function () {
        return view('admin.myadmin');
    });

    Route::post('/new/admin/{id}',[App\Http\Controllers\AdminPanelController::class,'admin_registration']);

    //Delate Admin
    Route::get('/delete/{id}/{aid}',[App\Http\Controllers\AdminPanelController::class,'admin_delete'] );


    //Literatures
    Route::get('/imageslider/{id}',[App\Http\Controllers\AdminPanelController::class,'image_slider_view'] );
    Route::get('/article/{id}',[App\Http\Controllers\AdminPanelController::class,'article_view'] );
    Route::get('/cycllcalnutrition/{id}',[App\Http\Controllers\AdminPanelController::class,'cycllcalnutrition_view'] );
    Route::get('/inclinic/{id}',[App\Http\Controllers\AdminPanelController::class,'inclinic_view'] );
    Route::get('/video/{id}',[App\Http\Controllers\AdminPanelController::class,'video_view'] );
    Route::get('/image/{id}',[App\Http\Controllers\AdminPanelController::class,'image_view'] );
    Route::get('/hairtherapi/{id}',[App\Http\Controllers\AdminPanelController::class,'hairtherapi_view'] );

    //add Section
    Route::get('/add/article/{id}',[AdminPanelController::class,'article_add'] );
    Route::post('/save/article',[AdminPanelController::class,'article_save'] )->name('upload-file');
    Route::get('/article/delete/{id}/{artid}',[AdminPanelController::class,'article_delete'] );
    
    Route::get('/article/edit/{id}/{artid}',[AdminPanelController::class,'article_edit'] );
    Route::post('/edit/article',[AdminPanelController::class,'article_edit_save'] )->name('edit-article-file');
    //cycllcalnutrition
    Route::get('/add/cycllcalnutrition/{id}',[AdminPanelController::class,'cycllcalnutrition_add'] );
   
    Route::post('/edit/cycllcalnutrition',[AdminPanelController::class,'cycllcalnutrition_edit_save'] )->name('edit-cycllcalnutrition-file');
    //add/inclinic/
    Route::get('/add/inclinic/{id}',[AdminPanelController::class,'inclinic_add'] );
    Route::post('/save/inclinic',[AdminPanelController::class,'inclinic_save'] )->name('inclinic_upload-file');
    Route::post('/edit/inclinic',[AdminPanelController::class,'inclinic_edit'] )->name('inclinic_edit_file');
    Route::get('inclinic/edit/{id}/{lid}',[AdminPanelController::class,'inclinic_edit_page'] );

    //inclinic file 

    Route::get('inclinic/files/byid/{id}/{lid}',[AdminPanelController::class,'inclinic_file_by_id'] );
    Route::get('add/inclinic/{id}/{incid}',[AdminPanelController::class,'inclinic_add_file_by_id']);
    Route::get('/inclinic/edit/inclinicfile/{id}/{artid}',[AdminPanelController::class,'inclinicfile_edit'] );
    Route::get('/inclinic/delete/inclinicfile/{id}/{artid}',[AdminPanelController::class,'inclinicfile_delete'] );
    
    //Videos
    Route::get('/add/video/{id}',[AdminPanelController::class,'video_add_form']);
    Route::get('/video/edit/{id}/{vid}',[AdminPanelController::class,'video_edit_form']);
    Route::post('/save/video/file',[AdminPanelController::class,'video_file_save'] )->name('upload_video-file');
    Route::get('/video/delete/{id}/{vid}',[AdminPanelController::class,'video_delete_form']);
    //Image
    Route::get('/add/image/{id}',[AdminPanelController::class,'image_add_form']);
    Route::get('/image/edit/{id}/{imgid}',[AdminPanelController::class,'image_edit_form']);
    Route::post('/save/image/file',[AdminPanelController::class,'image_file_save'] )->name('upload_image-file');
    Route::get('/image/delete/{id}/{imgid}',[AdminPanelController::class,'image_delete_form']);
   
    //Hair Teatment
    Route::get('/add/therapist/{id}',[AdminPanelController::class,'add_therapist_form']);
    Route::post('save/therapist',[AdminPanelController::class,'therapist_add_view'])->name('therapist_data_save');
    Route::get('/therapist/edit/byid/{id}/{tid}',[AdminPanelController::class,'therapist_add_byid_view']);
    Route::get('/therapist/delete/{id}/{tid}',[AdminPanelController::class,'therapist_delate_byid_view']);
    

    //Product And Account
    Route::get('/all/product/{id}',[AdminProductController::class,'allproduct_view'] );
    Route::get('/order/{id}',[AdminProductController::class,'order_view'] );
    Route::get('/ledger/{id}',[AdminProductController::class,'ledger_view'] );

    //Bonus Section
    Route::get('/give/bonus/{id}',[AdminPanelController::class,'bonus_page']);
    Route::get('/add/bonus/{id}',[AdminPanelController::class,'edit_bonus_page']);
    Route::post('/send/bonus/byuser',[AdminPanelController::class,'send_bonus'])->name('send_bonus');
    
    //Money Withdraw
    Route::get('/withdraw/{id}',[AdminProductController::class,'withdraw_view'] );
    Route::get('/withdraw/pending/{id}',[AdminProductController::class,'pending_withdraw_view'] );
    Route::get('/withdraw/{key}/{id}/{requestid}',[AdminProductController::class,'withdraw_request']);


    //product return
    Route::get('/product/return/request/{id}',[AdminProductController::class,'product_return_view'] );
    
    //Add Product 
    
    Route::get('/add/product/{id}',[AdminProductController::class,'add_product_view']);
    Route::get('/edit/product/{id}/{pid}',[AdminProductController::class,'edit_product_view']);
    Route::post('/save/product',[AdminProductController::class,'save_form_product_data'] )->name('form_add_product');
    Route::post('/edit/product',[AdminProductController::class,'save_edit_form_product_data'])->name('form_edit_product');
    Route::get('/product/delete/{id}/{pid}',[AdminProductController::class,'delete_product']);
   
    //category
    Route::get('/category/{id}',[AdminProductController::class,'category_view']);
    Route::post('save/category',[AdminProductController::class,'category_add_view'])->name('category_upload-file');
    Route::get('/category/edit/byid/{id}/{catid}',[AdminProductController::class,'category_add_byid_view']);
    Route::get('/category/delete/{id}/{catid}',[AdminProductController::class,'category_delate_byid_view']);
    //subcategory
    Route::get('/subcategory/{id}',[AdminProductController::class,'subcategory_view']);
    Route::get('/add/subcategory/{id}',[AdminProductController::class,'add_subcategory_form']);
    Route::post('save/subcategory',[AdminProductController::class,'subcategory_add_view'])->name('subcategory_data_save');
    Route::get('/subcategory/edit/byid/{id}/{subcatid}',[AdminProductController::class,'subcategory_add_byid_view']);
    Route::get('/subcategory/delete/{id}/{subcatid}',[AdminProductController::class,'subcategory_delate_byid_view']);
    //Order
    Route::get('/new/order/{id}',[AdminProductController::class,'new_order_view'] );
    Route::get('/all/order/{id}',[AdminProductController::class,'all_order_view'] );
    Route::get('shipping/{id}/{pid}/{status}',[AdminProductController::class,'shipping_status']);

    //image
    //Image
    Route::get('/add/imageslider/{id}',[AdminPanelController::class,'image_slider_add_form']);
    Route::get('/imageslider/edit/{id}/{imgid}',[AdminPanelController::class,'image_slider_edit_form']);
    Route::post('/save/imageslider/file',[AdminPanelController::class,'image_slider_file_save'] )->name('upload_image_slider_file');
    Route::get('/imageslider/delete/{id}/{imgid}',[AdminPanelController::class,'image_slider_delete']);
    //Notification Section
    Route::get('/all/notification/{id}',[NotificationController::class,'notification_page']);
    Route::get('/form/notification/{id}',[NotificationController::class,'add_notification_page']);
    Route::post('/send/notification',[NotificationController::class,'send_notification'])->name('send_notification');
    

});
Auth::routes();

Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);


Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);


Route::post('/test', [SslCommerzPaymentController::class, 'text']);