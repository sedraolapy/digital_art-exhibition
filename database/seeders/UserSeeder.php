<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'first_name'        => 'سيدرا',
            'last_name'         => 'العلبي',
            'email'             => 'sedra@example.com',
            'phone'             => '0999999999',
            'password'          => Hash::make('password123'),
            'qr_token'          => Str::uuid(),
        ]);

        $user1->assignRole(RoleEnum::USER->value);


        $user2 = User::create([
            'first_name'        => 'ليندا',
            'last_name'         => 'العلبي',
            'email'             => 'linda@example.com',
            'phone'             => '0988888888',
            'password'          => Hash::make('linda123'),
            'qr_token'          => Str::uuid(),
        ]);

        $user2->assignRole(RoleEnum::USER->value);


        $user3 = User::create([
            'first_name'        => 'ميرال',
            'last_name'         => 'العلبي',
            'email'             => 'rewa@example.com',
            'phone'             => '0977777777',
            'password'          => Hash::make('password456'),
            'qr_token'          => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        $user3->assignRole(RoleEnum::USER->value);
    }
}