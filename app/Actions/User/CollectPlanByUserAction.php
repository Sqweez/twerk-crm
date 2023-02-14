<?php

namespace App\Actions\User;

use App\Models\Hall;
use App\Models\Sale;
use App\Models\SalePlan;
use App\Models\User;
use Carbon\Carbon;

class CollectPlanByUserAction {

    public function handle(User $user, $date) {
        $defaultPlan = $this->_getPlan($user);
        $startDate = Carbon::parse($date)->startOfDay();
        $finishDate = Carbon::parse($date)
            ->endOfMonth()
            ->endOfDay();
        $mySales = Sale::query()
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $finishDate)
            ->where('trainer_id', $user->id)
            ->get();

        return $defaultPlan
            ->map(function ($plan) use ($mySales) {
                $saleCountFact = $mySales->where('hall_id', $plan['hall_id'])->count();
                $saleCountFactPercent = 0;
                if ($plan['sale_count'] !== 0) {
                    $saleCountFactPercent = (100 * $saleCountFact) / $plan['sale_count'];
                }
                $plan['sale_count_fact'] = $saleCountFact;
                $plan['sale_count_fact_percent'] = number_format($saleCountFactPercent, 2);
                return $plan;
            });
    }

    private function _getPlan(User $user) {
        $storedPlan = SalePlan::query()
            ->where('user_id', $user->id)
            ->get();

        $halls = Hall::query()->get();

        return $halls
            ->map(function ($hall) use ($storedPlan) {
                $currentHallPlan = $storedPlan->where('hall_id', $hall->id)->first();
                return [
                    'hall_id' => $hall->id,
                    'name' => $hall->name,
                    'sale_count' => $currentHallPlan ? $currentHallPlan->sale_count : 0
                ];
            });
    }
}
