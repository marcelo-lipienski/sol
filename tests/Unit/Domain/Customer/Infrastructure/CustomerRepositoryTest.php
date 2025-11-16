<?php

namespace Tests\Unit\Domain\Customer\Infrastructure;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Infrastructure\CustomerRepository;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;
use App\Models\Customer as EloquentCustomer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_customer(): void
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

        $customerRepository = new CustomerRepository();
        $customerRepository->save($customer);

        $expectedData = [
            'email' => 'test@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '1234',
            'document' => '18172882000138' // 18.172.882/0001-38
        ];

        $this->assertDatabaseCount(EloquentCustomer::class, 1);
        $this->assertDatabaseHas(EloquentCustomer::class, $expectedData);
    }

    public function test_update_customer(): void
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

        $customerRepository = new CustomerRepository();
        $customerRepository->save($customer);

        $data = [
            'email' => 'other-email@example.org',
            'name' => 'Fulano da Silva',
            'phoneNumber' => '4321',
            'document' => '18172882000138' // 18.172.882/0001-38
        ];

        $updatedCustomer = new Customer(
            new EmailValueObject($data['email']),
            new NameValueObject($data['name']),
            new PhoneNumberValueObject($data['phoneNumber']),
            new DocumentValueObject($data['document'])
        );

        $customerRepository->save($updatedCustomer);

        $expectedData = [
            'email' => 'other-email@example.org',
            'name' => 'Fulano da Silva',
            'phone_number' => '4321',
            'document' => '18172882000138' // 18.172.882/0001-38
        ];

        $this->assertDatabaseCount(EloquentCustomer::class, 1);
        $this->assertDatabaseHas(EloquentCustomer::class, $expectedData);
    }
}