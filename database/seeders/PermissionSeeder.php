<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset old cached permissions
        // app()[\Spatie\Permissionn\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions=[
            'create user', 'book service', 'deliver service', 'rate'
        ];

        foreach($permissions as $permission) {
            Permission::firstOrCreate(['name'=> $permission, 'guard_name'=>'web']);
        }

        $admin=Role::firstOrcreate(['name'=>'admin']);
        $customer=Role::firstOrcreate(['name'=>'customer']);
        $tradesperson=Role::firstOrcreate(['name'=>'tradesperson']);

        $admin->syncPermissions(Permission::all());

        $customer->syncPermissions(['book service', 'rate']);

        $tradesperson->syncPermissions(['deliver service']);
    }
}
