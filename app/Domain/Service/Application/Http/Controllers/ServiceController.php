<?php

namespace App\Domain\Service\Application\Http\Controllers;

use App\Domain\Service\Application\Http\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Domain\Service\Services\CreateService;
use App\Domain\Service\Services\FetchAllServices;
use App\Domain\Service\Services\FetchService;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    public function index(FetchAllServices $fetchAllServices)
    {
        $services = $fetchAllServices->execute();

        return ServiceResource::collection($services);
    }

    public function show(int $id, FetchService $fetchService)
    {
        $service = $fetchService->execute($id);

        return new ServiceResource($service);
    }

    public function store(StoreServiceRequest $request, CreateService $createService)
    {
        $service = $createService->execute($request->validated());

        return new ServiceResource($service);
    }
}
