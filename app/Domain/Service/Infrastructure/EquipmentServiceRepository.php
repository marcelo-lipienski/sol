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

    // public function delete(DocumentValueObject $documentValueObject): void
    // {
    //     $equipment = EloquentCustomer::where('document', $documentValueObject->value())->first();

    //     if ($equipment) {
    //         $equipment->delete();
    //     }
    // }
}