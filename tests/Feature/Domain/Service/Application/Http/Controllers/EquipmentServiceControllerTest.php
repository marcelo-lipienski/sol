<?php

namespace Tests\Feature\Domain\Service\Application\Http\Controllers;

use App\Models\Customer as EloquentCustomer;
use App\Models\Equipment as EloquentEquipment;
use App\Models\Service as EloquentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EquipmentServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    private $service;

    private $equipments;

    public function setUp(): void
    {
        parent::setUp();

        $customer = [
            'email' => 'fulano@example.org',
            'name' => 'Fulano de Tal',
            'phone_number' => '123456780',
            'document' => '54.546.218/0001-75'
        ];

        $this->service = EloquentService::factory()->create([
            'customer_id' => EloquentCustomer::factory()->create($customer)
        ]);

        $this->equipments = EloquentEquipment::factory()->count(3)->create();
    }

    public function test_equipment_is_added_to_service(): void
    {
        $response = $this->post("/api/service/{$this->service->id}/equipment", [
            'equipment_id' => $this->equipments->first()->id,
            'amount' => 1
        ]);

        $this->assertDatabaseCount('equipments_services', 1);
        $response->assertJson([
            'data' => [
                'service_id' => $this->service->id,
                'equipment' => [
                    'name' => $this->equipments->first()->name,
                    'amount' => 1
                ]
            ]
        ]);
    }

    public function test_equipment_is_updated_on_service(): void
    {
        $this->service->equipments()
            ->attach($this->equipments->first()->id, ['amount' => 1]);

        $this->assertDatabaseCount('equipments_services', 1);

        $response = $this->post("/api/service/{$this->service->id}/equipment", [
            'service_id' => $this->service->id,
            'equipment_id' => $this->equipments->first()->id,
            'amount' => 5
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('equipments_services', 1);
        $response->assertJson([
            'data' => [
                'service_id' => $this->service->id,
                'equipment' => [
                    'name' => $this->equipments->first()->name,
                    'amount' => 5
                ]
            ]
        ]);
    }

    public function test_remove_equipment_from_service(): void
    {
        $this->service->equipments()
            ->attach($this->equipments->first()->id, ['amount' => 1]);

        $this->service->equipments()
            ->attach($this->equipments->last()->id, ['amount' => 10]);

        $this->assertDatabaseCount('equipments_services', 2);

        $response = $this->deleteJson("/api/service/{$this->service->id}/equipment/{$this->equipments->first()->id}");
        $response->assertStatus(204);
        $this->assertDatabaseCount('equipments_services', 1);
        $this->assertDatabaseHas('equipments_services', [
            'service_id' => $this->service->id,
            'equipment_id' => $this->equipments->last()->id
        ]);
    }
}
