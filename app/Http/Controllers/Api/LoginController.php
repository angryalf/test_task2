<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Login\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $token = $request->user()->createToken('authToken')->plainTextToken;

            return response()->json([
                'data' => [
                    'token' => $token,
                ],
            ], 200);
        }

        return response()->json([__('The provided credentials do not match our records.')], 403);
    }
}
