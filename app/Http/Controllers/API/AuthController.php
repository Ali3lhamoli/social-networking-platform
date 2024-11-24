<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @group Authentication
     *
     * User login
     *
     * This endpoint allows a user to log in by providing their email and password.
     *
     * @bodyParam email string required The user's email address. Example: ali@example.com
     * @bodyParam password string required The user's password. Example: password123
     * @response 200 scenario="success" {
     *   "token": "some-jwt-token",
     *   "user": {
     *     "id": 1,
     *     "name": "Ali",
     *     "email": "ali@example.com"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "error": {
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
     * @response 401 scenario="invalid credentials" {
     *   "message": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = User::where('email', '=', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    /**
     * @group Authentication
     *
     * User registration
     *
     * This endpoint allows a user to register by providing their name, email, and password.
     *
     * @bodyParam name string required The user's full name. Example: Ali Alhamoli
     * @bodyParam email string required The user's email address. Example: ali@example.com
     * @bodyParam password string required The user's password. Example: password123
     * @response 200 scenario="success" {
     *   "token": "some-jwt-token",
     *   "user": {
     *     "id": 1,
     *     "name": "Ali",
     *     "email": "ali@example.com"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "error": {
     *     "name": ["The name field is required."],
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    /**
     * @group Authentication
     *
     * User logout
     *
     * This endpoint allows a user to log out by deleting their current authentication token.
     *
     * @response 200 scenario="success" {
     *   "message": "Logged out"
     * }
     * @response 401 scenario="failed to logout" {
     *   "message": "Failed to logout"
     * }
     */
    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return response()->json(['message' => 'Logged out'], 200);
        }
        return response()->json(['message' => 'Failed to logout'], 401);
    }
}
