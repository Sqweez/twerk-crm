<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserActiveSubscriptionsResource;
use App\Http\Resources\Users\UsersResource;
use App\Models\Role;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection {
        return UsersResource::collection(
            User::query()
                ->with('roles')
                ->get()
        );
    }

    public function getRoles(): \Illuminate\Http\JsonResponse {
        return $this->responseSuccess(Role::query()->get());
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
        $user->roles()->sync($request->get('roles'));
        return UsersResource::make(
            $user
        );
    }

    public function store(Request $request): UsersResource {
        $data = $request->only(['name', 'login', 'password']);
        $data['password'] = Hash::make($request->get('password'));
        $user = User::create($data);
        $user->roles()->sync($request->get('roles'));
        return UsersResource::make(
            $user
        );
    }

    public function getActiveSubscriptions(User $user): \Illuminate\Http\Resources\Json\AnonymousResourceCollection {
        $subscriptions = Sale::query()
            ->with(['subscription', 'subscription.type', 'visits', 'client', 'user'])
            ->where('trainer_id', $user->id)
            ->get()
            ->filter(function (Sale $sale) {
                return $sale->is_active;
            })
            ->sortBy('client.name')
            ->values();

        return UserActiveSubscriptionsResource::collection($subscriptions);
    }
}
