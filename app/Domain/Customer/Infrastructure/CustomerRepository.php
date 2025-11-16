<?php

namespace App\Domain\Customer\Infrastructure;

use App\Models\Customer as EloquentCustomer;
use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function save(Customer $customer): void
    {
        EloquentCustomer::updateOrCreate(
            ['document' => $customer->document->value()],
            [
                'name' => $customer->name->value(),
                'email' => $customer->email->value(),
                'phone_number' => $customer->phoneNumber->value()
            ]
        );
    }
}