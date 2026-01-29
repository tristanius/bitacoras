<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'admin_bitacoras',
            'email' => 'admin@bitacoras.dev',
            'password'=> bcrypt('Vm4q3PKS:2m)'),
        ]);
        $admin->assignRole('Admin');
    }
}
