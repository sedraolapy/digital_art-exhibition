<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'first_name'        => ' سيدرا',
            'last_name'         => 'العلبي',
            'email'             => 'sedra@example.com',
            'phone'             => '999999999',
            'password'          => Hash::make('password123'),
            'role'              => 'user',
            'qr_token'          => Str::uuid(),
        ]);

        User::create([
            'first_name'        => 'ليندا',
            'last_name'         => 'العلبي',
            'email'             => 'linda@example.com',
            'phone'             => '988888888',
            'password'          => Hash::make('linda123'),
            'role'              => 'user',
            'qr_token'          => Str::uuid(),
        ]);

        User::create([
            'first_name'        => 'ميرال',
            'last_name'         => 'العلبي',
            'email'             => 'rewa@example.com',
            'phone'             => '977777777',
            'password'          => Hash::make('password456'),
            'role'              => 'user',
            'qr_token'          => Str::uuid(),
            'email_verified_at' => now(),
        ]);
    }
}
