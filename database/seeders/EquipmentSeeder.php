<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipment::create(['name' => 'Módulo']);
        Equipment::create(['name' => 'Inversor']);
        Equipment::create(['name' => 'Microinversor']);
        Equipment::create(['name' => 'Estrutura']);
        Equipment::create(['name' => 'Cabo vermelho']);
        Equipment::create(['name' => 'Cabo preto']);
        Equipment::create(['name' => 'String Box']);
        Equipment::create(['name' => 'Cabo Tronco']);
        Equipment::create(['name' => 'Endcap']);
    }
}
