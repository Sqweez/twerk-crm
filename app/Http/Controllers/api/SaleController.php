<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\CreateSaleRequest;
use App\Http\Resources\Client\ClientPurchasedServices;
use App\Http\Resources\Clients\SingleClientResource;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function getPaymentTypes (): \Illuminate\Http\JsonResponse {
        return $this->responseSuccess(Sale::PAYMENT_TYPES);
    }

    public function store (CreateSaleRequest $request, ClientController $clientController): SingleClientResource {
        $validatedData = $request->validated();
        $sale = Sale::create($validatedData);
        return $clientController->show($sale->client);
    }

    public function activateSale(Sale $sale): ClientPurchasedServices {
        $days = $sale->subscription->validity_days;
        $sale->update([
            'active_until' => now()->addDays($days - 1)
        ]);
        $sale->fresh();
        return ClientPurchasedServices::make($sale);
    }

    public function createVisit(Sale $sale, Request $request): ClientPurchasedServices {
        $trainer_id = $request->get('trainer_id');
        $sale->visits()->create([
            'user_id' => auth()->id(),
            'trainer_id' => $trainer_id,
            'client_id' => $sale->client_id,
            'subscription_id' => $sale->subscription_id,
        ]);
        $sale->fresh();
        return ClientPurchasedServices::make($sale);
    }
}
