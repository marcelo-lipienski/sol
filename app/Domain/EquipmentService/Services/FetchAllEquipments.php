<?php

namespace App\Domain\Equipment\Services;

use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;

class FetchAllCustomers
{
    public function __construct(private EquipmentRepositoryInterface $customerRepository)
    {
    }

    /**
     * @return array<\App\Domain\Equipment\Entities\Equipment>
     */
    public function execute(): array
    {
        return $this->customerRepository->fetchAll();
    }
}