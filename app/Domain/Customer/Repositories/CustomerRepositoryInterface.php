<?php

namespace App\Domain\Customer\Repositories;

use App\Domain\Customer\Entities\Customer;

interface CustomerRepositoryInterface
{
    /**
     * @return array<\App\Domain\Customer\Entities\Customer>
     */
    public function fetchAll(): array;
    public function save(Customer $customer): Customer;
}