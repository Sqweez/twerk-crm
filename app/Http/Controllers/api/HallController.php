<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index(): JsonResponse {
        return $this->responseSuccess(
            Hall::query()
                ->get()
        );
    }
}
