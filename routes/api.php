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
Route::post('/register', 'Api\\AuthController@register');
Route::post('/login', 'Api\\AuthController@login');
Route::post('/tokens/create', function (Request $request) {
    dd($request->user());
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
