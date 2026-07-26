<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            // Admin
            'ver_empleados',
            'crear_empleados',
            'editar_empleados',
            'eliminar_empleados',
            'ver_turnos',
            'crear_turnos',
            'editar_turnos',
            'eliminar_turnos',
            'ver_inventario',
            'crear_inventario',
            'editar_inventario',
            'eliminar_inventario',
            'ver_ventas',
            'ver_clientes',
            'crear_clientes',
            'editar_clientes',
            'eliminar_clientes',

            // Mesero
            'registrar_pedidos',
            'entregar_pedidos',
            'cancelar_pedidos',

            // Cocinero
            'ver_pedidos_pendientes',
            'preparar_pedidos',
            'finalizar_pedidos',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $mesero = Role::create(['name' => 'mesero']);
        $mesero->givePermissionTo([
            'registrar_pedidos',
            'entregar_pedidos',
            'cancelar_pedidos',
            'ver_clientes',
            'crear_clientes',
        ]);

        $cocinero = Role::create(['name' => 'cocinero']);
        $cocinero->givePermissionTo([
            'ver_pedidos_pendientes',
            'preparar_pedidos',
            'finalizar_pedidos',
        ]);
    }
}