<?php

namespace App\Domain\Customer\Services;

use App\Domain\Customer\Repositories\CustomerRepositoryInterface;

class FetchAllCustomers
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    /**
     * @return array<\App\Domain\Customer\Entities\Customer>
     */
    public function execute(): array
    {
        return $this->customerRepository->fetchAll();
    }
}