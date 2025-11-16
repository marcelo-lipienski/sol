<?php

namespace Tests\Feature\Domain\Customer\Application\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_customers(): void
    {
        $firstCustomer = [
            'email' => 'first.customer@example.org',
            'name' => 'First Customer',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $secondCustomer = [
            'email' => 'second.customer@example.org',
            'name' => 'Second Customer',
            'phone_number' => '9987665421',
            'document' => '092.689.130-89'
        ];

        $this->post('/api/customer', $firstCustomer);
        $this->post('/api/customer', $secondCustomer);

        $response = $this->get('/api/customer');
        $response->assertStatus(200);
        $response->assertJson(['data' => [$firstCustomer, $secondCustomer]]);
    }

    public function test_find_customer_by_document(): void
    {
        $firstCustomer = [
            'email' => 'first.customer@example.org',
            'name' => 'First Customer',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $secondCustomer = [
            'email' => 'second.customer@example.org',
            'name' => 'Second Customer',
            'phone_number' => '9987665421',
            'document' => '092.689.130-89'
        ];

        $this->post('/api/customer', $firstCustomer);
        $this->post('/api/customer', $secondCustomer);

        $response = $this->get("/api/customer/{$secondCustomer['document']}");
        $response->assertStatus(200);
        $response->assertJson(['data' => $secondCustomer]);
    }

    public function test_customer_creation_is_successful(): void
    {
        $customer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $response = $this->post('/api/customer', $customer);

        $response->assertStatus(200);
        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['data' => $customer]);
    }

    public function test_customer_update_is_successful(): void
    {
        $customer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $response = $this->post('/api/customer', $customer);

        $response->assertStatus(200);
        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['data' => $customer]);


        $updatedCustomer = [
            'email' => 'fulano.da.silva@example.org',
            'name' => 'Fulano da Silva',
            'phone_number' => '01234567',
            'document' => '54.546.218/0001-75'
        ];

        $response = $this->post('/api/customer', $updatedCustomer);

        $response->assertStatus(200);
        $this->assertDatabaseCount('customers', 1);
        $response->assertJson(['data' => $updatedCustomer]);
    }
}
