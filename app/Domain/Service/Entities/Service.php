<?php

namespace App\Domain\Service\Entities;

use App\Domain\Customer\Entities\Customer;

class Service
{
    public function __construct(
        public Customer $customer,
        public ?int $id
    ) {}
}