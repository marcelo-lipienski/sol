<?php

namespace App\Domain\Service\Application\Http\Controllers;

use App\Domain\Service\Application\Http\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Domain\Service\Services\CreateService;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    public function store(StoreServiceRequest $request, CreateService $createService)
    {
        $service = $createService->execute($request->validated());

        return new ServiceResource($service);
    }
}
