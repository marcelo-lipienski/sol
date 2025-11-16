<?php

namespace App\Domain\Customer\Services;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObjects\DocumentValueObject;

class DeleteCustomer
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    public function execute(DocumentValueObject $documentValueObject): void
    {
        $this->customerRepository->delete($documentValueObject);
    }
}