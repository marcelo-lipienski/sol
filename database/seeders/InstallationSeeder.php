<?php

namespace Database\Seeders;

use App\Models\Installation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstallationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Installation::create(['name' => 'Fibrocimento (Madeira)']);
        Installation::create(['name' => 'Fibrocimento (Metálico)']);
        Installation::create(['name' => 'Cerâmico']);
        Installation::create(['name' => 'Metálico']);
        Installation::create(['name' => 'Laje']);
        Installation::create(['name' => 'Solo']);
    }
}
