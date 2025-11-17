<?php

namespace Database\Factories;

use App\Models\Customer as EloquentCustomer;
use App\Models\State as EloquentState;
use App\Models\Installation as EloquentInstallation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Service\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => EloquentCustomer::factory()->create(),
            'state_id' => EloquentState::factory()->create(),
            'installation_id' => EloquentInstallation::factory()->create()
        ];
    }
}
