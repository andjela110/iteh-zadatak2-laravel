<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => ['required', Password::min(8)->mixedCase()], 'name' => 'required|string|max:100', 'email' => 'required|string|max:100|email'
            ]
        );
        if ($validator->fails()) return response()->json($validator->errors());

        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => $user, 'acess_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) return response()->json(['message' => 'Unauthorized'], 401);
        $user = User::where('name', $request['name'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'hi ' . $user->name . ' welcome', 'acess_token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ['message' => 'You have logout'];
    }
}
