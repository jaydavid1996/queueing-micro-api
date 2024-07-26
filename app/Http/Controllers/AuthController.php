<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => 'Invalid information', 'errors' => $validated->errors()]);
        }

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|max:25',
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => 'Invalid information', 'errors' => $validated->errors()]);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $request->input('role_id') ?? 3;
        $user->save();

        return response()->json(['message' => 'User registered successfully!']);
    }

    public function profile()
    {
        if (Auth::user()) {
            $user = Auth::user()->with(['roles' =>  function($query){
                $query->select('id','name');
            }])->first();
            return response()->json($user);
        } else {
            return response()->json('Token NOT provided!', 401);
        }
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out', 'status' => 'success']);
    }

    protected function respondWithToken($token)
    {
        $user = Auth::user();

        $responses_user = (object)[
            'email' => $user->email,
            'last_name' => $user->last_name,
            'first_name' => $user->first_name,
        ]; 

        return response()->json([
            'response' => [
                'user' => $responses_user,
                'roles' => $user->getRoleNames('name'),
                'tokens' => [
                    'access' => [
                        'token' => $token,
                        'expires' => Auth::factory()->getTTL() * 60,
                    ],
                    'refresh' => [
                        'token_with_role' => JWTAuth::customClaims(['role' => $user->getRoleNames()])->fromUser($user),
                        'expires' => config('jwt.refresh_ttl') * 60,
                    ],
                ],
            ],
            'status' => 'success'
        ]);
    }

    public function refreshToken()
    {
        $token = JWTAuth::getToken();
        Log::info("Trying to refresh token: $token");
        if (!$token) {
            return response()->json('Token NOT provided!', 401);
        }

        Log::info("Refreshing here, but the method throws exception!!??");
        $token = JWTAuth::refresh($token);

        return response()->json([
            'token' => $token
        ]);
    }
}

