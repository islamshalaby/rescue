<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return createResponse(422, "", $validator->errors(), null);
        }
        $post = $request->all();

        $post['password'] = bcrypt($post['password']);

        $user = User::create($post);

        return createResponse(200, $user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'numeric|required',
            'password' => 'required'
        ]);

        $credentials = request(['phone', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
        ]);
    }
}
