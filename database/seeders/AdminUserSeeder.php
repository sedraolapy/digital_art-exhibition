<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone' => '0999999999',
                'password' => bcrypt('password123'),
            ]
        );

        $admin->syncRoles(RoleEnum::SUPER_ADMIN->value);

        $organizer = User::updateOrCreate(
            ['email' => 'organizer@example.com'],
            [
                'first_name' => 'Organizer',
                'last_name' => 'Employee',
                'phone' => '0999999999',
                'password' => bcrypt('password123'),
            ]
        );

        $organizer->syncRoles(RoleEnum::ORGANIZER->value);

        $contentManager = User::updateOrCreate(
            ['email' => 'contentManager@example.com'],
            [
                'first_name' => 'Content',
                'last_name' => 'Manager',
                'phone' => '0999999999',
                'password' => bcrypt('password123'),
            ]
        );

        $contentManager->syncRoles(RoleEnum::CONTENT_MANAGER->value);

        $exhibitorApplicationManager = User::updateOrCreate(
            ['email' => 'exhibitorManager@example.com'],
            [
                'first_name' => 'Exhibitor',
                'last_name' => 'Manager',
                'phone' => '0999999999',
                'password' => bcrypt('password123'),
            ]
        );

        $exhibitorApplicationManager->syncRoles(RoleEnum::EXHIBITOR_APPLICATION_MANAGER->value);
    }
}
