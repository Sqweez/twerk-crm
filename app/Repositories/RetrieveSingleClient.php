<?php

namespace App\Repositories;

use App\Models\Client;

class RetrieveSingleClient {

    public static function retrieve(Client $client): Client {
        $client->load('sales');
        $client->load('sales.subscription');
        $client->load('sales.subscription.type');
        $client->load('sales.visits');
        $client->load('visits.user');
        $client->load('visits.trainer');
        $client->load('visits.subscription');
        $client->load('visits.sale');
        $client->load('visits.sale.hall');
        return $client;
    }
}
