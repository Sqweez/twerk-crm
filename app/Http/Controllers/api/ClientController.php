<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\Clients\ClientsResource;
use App\Http\Resources\Clients\SingleClientResource;
use App\Models\Client;
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

    public function show(Client $client) {
        $client->load('sales');
        $client->load('sales.subscription');
        $client->load('sales.subscription.type');
        $client->load('sales.visits');
        return SingleClientResource::make($client);
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
