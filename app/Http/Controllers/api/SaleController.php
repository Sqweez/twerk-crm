<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\CreateSaleRequest;
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
}
