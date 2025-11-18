<?php

namespace App\Domain\Service\Application\Http\Controllers;

use App\Models\Service;
use App\Domain\EquipmentService\Application\Http\Resources\EquipmentServiceResource;
use App\Http\Controllers\Controller;
use App\Domain\EquipmentService\Services\AddEquipmentToService;
// use App\Domain\Equipment\Services\DeleteEquipment;
// use App\Domain\Equipment\Services\FetchAllEquipments;
// use App\Domain\Equipment\Services\FetchEquipment;
use App\Http\Requests\StoreEquipmentToServiceRequest;

class EquipmentServiceController extends Controller
{
    public function store(Service $service, StoreEquipmentToServiceRequest $request, AddEquipmentToService $addEquipmentToService)
    {
        $equipmentService = $addEquipmentToService->execute($service->id, $request->validated());

        return new EquipmentServiceResource($equipmentService);
    }
}
