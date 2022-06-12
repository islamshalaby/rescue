<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', 'Admin\\HomeController@show')->name('dashboard');
    Route::resource('roles', 'Admin\\RoleController');
    Route::resource('users', 'Admin\\UserController');
    Route::resource('packages', 'Admin\\PackageController');
    Route::resource('sliders', 'Admin\\SliderController');
});

require __DIR__.'/auth.php';
