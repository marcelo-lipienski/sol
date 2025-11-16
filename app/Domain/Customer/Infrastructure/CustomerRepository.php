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
    /**
     * @return array<\App\Domain\Customer\Entities\Customer>
     */
    public function fetchAll(): array
    {
        $customers = array_map(function ($customer) {
            return new Customer(
                new EmailValueObject($customer['email']),
                new NameValueObject($customer['name']),
                new PhoneNumberValueObject($customer['phone_number']),
                new DocumentValueObject($customer['document'])
            );
        }, EloquentCustomer::all()->toArray());

        return $customers;
    }

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