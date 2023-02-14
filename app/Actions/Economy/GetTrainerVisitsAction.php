<?php

namespace App\Actions\Economy;

use App\Http\Resources\Economy\ClientVisitsResource;
use App\Models\Visit;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTrainerVisitsAction {

    public function handle($start, $finish, $user_id = null): AnonymousResourceCollection {
        $visits = Visit::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $finish)
            ->when(!is_null($user_id), function ($q) use ($user_id) {
                return $q->where('trainer_id', $user_id);
            })
            ->with('sale.hall')
            ->with('subscription')
            ->with('client')
            ->has('trainer')
            ->with('trainer')
            ->get();

        return ClientVisitsResource::collection($visits);
    }
}
