<?php

namespace App\Http\Controllers\api;

use App\Actions\Economy\CollectTeamPlanExecutionAction;
use App\Actions\Economy\GetTrainerVisitsAction;
use App\Actions\User\CollectPlanByUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Economy\ClientVisitsResource;
use App\Http\Resources\Economy\SaleListResource;
use App\Http\Resources\Economy\TrainerStatsResource;
use App\Models\Sale;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EconomyController extends Controller
{

    private $start;
    private $finish;

    public function index(Request $request, GetTrainerVisitsAction $trainerVisitsAction): JsonResponse {
        $this->start = Carbon::parse($request->get('start', now()));
        $this->finish = Carbon::parse($request->get('finish', now()));
        return response()->json([
            'reports' => [
                'client_visits' => $this->getClientVisits(),
                'sales' => $this->getSales(),
                'trainer_sales' => $this->getTrainerSales(),
                'trainer_visits' => $trainerVisitsAction->handle($this->start, $this->finish),
            ]
        ]);
    }

    private function getClientVisits(): AnonymousResourceCollection {
        $visits = Visit::query()
            ->whereDate('created_at', '>=', $this->start)
            ->whereDate('created_at', '<=', $this->finish)
            ->with('subscription')
            ->with('client')
            ->with('trainer')
            ->get();

        return ClientVisitsResource::collection($visits);
    }

    private function getSales(): AnonymousResourceCollection {
        $sales = Sale::query()
            ->whereDate('created_at', '>=', $this->start)
            ->whereDate('created_at', '<=', $this->finish)
            ->with('subscription')
            ->with('client')
            ->with('trainer')
            ->with('user')
            ->get();

        return SaleListResource::collection($sales);
    }

    private function getTrainerSales(): AnonymousResourceCollection {
        $sales = Sale::query()
            ->whereDate('created_at', '>=', $this->start)
            ->whereDate('created_at', '<=', $this->finish)
            ->with('subscription')
            ->with('client')
            ->has('trainer')
            ->with('trainer')
            ->with('user')
            ->get();

        return TrainerStatsResource::collection($sales);
    }

    public function getTrainerVisits(Request $request, GetTrainerVisitsAction $action): AnonymousResourceCollection {
        return $action->handle(
            $request->get('start'),
            $request->get('finish'),
            $request->get('user_id')
        );
    }

    public function getEconomyPlanByUser(User $user, string $date, CollectPlanByUserAction $action) {
        $date = Carbon::parse($date);
        return $action->handle($user, $date);
    }

    public function getEconomyPlanTotal(string $date, CollectTeamPlanExecutionAction $action) {
        $date = Carbon::parse($date);
        return $action->handle($date);
    }
}
