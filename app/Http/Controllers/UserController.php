<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    static $sensitive = ['email', 'email_verified_at', 'remember_token', 'updated_at', 'password'];

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $didLogin = Auth::attempt($request->only('email', 'password'));

        if($didLogin) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        return $this->GetTokenFromCurrentUser();
    }

    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:8,30|confirmed',
            'name' => 'required|max:50',
            'password_confirmation' => 'required|between:8,30' 
        ]);

        $user = User::query()->create($request->only('name', 'email'));
    }

    public function GetTokenFromCurrentUser() : \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('default_token');
        return response()->json(['token_id' => $token->plainTextToken], '200');
    }
}