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

Route::group(['middleware' => ['auth:sanctum']], function() {

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
    });
});
