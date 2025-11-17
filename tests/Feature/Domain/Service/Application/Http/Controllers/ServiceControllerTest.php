<?php

namespace Tests\Feature\Domain\Service\Application\Http\Controllers;

use App\Models\Customer as EloquentCustomer;
use App\Models\Service as EloquentService;
use App\Models\State as EloquentState;
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

        $firstState = EloquentState::factory()->create();
        $secondState = EloquentState::factory()->create();

        $firstService = EloquentService::factory()->create([
            'customer_id' => $storedFirstCustomer->id,
            'state_id' => $firstState->id
        ]);

        $secondService = EloquentService::factory()->create([
            'customer_id' => $storedSecondCustomer->id,
            'state_id' => $secondState->id
        ]);

        $response = $this->get('/api/service');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $firstService->id,
                    'customer' => $firstCustomer,
                    'state' => $firstState->only(['short_name', 'long_name'])
                ], [
                    'id' => $secondService->id,
                    'customer' => $secondCustomer,
                    'state' => $secondState->only(['short_name', 'long_name'])
                ]
            ]
        ]);
    }

    public function test_find_service_by_id(): void
    {
        $customer = [
            'email' => 'first.customer@example.org',
            'name' => 'First Customer',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $storedCustomer = EloquentCustomer::factory()->create($customer);
        $storedState = EloquentState::factory()->create();

        $storedService = EloquentService::factory()->create([
            'customer_id' => $storedCustomer->id,
            'state_id' => $storedState->id
        ]);

        $response = $this->get("/api/service/{$storedService->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $storedService->id,
                'customer' => $customer,
                'state' => $storedState->only(['short_name', 'long_name'])
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
        $storedState = EloquentState::factory()->create();

        $response = $this->post('/api/service', [
            'customer_id' => $storedCustomer->id,
            'state_id' => $storedState->id
        ]);

        $this->assertDatabaseCount('services', 1);
        $response->assertJson([
            'data' => [
                'id' => $response->json('data.id'),
                'customer' => $customer,
                'state' => $storedState->only(['short_name', 'long_name'])
            ]
        ]);
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

        $storedFirstState = EloquentState::factory()->create();
        $storedSecondState = EloquentState::factory()->create();

        $this->assertDatabaseCount('customers', 2);

        $response = $this->post('/api/service', [
            'customer_id' => $storedFirstCustomer->id,
            'state_id' => $storedFirstState->id
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('services', 1);
        $response->assertJson([
            'data' => [
                'id' => $response->json('data.id'),
                'customer' => $firstCustomer,
                'state' => $storedFirstState->only(['short_name', 'long_name'])
            ]
        ]);

        $response = $this->post('/api/service', [
            'id' => $response->json('data.id'),
            'customer_id' => $storedSecondCustomer->id,
            'state_id' => $storedSecondState->id
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('services', 1);
        $response->assertJson([
            'data' => [
                'id' => $response->json('data.id'),
                'customer' => $secondCustomer,
                'state' => $storedSecondState->only(['short_name', 'long_name'])
            ]
        ]);
    }

    public function test_delete_service_by_id(): void
    {
        $customer = [
            'email' => 'first.customer@example.org',
            'name' => 'First Customer',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $storedCustomer = EloquentCustomer::factory()->create($customer);
        $storedState = EloquentState::factory()->create();

        $storedService = EloquentService::factory()->count(2)->create([
            'customer_id' => $storedCustomer->id,
            'state_id' => $storedState->id
        ]);

        $this->assertDatabaseCount('services', 2);

        $response = $this->deleteJson("/api/service/{$storedService[0]->id}");
        $response->assertStatus(204);
        $this->assertDatabaseCount('services', 1);
    }
}
