<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validator = $request->validated();
        
        $post = $request->all();

        $post['password'] = bcrypt($post['password']);

        $user = User::create($post);

        return createResponse(200, "", null, $user);
    }

    public function login(LoginRequest $request)
    {
        $validator = $request->validated();

        $credentials = request(['phone', 'password']);
        
        if (!auth()->attempt($credentials)) {
            return createResponse(422, "Invalid validation", ["credintials" => ["phone is not exist or phone & password does not match"] ], (object)[]);
        }

        $user = User::where('phone', $request->phone)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
        ]);
    }
}
