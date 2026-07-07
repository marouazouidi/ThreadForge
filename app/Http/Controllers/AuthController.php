<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            $request->validated()
        );

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['user' => new UserResource($user), 'token' => $token], 201);
    }


    public function login(LoginRequest $request)
    {
        if(! Auth::attempt($request->only('email', 'password'))){
            return response()->json([ 'message' => 'Invalid credentials']);
        }

        $user = User::where(
            'email',
            $request->email
        )->first();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }


    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


}
