<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = collect(config('seeder.permissions'));

        $permissions->each(function ($config) {
            Permission::create($config);
        });

        // Create roles and attach permissions
        $roles = collect(config('seeder.roles'));

        $roles->each(function ($config) {
            $permissions = collect($config['permissions']);
            unset($config['permissions']);

            $role = Role::create($config);

            $permissions->each(function ($permission) use ($role) {
                $role->givePermissionTo($permission);
            });
        });
    }
}
