<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function index() {
        return $this->responseSuccess(User::all());
    }

    public function destroy($id) {
        User::destroy($id);
    }

    public function update(User $user, Request $request) {
        $data = $request->only(['name', 'login']);
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->get('password'));
            $user->token()->delete();
        }
        $user->update($data);
        return $user;
    }

    public function store(Request $request) {
        $data = $request->only(['name', 'login', 'password']);
        $data['password'] = Hash::make($request->get('password'));
        return User::create($data);
    }
}
