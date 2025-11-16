<?php

namespace Tests\Feature\Domain\Service\Application\Http\Controllers;

use App\Models\Customer as EloquentCustomer;
use App\Models\Service as EloquentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_all_services(): void
    {
        $firstCustomer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $secondCustomer = [
            'email' => 'ciclano@example.org',
            'name' => 'Ciclano da Silva',
            'phone_number' => '99219312321',
            'document' => '743.109.228-80'
        ];

        $storedFirstCustomer = EloquentCustomer::factory()->create($firstCustomer);
        $storedSecondCustomer = EloquentCustomer::factory()->create($secondCustomer);

        $firstService = EloquentService::factory()->create(['customer_id' => $storedFirstCustomer->id]);
        $secondService = EloquentService::factory()->create(['customer_id' => $storedSecondCustomer->id]);

        $response = $this->get('/api/service');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $firstService->id,
                    'customer' => $firstCustomer
                ], [
                    'id' => $secondService->id,
                    'customer' => $secondCustomer
                ]
            ]
        ]);
    }

    public function test_service_creation_is_successful(): void
    {
        $customer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $storedCustomer = EloquentCustomer::factory()->create($customer);

        $response = $this->post('/api/service', ['customer_id' => $storedCustomer->id]);
        
        $this->assertDatabaseCount('services', 1);
        $response->assertJson(['data' => ['customer' => $customer]]);
    }

    public function test_service_update_is_successful(): void
    {
        $firstCustomer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $secondCustomer = [
            'email' => 'ciclano@example.org',
            'name' => 'Ciclano da Silva',
            'phone_number' => '99219312321',
            'document' => '743.109.228-80'
        ];

        $storedFirstCustomer = EloquentCustomer::factory()->create($firstCustomer);
        $storedSecondCustomer = EloquentCustomer::factory()->create($secondCustomer);

        $this->assertDatabaseCount('customers', 2);

        $response = $this->post('/api/service', ['customer_id' => $storedFirstCustomer->id]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('services', 1);
        $response->assertJson(['data' => ['customer' => $firstCustomer]]);

        $response = $this->post('/api/service', ['id' => $response->json('data.id'), 'customer_id' => $storedSecondCustomer->id]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('services', 1);
        $response->assertJson(['data' => ['id' => $response->json('data.id'),'customer' => $secondCustomer]]);
    }
}
