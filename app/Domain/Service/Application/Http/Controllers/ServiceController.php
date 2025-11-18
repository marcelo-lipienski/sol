<?php

namespace App\Domain\Service\Application\Http\Controllers;

use App\Domain\Service\Application\Http\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Domain\Service\Services\CreateService;
use App\Domain\Service\Services\DeleteService;
use App\Domain\Service\Services\FetchAllServices;
use App\Domain\Service\Services\FetchService;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service as EloquentService;

class ServiceController extends Controller
{
    public function index(FetchAllServices $fetchAllServices)
    {
        $services = $fetchAllServices->execute();

        return ServiceResource::collection($services);
    }

    public function show(EloquentService $service, FetchService $fetchService)
    {
        $service = $fetchService->execute($service->id);

        return new ServiceResource($service);
    }

    public function store(StoreServiceRequest $request, CreateService $createService)
    {
        $newService = $createService->execute($request?->id, $request->validated());

        return new ServiceResource($newService);
    }

    public function destroy(EloquentService $service, DeleteService $deleteService)
    {
        $deleteService->execute($service->id);

        return response()->json([], 204);
    }
}
