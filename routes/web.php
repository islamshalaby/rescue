<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    // return what you want
});
Route::get('/', function () {
    return view('welcome');
});
Route::group([
    'prefix' => 'webview'
], function () {
    Route::get('about/{lang}', 'WebviewController@about');
    Route::get('terms/{lang}', 'WebviewController@terms');
    
});
Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', 'Admin\\HomeController@show')->name('dashboard');
    Route::resource('roles', 'Admin\\RoleController');
    Route::resource('users', 'Admin\\UserController');
    Route::resource('packages', 'Admin\\PackageController');
    Route::resource('sliders', 'Admin\\SliderController');
    Route::group([
        'prefix' => 'settings'
    ] , function($router){
        Route::get('terms', 'Admin\\SettingController@terms_edit')->name('settings.tedit');
        Route::put('terms', 'Admin\\SettingController@terms_update')->name('settings.tupdate');
        Route::get('about', 'Admin\\SettingController@about_edit')->name('settings.aedit');
        Route::put('about', 'Admin\\SettingController@about_update')->name('settings.aupdate');
        Route::get('settings', 'Admin\\SettingController@setting_edit')->name('settings.edit');
        Route::put('settings', 'Admin\\SettingController@setting_update')->name('settings.update');
        
    });
});

require __DIR__.'/auth.php';
