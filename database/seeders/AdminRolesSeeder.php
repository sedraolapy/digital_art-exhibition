<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolesSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'admin']);
        $contentManager = Role::firstOrCreate(['name' => 'content_manager', 'guard_name' => 'admin']);
        $exhibitorManager = Role::firstOrCreate(['name' => 'exhibitor_manager', 'guard_name' => 'admin']);
        $organizer = Role::firstOrCreate(['name' => 'organizer', 'guard_name' => 'admin']);

        $permissions = [
            'manage_users',
            'manage_exhibitors',
            'manage_content',
            'manage_checkin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        $superAdmin->givePermissionTo(Permission::all());
        $contentManager->givePermissionTo(['manage_content']);
        $exhibitorManager->givePermissionTo(['manage_exhibitors']);
        $organizer->givePermissionTo(['manage_checkin']);
    }
}
