<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $role_client = Role::where('name', 'client')->first();
        $user = new User();
        $user->role_id = $role_client;
        $user->name = $fields['$name'];
        $user->email = $fields['$email'];
        $user->password = bcrypt($fields['$password']);
        $user->details = $fields['$details'];
        $user->save();

        $token = $user->createToken($fields['email'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request) {
        $fields = $request->validate([
            'password' => 'required|string',
            'email' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken($fields['email'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {

        Auth::user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
