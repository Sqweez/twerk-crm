<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\CreateSubscriptionRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionRequest;
use App\Http\Resources\Subscription\SubscriptionResource;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection {
        $subscriptions = Subscription::query()
            ->with('type')
            ->get();
        return SubscriptionResource::collection($subscriptions);
    }

    public function getSubscriptionTypes(): JsonResponse {
        return $this->responseSuccess(SubscriptionType::query()->get());
    }

    public function show(Subscription $subscription) {
        return SubscriptionResource::make($subscription);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSubscriptionRequest $request
     * @return SubscriptionResource
     */
    public function store(CreateSubscriptionRequest $request): SubscriptionResource {
        $subscription = Subscription::create($request->validated());
        return SubscriptionResource::make($subscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSubscriptionRequest $request
     * @param Subscription $subscription
     * @return SubscriptionResource
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription): SubscriptionResource {
        $subscription->update($request->validated());
        $subscription->fresh();
        return SubscriptionResource::make($subscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return \response()->noContent();
    }
}
