<?php

namespace App\Actions\Economy;

use App\Actions\User\CollectSalesPlanAction;
use App\Models\Hall;
use App\Models\Sale;
use Carbon\Carbon;

class CollectTeamPlanExecutionAction {

    private CollectSalesPlanAction $action;

    public function __construct() {
        $this->action = new CollectSalesPlanAction();
    }

    public function handle($date) {
        $halls = Hall::query()->get();
        $teamPlan = $this->action->handle();
        $startDate = Carbon::parse($date)->startOfDay();
        $finishDate = Carbon::parse($date)
            ->endOfMonth()
            ->endOfDay();
        $sales = Sale::query()
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $finishDate)
            ->has('trainer')
            ->get();

        $teamPlan = $teamPlan->map(function ($plan) use ($sales) {
            $currentSales = $sales->where('trainer_id', $plan['user_id']);
            $plan['plans'] = collect($plan['plans'])->map(function ($currentPlan) use ($currentSales) {
                $saleCountFact = $currentSales->where('hall_id', $currentPlan['hall_id'])->count();
                $saleCountFactPercent = 0;
                if ($currentPlan['sale_count'] !== 0) {
                    $saleCountFactPercent = (100 * $saleCountFact) / $currentPlan['sale_count'];
                }
                $currentPlan['sale_count_fact'] = $saleCountFact;
                $currentPlan['sale_count_fact_percent'] = number_format($saleCountFactPercent, 2);
                return $currentPlan;
            });
            return $plan;
        })->toArray();

        $formattedTeamPlan = [];
        foreach ($teamPlan as $item) {
            foreach ($item['plans'] as $plan) {
                $formattedTeamPlan[] = [
                    'user_name' => $item['user_name'],
                    'user_id' => $item['user_id'],
                    'name' => $plan['name'],
                    'hall_id' => $plan['hall_id'],
                    'sale_count' => $plan['sale_count'],
                    'sale_count_fact' => $plan['sale_count_fact'],
                    'sale_count_fact_percent' => $plan['sale_count_fact_percent']
                ];
            }
        }


        $totalOutput = [];

        foreach ($halls as $hall) {
            $needlePlans = collect($formattedTeamPlan)->where('hall_id', $hall['id']);
            $saleCountPlan = $needlePlans->reduce(function ($a, $c) {
                return $a + $c['sale_count'];
            }, 0);
            $saleCountFact = $needlePlans->reduce(function ($a, $c) {
                return $a + $c['sale_count_fact'];
            }, 0);

            $saleCountPercent = 0;

            if ($saleCountPlan !== 0) {
                $saleCountPercent = (100 * $saleCountFact) / $saleCountPlan;
            }

            $totalOutput[] = [
                'user_name' => $hall['name'],
                'user_id' => null,
                'name' => $hall['name'],
                'sale_count' => $saleCountPlan,
                'sale_count_fact' => $saleCountFact,
                'sale_count_fact_percent' => number_format($saleCountPercent, 2)
            ];
        }

        $totalSaleCountPlan = array_reduce($formattedTeamPlan, function ($a, $c) {
            return $a + $c['sale_count'];
        }, 0);

        $totalSaleCountFact = array_reduce($formattedTeamPlan, function ($a, $c) {
            return $a + $c['sale_count_fact'];
        }, 0);

        $saleCountFactPercent = 0;

        if ($totalSaleCountPlan !== 0) {
            $saleCountFactPercent = (100 * $totalSaleCountFact) / $totalSaleCountPlan;
        }

        $totalPlanExecution = [
            'user_name' => 'ИТОГО',
            'user_id' => null,
            'name' => 'ИТОГО',
            'hall_id' => null,
            'sale_count' => $totalSaleCountPlan,
            'sale_count_fact' => $totalSaleCountFact,
            'sale_count_fact_percent' => number_format($saleCountFactPercent, 2)
        ];

        $totalOutput[] = $totalPlanExecution;

        return [
            'by_trainer' => $formattedTeamPlan,
            'total' => $totalOutput
        ];
    }
}
