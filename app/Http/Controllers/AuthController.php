<?php

namespace App\Http\Controllers;

use App\Http\Resources\Users\AuthUserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->only(['login', 'name', 'password']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return $this->responseSuccess(['token' => $user->createToken($user)->plainTextToken]);
    }

    public function username(): string {
        return 'login';
    }

    public function getMe(): AuthUserResource {
        return AuthUserResource::make(Auth::user());
    }

    public function login(Request $request) {
        if (Auth::attempt($request->only(['login', 'password']))) {
            return $this->responseSuccess(['token' => (Auth::user()->createToken(Auth::id()))->plainTextToken]);
        }
        return response()->json([], 401);
    }
}
