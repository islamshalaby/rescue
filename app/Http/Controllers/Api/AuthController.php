<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // register
    public function register(RegisterRequest $request)
    {
        try{
            $post = $request->all();
            $today = Carbon::now();
            $post['password'] = bcrypt($post['password']);
            $post['package_expire'] = $today->addDays(14);
            $user = User::create($post);
            $user->assignRole(['user']);
            $authToken = $user->createToken('auth-token')->plainTextToken;
            $user['access_token'] = $authToken;
    
            return createResponse(200, "", null, $user);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    // login
    public function login(LoginRequest $request)
    {
        try{
            $credentials = request(['phone', 'password']);
            
            if (!auth()->attempt($credentials)) {
                return createResponse(422, "Invalid validation", ["credintials" => ["phone is not exist or phone & password does not match"] ], (object)[]);
            }
    
            $user = User::where('phone', $request->phone)->select('id', 'name', 'phone', 'package_id', 'package_expire')->with('_package')->first();
            $authToken = $user->createToken('auth-token')->plainTextToken;
            $user->image = "";
            if ($user->fetchFirstMedia()) {
                $user->image = $user->fetchFirstMedia()->file_url;
            }
            $user->access_token = $authToken;
    
            return createResponse(200, "fetched successfully", null, $user);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
        
    }
}
