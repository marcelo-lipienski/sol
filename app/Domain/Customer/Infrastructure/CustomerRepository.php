<?php

namespace App\Domain\Customer\Infrastructure;

use App\Models\Customer as EloquentCustomer;
use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function save(Customer $customer): Customer
    {
        $storedCustomer = EloquentCustomer::updateOrCreate(
            ['document' => $customer->document->value()],
            [
                'name' => $customer->name->value(),
                'email' => $customer->email->value(),
                'phone_number' => $customer->phoneNumber->value()
            ]
        );

        return new Customer(
            new EmailValueObject($storedCustomer->email),
            new NameValueObject($storedCustomer->name),
            new PhoneNumberValueObject($storedCustomer->phone_number),
            new DocumentValueObject($storedCustomer->document)
        );
    }
}