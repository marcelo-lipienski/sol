<?php

namespace Tests\Feature\Domain\Customer\Application\Http\Controllers;

use App\Models\Customer as EloquentCustomer;
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

        EloquentCustomer::factory()->create($firstCustomer);
        EloquentCustomer::factory()->create($secondCustomer);

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

        EloquentCustomer::factory()->create($firstCustomer);
        EloquentCustomer::factory()->create($secondCustomer);

        $response = $this->get("/api/customer/09268913089");
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

        EloquentCustomer::factory()->create($customer);

        $this->assertDatabaseCount('customers', 1);

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

    public function test_delete_customer_by_document(): void
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

        EloquentCustomer::factory()->create($firstCustomer);
        EloquentCustomer::factory()->create($secondCustomer);
        $this->assertDatabaseCount('customers', 2);

        $response = $this->deleteJson("/api/customer/54546218000175");
        $response->assertStatus(204);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers', $secondCustomer);
    }
}
