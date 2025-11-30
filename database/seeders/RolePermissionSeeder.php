<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [
            'user' => [
                'view.any.user',
                'view.user',
                'update.user',
                'create.user',
                'delete.user',
            ],
            'role.permission' => [
                'view.any.role.permission',
                'view.role.permission',
                'create.role.permission',
                'update.role.permission',
            ],
            'log.activity' => [
                'view.any.log.activity',
                'view.log.activity',
            ],
            'log.system' => [
                'view.any.log.system',
            ],
            'setting' => [
                'view.any.setting',
                'update.general.setting',
                'update.system.setting',
                'update.security.setting',
                'update.appearance.setting',
                'update.social.setting',
                'update.seo.setting',
                'bypass.maintenance.setting',
            ],
        ];

        // Create permissions grouped by "group"
        foreach ($permissions as $group => $groupPermissions) {
            foreach ($groupPermissions as $permissionName) {
                Permission::firstOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web'],
                    ['group' => $group] // this sets the group column
                );
            }
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());
    }
}
