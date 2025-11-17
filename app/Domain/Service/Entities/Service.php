<?php

namespace App\Domain\Service\Entities;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Installation\Entities\Installation;
use App\Domain\State\Entities\State;

class Service
{
    public function __construct(
        public Customer $customer,
        public State $state,
        public Installation $installation,
        public ?int $id
    ) {}
}