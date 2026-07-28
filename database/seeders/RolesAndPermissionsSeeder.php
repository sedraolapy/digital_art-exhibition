<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();


        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission->value,
                'guard_name' => 'web',
            ]);
        }


        foreach (RoleEnum::cases() as $role) {
            Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => 'web',
            ]);
        }


        $contentManager = Role::findByName(
            RoleEnum::CONTENT_MANAGER->value,
            'web'
        );

        $contentManager->syncPermissions([
            PermissionEnum::ACCESS_ADMIN_PANEL->value,

            PermissionEnum::VIEW_EXPERIENCES->value,
            PermissionEnum::UPDATE_EXPERIENCES->value,

            PermissionEnum::VIEW_MEMBERS->value,
            PermissionEnum::UPDATE_MEMBERS->value,

            PermissionEnum::VIEW_SPONSORS->value,
            PermissionEnum::UPDATE_SPONSORS->value,

            PermissionEnum::VIEW_STATISTICS->value,
            PermissionEnum::UPDATE_STATISTICS->value,

            PermissionEnum::VIEW_LECTURES->value,
            PermissionEnum::UPDATE_LECTURES->value,

            PermissionEnum::VIEW_EXHIBITOR_PROFILES->value,
            PermissionEnum::UPDATE_EXHIBITOR_PROFILES->value,
        ]);


        $exhibitorManager = Role::findByName(
            RoleEnum::EXHIBITOR_APPLICATION_MANAGER->value,
            'web'
        );

        $exhibitorManager->syncPermissions([
            PermissionEnum::ACCESS_ADMIN_PANEL->value,

            PermissionEnum::VIEW_EXHIBITOR_APPLICATIONS->value,
            PermissionEnum::UPDATE_EXHIBITOR_APPLICATIONS->value,
        ]);



        $organizer = Role::findByName(
            RoleEnum::ORGANIZER->value,
            'web'
        );

        $organizer->syncPermissions([
            PermissionEnum::ACCESS_ADMIN_PANEL->value,
            
            PermissionEnum::PERFORM_CHECK_IN->value,
        ]);
    }
}