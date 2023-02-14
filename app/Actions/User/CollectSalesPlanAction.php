<?php

namespace App\Actions\User;

use App\Models\Hall;
use App\Models\Sale;
use App\Models\SalePlan;
use App\Models\User;

class CollectSalesPlanAction {

    public function handle() {
        $trainers = User::query()
            ->whereHas('roles', function ($query) {
                return $query->where('id', __hardcoded(3));
            })
            ->select(['id', 'name'])
            ->get();

        $halls = Hall::query()
            ->get();

        $plans = SalePlan::query()
            ->get();

        return $trainers->map(function ($user) use ($halls, $plans) {
            $currentUserPlan = $plans->where('user_id', $user->id);
            if (!$currentUserPlan) {
                $currentUserPlan = collect($halls)->map(function ($hall) {
                    return [
                        'hall_id' => $hall->id,
                        'name' => $hall->name,
                        'sale_count' => 0
                    ];
                });
            } else {
                $currentUserPlan = $halls->map(function ($hall) use ($currentUserPlan) {
                    $currentHallPlan = $currentUserPlan->where('hall_id', $hall->id)->first();
                    return [
                        'hall_id' => $hall->id,
                        'name' => $hall->name,
                        'sale_count' => $currentHallPlan ? $currentHallPlan->sale_count : 0
                    ];
                });
            }
            return [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'plans' => $currentUserPlan,
            ];
        });
    }

}
