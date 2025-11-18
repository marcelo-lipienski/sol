<?php

namespace App\Domain\Equipment\Infrastructure;

use App\Models\Equipment as EloquentEquipment;
use App\Domain\Equipment\Entities\Equipment;
use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function findById(int $equipmentId): Equipment
    {
        $equipment = EloquentEquipment::find($equipmentId);

        return new Equipment(
            $equipment->name,
            $equipment->id
        );
    }
}