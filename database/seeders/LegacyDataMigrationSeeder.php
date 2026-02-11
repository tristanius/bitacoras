<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegacyDataMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $juanId = 2;

        // 1. Marcar aeropuertos actuales como públicos
        \DB::table('airports')->update(['type' => 'public']);

        // 2. Vincular todas las aeronaves existentes a Juan
        $aircraftIds = \DB::table('aircraft')->pluck('id');
        foreach ($aircraftIds as $id) {
            \DB::table('aircraft_user')->insertOrIgnore([
                'aircraft_id' => $id,
                'user_id' => $juanId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Vincular todos los aeropuertos existentes a Juan
        $airportIds = \DB::table('airports')->pluck('id');
        foreach ($airportIds as $id) {
            \DB::table('airport_user')->insertOrIgnore([
                'airport_id' => $id,
                'user_id' => $juanId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
