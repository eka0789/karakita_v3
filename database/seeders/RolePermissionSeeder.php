<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'pengajar', 'orangtua', 'siswa'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        $permissions = [
            'manage-users', 'manage-assessment', 'view-report',
            'input-reflection', 'view-module', 'manage-module'
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('pengajar')->givePermissionTo(['manage-assessment','view-report']);
        Role::findByName('orangtua')->givePermissionTo(['view-report']);
        Role::findByName('siswa')->givePermissionTo(['input-reflection','view-module']);
    }
}
