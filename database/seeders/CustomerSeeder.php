<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->create(['document' => '95.656.870/0001-20']);
        Customer::factory()->create(['document' => '58.214.583/0001-33']);
        Customer::factory()->create(['document' => '928.605.975-22']);
    }
}
