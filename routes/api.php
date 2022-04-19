<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// register
Route::post('/register/{lang}/{v}', 'Api\\AuthController@register');
// login
Route::post('/login/{lang}/{v}', 'Api\\AuthController@login');

Route::group(['middleware' => []], function() {
    // packages
    Route::group([
        'prefix' => 'packages'
    ], function () {
        Route::get('{lang}/{v}', 'Api\\PackageController@index');
    });
    
    // users
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::post('packages-buy/{lang}/{v}', 'Api\\UserController@buy_package');
        Route::get('transactions/{lang}/{v}', 'Api\\UserController@transactions');
        
        Route::post('contacts/{lang}/{v}', 'Api\\UserController@add_contacts');
        Route::post('emergency-message/{lang}/{v}', 'Api\\UserController@add_emergency_messages');
        Route::get('emergency-message/{lang}/{v}', 'Api\\UserController@get_emergency_messages');
        
        Route::get('my_account/{lang}/{v}', 'Api\\UserController@user_data');
        Route::post('technical-support/{lang}/{v}', 'Api\\UserController@technical_support');
        Route::post('checkphoneexistance/{lang}/{v}' , 'Api\\UserController@checkphoneexistance');
        Route::put('resetforgettenpassword/{lang}/{v}' , 'Api\\UserController@resetforgettenpassword');
        Route::put('resetpassword/{lang}/{v}' , 'Api\\UserController@resetpassword');
        Route::put('update-profile/{lang}/{v}' , 'Api\\UserController@updateProfile');
        Route::post('update-profile-image/{lang}/{v}' , 'Api\\UserController@update_image');
        
    });
    
});
Route::get('/excute_pay' , 'Api\\UserController@excute_pay')->name('excute.pay');
Route::get('/pay/success' , 'Api\\UserController@pay_sucess')->name('pay.success');
Route::get('/pay/error' , 'Api\\UserController@pay_error')->name('pay.error');
