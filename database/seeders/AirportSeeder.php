<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Airport::create(['icao_code' => 'MGGT', 'name' => 'La Aurora (Guatemala City)']);
        \App\Models\Airport::create(['icao_code' => 'MGRP', 'name' => 'Retalhuleu']);
        \App\Models\Airport::create(['icao_code' => 'MGSV', 'name' => 'Santa Elena (Petén)']);
    }
}
