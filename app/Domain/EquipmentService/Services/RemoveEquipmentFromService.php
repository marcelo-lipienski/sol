<?php

namespace App\Domain\EquipmentService\Services;

use App\Domain\Service\Repositories\EquipmentServiceRepositoryInterface;

class RemoveEquipmentFromService
{
    public function __construct(private EquipmentServiceRepositoryInterface $equipmentServiceRepository)
    {
    }

    public function execute(int $serviceId, int $equipmentId): void
    {
        $this->equipmentServiceRepository->delete($serviceId, $equipmentId);
    }
}