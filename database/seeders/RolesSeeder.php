<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $roles = ['admin', 'editor', 'viewer'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Crear usuario admin si no existe
        $adminEmail = 'admin@admin.com';

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'), // Cambiá la contraseña si querés
            ]
        );

        // Asignar rol admin si no lo tiene
        if (!$admin->hasRole('admin')) {
            $admin->syncRoles('admin');
        }
    }
}
