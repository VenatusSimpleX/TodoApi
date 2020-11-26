<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request(['username', 'password']), [
            'username' => 'required|min:3|max:255|unique:users,username',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 409);
        }

        $user = User::create([
            'username' => request()->username,
            'password' => bcrypt(request()->password)
        ]);

        if ($user = Auth::login($user)) {
            return response()->json([
                'message' => 'Successfully registered new user',
                'token' => $user
            ], 201);
        }

        return response()->json([
            'error' => 'Server error, contact developer'
        ], 500);
    }

    public function login()
    {
        if ($user = Auth::attempt(request(['username', 'password']))) {
            return response()->json([
                'token' => $user
            ], 200);
        }

        return response()->json([
            'error' => 'Invalid username/password'
        ], 401);
    }

    public function logout()
    {
        Auth::logout(auth()->user());

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function show()
    {
        if ($user = auth()->user()) {
            return response()->json($user, 200);
        }
    }

    public function destroy()
    {
        $user = User::find(auth()->user())->first();
        $user->delete();

        return response()->json([
            'message' => 'User deleted'
        ], 200);
    }
}
