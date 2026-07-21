<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminRolesSeeder::class,
            AdminUserSeeder::class,
            CategorySeeder::class,
            LocationsSeeder::class,
            CyclesSeeder::class,
            EventsOccurrencesSeeder::class,
            ExperienceSeeder::class,
            StatisticsSeeder::class,
            LecturesSeeder::class,
            SponsorSeeder::class,
            UserSeeder::class,
            ExhibitorProfileSeeder::class,
            MemberSeeder::class,
        ]);
    }
}
