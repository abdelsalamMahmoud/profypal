<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $validator->validated();
        $domain = explode('@', $credentials['email'])[1];

        // Attempt authentication with both guards sequentially
        $guards = ['user', 'company'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials)) {
                $token = Auth::guard($guard)->attempt($credentials);
                return $this->createNewToken($token,$guard);
            }
        }
        // If authentication fails for both guards
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users,username',
            'Fname' => 'required|string',
            'Lname' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'bio' => 'required',
            'age' => 'required',
            'degree' => 'required',
            'skills' => 'required',
            'years_of_experience' => 'required',
            'current_company' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function registerCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'info' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = Company::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'company successfully registered',
            'user' => $user
        ], 201);
    }



    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token,$guard){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth($guard)->user()
        ]);
    }
}
