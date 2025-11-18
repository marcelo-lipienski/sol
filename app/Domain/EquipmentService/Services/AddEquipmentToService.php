<?php

namespace App\Domain\EquipmentService\Services;

use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;
use App\Domain\Service\Entities\EquipmentService;
use App\Domain\Service\Repositories\EquipmentServiceRepositoryInterface;

class AddEquipmentToService
{
    public function __construct(
        private EquipmentRepositoryInterface $equipmentRepository,
        private EquipmentServiceRepositoryInterface $equipmentServiceRepository
    ) {}

    public function execute(int $serviceId, array $newEquipment): EquipmentService
    {
        $equipment = $this->equipmentRepository->findById($newEquipment['equipment_id']);

        $equipmentService = new EquipmentService(
            $equipment->name,
            $newEquipment['amount'],
            $serviceId,
            $equipment->id
        );

        return $this->equipmentServiceRepository->save($equipmentService);
    }
}