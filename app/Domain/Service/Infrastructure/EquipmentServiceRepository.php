<?php

namespace App\Domain\Service\Infrastructure;

use App\Models\Equipment as EloquentEquipment;
use App\Models\Service as EloquentService;
use App\Domain\Service\Entities\EquipmentService;
use App\Domain\Service\Repositories\EquipmentServiceRepositoryInterface;

class EquipmentServiceRepository implements EquipmentServiceRepositoryInterface
{
    public function save(EquipmentService $equipmentService): EquipmentService
    {
        $equipment = EloquentEquipment::has('services')->where('id', $equipmentService->equipmentId)->first();

        if ($equipment) {
            // Equiment is already assigned to at least one service
            $equipment->services()
                ->updateExistingPivot($equipmentService, ['amount' => $equipmentService->amount]);
        } else {
            EloquentService::find($equipmentService->serviceId)
                ->equipments()
                ->attach($equipmentService->equipmentId, ['amount' => $equipmentService->amount]);
            $equipment = EloquentEquipment::find($equipmentService->equipmentId);
        }

        return new EquipmentService(
            $equipment->name,
            $equipmentService->amount,
            $equipmentService->serviceId,
            $equipmentService->equipmentId,
        );
    }

    public function delete(int $serviceId, int $equipmentId): void
    {
        $service = EloquentService::has('equipments')->where('id', $serviceId)->first();

        if ($service) {
            $service->equipments()->detach($equipmentId);
        }
    }
}