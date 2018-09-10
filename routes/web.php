<?php

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
    return view('auth/login');
});


Route::get('/admin', function () {
    return view('auth/login');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/dashboard', 'AdminController@index')->name('لوحة التحكم');
Route::get('admin/categories','AdminController@categories');
Route::post('admin/addCategory','AdminController@addCategory');
Route::get('admin/category/{id}/delete','AdminController@deleteCategory');
Route::get('admin/category/{item}/edit','AdminController@editCategory');
Route::post('admin/updateCategory/{item}','AdminController@updateCategory');
Route::post('admin/manageCategories','AdminController@manageCategories');

Route::get('admin/about','AdminController@about');
Route::post('admin/updateAbout/{item}','AdminController@updateAbout');

Route::get('admin/site_settings','AdminController@site_settings');
Route::post('admin/addSetting','AdminController@addSetting');
Route::get('admin/setting/{item}/edit','AdminController@editSetting');
Route::post('admin/updateSetting/{item}','AdminController@updateSetting');
Route::post('admin/manageSettings','AdminController@manageSettings');
Route::get('admin/setting/{item}/delete','AdminController@deleteSetting');

Route::get('admin/social_links','AdminController@social_links');
Route::post('admin/addSocialLink','AdminController@addSocialLink');
Route::get('admin/social/{item}/edit','AdminController@editSocial');
Route::post('admin/updateSocial/{item}','AdminController@updateSocial');
Route::post('admin/manageSocial','AdminController@manageSocial');
Route::get('admin/social/{item}/delete','AdminController@deleteSocial');

Route::get('admin/get_code','AdminController@get_code');
Route::post('admin/create_codes','AdminController@create_codes');

Route::get('admin/profile','AdminController@profile');
Route::post('admin/updateProfile','AdminController@updateProfile');

Route::get('admin/users/add','AdminController@addUser');
Route::post('admin/insertUser','AdminController@insertUser');
Route::get('admin/users/companies','AdminController@companies');
Route::get('admin/user/{item}/edit','AdminController@editUser');
Route::post('admin/updateUser/{item}','AdminController@updateUser');
Route::get('admin/users/all','AdminController@users_all');
Route::get('admin/users/supervisors','AdminController@users_supervisors');
Route::get('admin/user/{item}/delete','AdminController@deleteUser');
Route::post('admin/users/manageUsers','AdminController@manageUsers');

Route::get('admin/regions','AdminController@regions');
Route::post('admin/addRegion','AdminController@addRegion');
Route::post('admin/manageRegions','AdminController@manageRegions');
Route::get('admin/regions/{item}/edit','AdminController@editRegion');
Route::post('admin/updateRegion/{item}','AdminController@updateRegion');


Route::get('admin/request_add','AdminController@request_add');
Route::post('admin/insertRequest','AdminController@insertRequest');
Route::post('admin/getSubCategories','AdminController@getSubCategories');
Route::get('admin/requests_all','AdminController@requests_all');
Route::get('admin/request/{item}/edit','AdminController@editRequest');
Route::post('admin/updateRequest/{item}','AdminController@updateRequest');
Route::get('admin/request/{item}/delete','AdminController@deleteRequest');
Route::post('admin/manageRequests','AdminController@manageRequests');
Route::post('admin/makeSpecial','AdminController@makeSpecial');

Route::get('admin/points','AdminController@points');
Route::post('admin/managePoints','AdminController@managePoints');
Route::get('admin/requestPoint/{item}/delete','AdminController@deleteRequestPoint');



Route::get('admin/generateQrcode','AdminController@generateQrcode');


Route::get('company/{item}','MyController@company');
Route::get('offer/{item}','MyController@offer');

Auth::routes();



//**************** api RestFull **********************
//http://homestead.app/api/Message?with=user&limit=2&order_by=id:DESC&id=1
//Route::group(['middleware' => ['cors']], function (){
    Route::get('api','ApiController@index');
    Route::post('api/login','ApiController@login');
    Route::post('api/mail','ApiController@mail');
    Route::get('api/insert_token','ApiController@insert_token');

    Route::get('api/join/{table}','ApiController@join');
    Route::get('api/{table}','ApiController@select');

    Route::post('api/insert/{table}','ApiController@insert');
    Route::post('api/update/{table}','ApiController@update');
    Route::post('api/delete/{table}','ApiController@delete');

    Route::get('api/generateQR/{userID}','ApiController@generateQR');
    //------------ New distance Quries --------
    Route::get('api/allRequests/{lat}/{lng}','ApiController@allRequests');
    Route::get('api/requests_by_category_role/{lat}/{lng}/{role}/{category}','ApiController@requests_by_category_role');
    Route::get('api/requests_by_category/{lat}/{lng}/{category}','ApiController@requests_by_category');
    Route::get('api/requests_by_role/{lat}/{lng}/{role}','ApiController@requests_by_role');    
    Route::get('api/single_request/{lat}/{lng}/{requestID}','ApiController@single_request');
    Route::get('api/nearest_airport/{lat}/{lng}','ApiController@nearest_airport');
    Route::get('api/nearest_offers/{lat}/{lng}','ApiController@nearest_offers');            
    
    Route::get('api/company_location/{lat}/{lng}','ApiController@company_location');            
    //------------ End New distance Quries --------
    Route::get('api/viewPDF/{id}','ApiController@viewPDF'); 
    Route::get('api/sendNotification/{id}/{page}/{title}/{msg}','ApiController@sendNotification');
// });
 
 //Route::post('api/insert/{table}','ApiController@insert',['middleware' => 'cors']);