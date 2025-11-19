<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\LendingResource;
use App\Models\Lending;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function overdue()
    {
        $today = Carbon::today()->format('Y-m-d');

        $overdue = Lending::with(['book', 'friend'])
            ->whereNull('return_at')     // not returned yet
            ->where('due_at', '<', $today) // due date is in the past
            ->get();

        return LendingResource::collection($overdue);
    }
}
