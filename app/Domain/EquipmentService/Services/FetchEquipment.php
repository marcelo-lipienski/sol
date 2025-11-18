<?php

namespace App\Domain\Equipment\Services;

use App\Domain\Equipment\Entities\Equipment;
use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;
use App\Domain\Equipment\ValueObjects\DocumentValueObject;

class FetchCustomer
{
    public function __construct(private EquipmentRepositoryInterface $customerRepository)
    {
    }

    public function execute(DocumentValueObject $documentValueObject): Equipment
    {
        return $this->customerRepository->findByDocument($documentValueObject);
    }
}