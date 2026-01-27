<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Aircraft::create(['registration' => 'TG-BOL', 'brand' => 'Cessna', 'model' => '172 Skyhawk']);
        \App\Models\Aircraft::create(['registration' => 'TG-PTN', 'brand' => 'Piper', 'model' => 'PA-28 Cherokee']);
    }
}
