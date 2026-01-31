<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear Roles
        #$adminRole      = Role::create(['name' => 'admin']);
        #$instructorRole = Role::create(['name' => 'instructor']);
        #$pilotRole      = Role::create(['name' => 'piloto']);
        #$oficialRole    = Role::create(['name' => 'oficial']); // <-- Nuevo Rol

        // 3. Crear Usuarios de Prueba

        // USUARIO ADMINISTRADOR
        

        #$admin = User::factory()->create([
        #    'name' => 'admin_bitacoras',
        #    'email' => 'admin@bitacoras.dev',
        #    'password'=> bcrypt('Vm4q3PKS:2m)'),
        #]);
        #$admin->assignRole($adminRole);
        

        // USUARIO INSTRUCTOR
        User::create([
            'name' => 'Capitán Instructor',
            'email' => 'instructor@bitacoras.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ])->assignRole("Instructor");

        // USUARIO OFICIAL (Operaciones/Seguridad)
        User::create([
            'name' => 'Oficial de Operaciones',
            'email' => 'oficial@bitacoras.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ])->assignRole("Oficial de Operaciones");

        // USUARIO PILOTO
        User::create([
            'name' => 'Piloto de Prueba',
            'email' => 'piloto@bitacoras.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ])->assignRole("Piloto");
    }
}