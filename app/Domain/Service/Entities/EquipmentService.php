<?php

namespace App\Domain\Service\Entities;

class EquipmentService
{
    public function __construct(
        public string $name,
        public int $amount,
        public int $serviceId,
        public int $equipmentId,
    ) {}
}