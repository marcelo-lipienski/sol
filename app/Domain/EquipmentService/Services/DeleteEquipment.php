<?php

namespace App\Domain\Equipment\Services;

use App\Domain\Equipment\Entities\Equipment;
use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;
use App\Domain\Equipment\ValueObjects\DocumentValueObject;

class DeleteEquipment
{
    public function __construct(private EquipmentRepositoryInterface $equipmentRepository)
    {
    }

    public function execute(DocumentValueObject $documentValueObject): void
    {
        $this->customerRepository->delete($documentValueObject);
    }
}