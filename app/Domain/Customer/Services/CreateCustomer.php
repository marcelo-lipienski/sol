<?php

namespace App\Domain\Customer\Services;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;

class CreateCustomer
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    public function execute(array $newCustomer): void
    {
        $customer = new Customer(
            new EmailValueObject($newCustomer['email']),
            new NameValueObject($newCustomer['name']),
            new PhoneNumberValueObject($newCustomer['phoneNumber']),
            new DocumentValueObject($newCustomer['document'])
        );

        $this->customerRepository->save($customer);
    }
}