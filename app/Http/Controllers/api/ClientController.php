<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\Client\ClientExpiringSubscriptions;
use App\Http\Resources\Clients\ClientsResource;
use App\Http\Resources\Clients\SingleClientResource;
use App\Models\Client;
use App\Models\Sale;
use App\Repositories\RetrieveSingleClient;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection {
        return ClientsResource::collection(
            Client::query()->get()
        );
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(CreateClientRequest $request) {
        $data = $request->validated();
        /* @var Client $client */
        $client = Client::create($data);
        if (isset($data['avatar'])) {
            $client->addMedia($data['avatar'])
                ->preservingOriginal()
                ->toMediaCollection();
        }
        return ClientsResource::make($client);
    }

    public function getExpiringSubscriptions() {
        $sales = Sale::query()
            ->with('client')
            ->with('subscription')
            ->with('visits')
            ->with('hall')
            ->whereDate('active_until', '>', today()->subDay())
            ->get()
            ->filter(function (Sale $sale) {
                return $sale->visits_remaining > 0 && $sale->visits_remaining <= 2;
            })
            ->values();

        return ClientExpiringSubscriptions::collection($sales);
    }

    public function show(Client $client): SingleClientResource {
        return SingleClientResource::make(
            RetrieveSingleClient::retrieve($client)
        );
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UpdateClientRequest $request, Client $client): ClientsResource {
        $data = $request->validated();
        $client->update($data);
        if (Arr::has($data, 'avatar')) {
            $client->clearMediaCollection();
            $client->addMedia($data['avatar'])
                ->preservingOriginal()
                ->toMediaCollection();
        }
        $client->fresh();
        return ClientsResource::make($client);
    }

    public function destroy($id) {
        Client::destroy($id);
    }
}
