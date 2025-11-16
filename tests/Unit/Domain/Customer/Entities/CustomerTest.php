<?php

namespace Tests\Unit\Domain\Customer\Entities;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_is_customer_valid(): void
    {
        $data = [
            'email' => 'test@example.org',
            'name' => 'Fulano de Tal',
            'phoneNumber' => '1234',
            'document' => '18172882000138' // 18.172.882/0001-38
        ];

        $customer = new Customer(
            new EmailValueObject($data['email']),
            new NameValueObject($data['name']),
            new PhoneNumberValueObject($data['phoneNumber']),
            new DocumentValueObject($data['document'])
        );

        $this->assertSame($data['email'], $customer->email->value());
        $this->assertSame($data['name'], $customer->name->value());
        $this->assertSame($data['phoneNumber'], $customer->phoneNumber->value());
        $this->assertSame($data['document'], $customer->document->value());
    }
}