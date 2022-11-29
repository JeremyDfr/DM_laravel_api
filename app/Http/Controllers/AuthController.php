<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'firstname' => ['required'],
                'lastname' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', Password::min(12)->letters()->mixedCase()->symbols()->numbers()],
            ]);

            $newUser = User::create([
                'firstname' => $credentials['firstname'],
                'lastname' => $credentials['lastname'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);

            if ($newUser && Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])){
                $user = Auth::user();
                $token = $user->createToken('token');
            }

            return response()->json([
                'status' => 'OK',
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)){
                $user = Auth::user();
                $token = $user->createToken('token');
            }

            return response()->json([
                'status' => 'OK',
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function disconnect(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();

            return response()->json([
                'status' => 'OK'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
