<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AuthenticateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{   
    /**
     * Authenticate username and password.
     *
     * @param AuthenticateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(AuthenticateRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user, 'message' => 'Success'], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Invalid credentials.'], config('constants.HTTP_CODE_UNAUTHORIZED'));
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens Revoked'], config('constants.HTTP_CODE_OK'));
    }
}
