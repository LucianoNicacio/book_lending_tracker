<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LendBookRequest;
use App\Http\Resources\LendingResource;
use App\Models\Lending;
use App\Services\LendingService;
use Illuminate\Http\Request;

class LendingController extends Controller
{
    public function __construct(protected LendingService $lendingService)
    {
    }

    public function store(LendBookRequest $request)
    {
        // Data is already validated by LendBookRequest
        $lending = $this->lendingService->lend($request->validated());

        // Return a resource with book+friend loaded
        return new LendingResource($lending->load(['book', 'friend']));
    }

    public function markReturned(Request $request, Lending $lending)
    {
        $data = $request->validate([
            'return_at' => ['nullable', 'date'],
        ]);

        $updated = $this->lendingService->markReturned($lending, $data['return_at'] ?? null);

        return new LendingResource($updated->load(['book', 'friend']));
    }
}
