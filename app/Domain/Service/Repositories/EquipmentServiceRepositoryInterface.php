<?php

namespace App\Domain\Service\Repositories;

use App\Domain\Service\Entities\EquipmentService;

interface EquipmentServiceRepositoryInterface
{
    // public function fetchAll(): array;
    // public function findById(int $id): Equipment;
    // public function findByDocument(DocumentValueObject $documentValueObject): Equipment;
    public function save(EquipmentService $equipmentService): EquipmentService;
    public function delete(int $serviceId, int $equipmentId): void;
}