<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create(['short_name' => 'AC', 'long_name' => 'Acre']);
        State::create(['short_name' => 'AL', 'long_name' => 'Alagoas']);
        State::create(['short_name' => 'AP', 'long_name' => 'Amapá']);
        State::create(['short_name' => 'AM', 'long_name' => 'Amazonas']);
        State::create(['short_name' => 'BA', 'long_name' => 'Bahia']);
        State::create(['short_name' => 'CE', 'long_name' => 'Ceará']);
        State::create(['short_name' => 'DF', 'long_name' => 'Distrito Federal']);
        State::create(['short_name' => 'ES', 'long_name' => 'Espírito Santo']);
        State::create(['short_name' => 'GO', 'long_name' => 'Goiás']);
        State::create(['short_name' => 'MA', 'long_name' => 'Maranhão']);
        State::create(['short_name' => 'MT', 'long_name' => 'Mato Grosso']);
        State::create(['short_name' => 'MS', 'long_name' => 'Mato Grosso do Sul']);
        State::create(['short_name' => 'MG', 'long_name' => 'Minas Gerais']);
        State::create(['short_name' => 'PA', 'long_name' => 'Pará']);
        State::create(['short_name' => 'PB', 'long_name' => 'Paraíba']);
        State::create(['short_name' => 'PR', 'long_name' => 'Paraná']);
        State::create(['short_name' => 'PE', 'long_name' => 'Pernambuco']);
        State::create(['short_name' => 'PI', 'long_name' => 'Piauí']);
        State::create(['short_name' => 'RJ', 'long_name' => 'Rio de Janeiro']);
        State::create(['short_name' => 'RN', 'long_name' => 'Rio Grande do Norte']);
        State::create(['short_name' => 'RS', 'long_name' => 'Rio Grande do Sul']);
        State::create(['short_name' => 'RO', 'long_name' => 'Rondônia']);
        State::create(['short_name' => 'RR', 'long_name' => 'Roraima']);
        State::create(['short_name' => 'SC', 'long_name' => 'Santa Catarina']);
        State::create(['short_name' => 'SP', 'long_name' => 'São Paulo']);
        State::create(['short_name' => 'SE', 'long_name' => 'Sergipe']);
        State::create(['short_name' => 'TO', 'long_name' => 'Tocantins']);
    }
}
