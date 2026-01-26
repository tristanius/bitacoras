<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Permisos de Gestión
        Permission::create(['name' => 'manage.users']);
        Permission::create(['name' => 'manage.aircrafts']);
        Permission::create(['name' => 'manage.airports']);
        
        // Permisos de Operación (Bitácora)
        Permission::create(['name' => 'flight.create']);
        Permission::create(['name' => 'flight.validate']); // Solo Instructores/Admin
        Permission::create(['name' => 'flight.delete']);   // Solo Admin
        Permission::create(['name' => 'flight.view_all']); // Secretario/Admin

        // Crear Roles y asignar permisos
        Role::create(['name' => 'Admin'])->givePermissionTo(Permission::all());
        
        $oficial = Role::create(['name' => 'Oficial de Operaciones']);
        $oficial->givePermissionTo(['manage.users', 'manage.aircrafts', 'manage.airports', 'flight.view_all', 'flight.create']);

        $instructor = Role::create(['name' => 'Instructor']);
        $instructor->givePermissionTo(['flight.create', 'flight.validate', 'flight.view_all']);

        $piloto = Role::create(['name' => 'Piloto']);
        $piloto->givePermissionTo(['flight.create','flight.view_all']);
    }
}
