<?php

namespace App\Http\Controllers\api;

use App\Actions\User\CollectSalesPlanAction;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SalePlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller {

    public function index(CollectSalesPlanAction $action) {
        return $action->handle();
    }

    public function store(Request $request, CollectSalesPlanAction $action) {
        $plans = $request->get('plans', []);
        DB::table('sale_plans')->truncate();
        foreach ($plans as $plan) {
            foreach ($plan['plans'] as $item) {
                SalePlan::create([
                    'user_id' => $plan['user_id'],
                    'hall_id' => $item['hall_id'],
                    'sale_count' => $item['sale_count']
                ]);
            }
        }

        return $action->handle();
    }
}
