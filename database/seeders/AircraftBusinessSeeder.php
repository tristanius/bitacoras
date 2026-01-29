<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AircraftBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorías exactas de la GUI del cliente
        $categories = [
            ['name' => 'ASEL', 'description' => 'Airplane Single Engine Land'],
            ['name' => 'ASES', 'description' => 'Airplane Single Engine Sea'],
            ['name' => 'AMEL', 'description' => 'Airplane Multi Engine Land'],
            ['name' => 'AMES', 'description' => 'Airplane Multi Engine Sea'],
            ['name' => 'Heli', 'description' => 'Helicopter'],
            ['name' => 'Jet',  'description' => 'Jet Engine Aircraft'],
        ];

        foreach ($categories as $cat) {
            \App\Models\AircraftCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // Modelo de ejemplo para pruebas
        $asel = \App\Models\AircraftCategory::where('name', 'ASEL')->first();
        \App\Models\AircraftModel::updateOrCreate(
            ['name' => 'Cessna 172'],
            ['manufacturer' => 'Cessna', 'aircraft_category_id' => $asel->id]
        );
        $amel = \App\Models\AircraftCategory::where('name', 'AMEL')->first();
        \App\Models\AircraftModel::create([
            'name' => 'Piper Seneca',
            'manufacturer' => 'Piper',
            'aircraft_category_id' => $amel->id
        ]);
    }
}
