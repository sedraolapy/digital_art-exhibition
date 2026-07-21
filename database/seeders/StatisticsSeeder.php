<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statistics = [
            [
                'name'   => 'فنانون رقميون',
                'value'  => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'   => 'زوار',
                'value'  => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'   => 'أعمال فنية',
                'value'  => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'   => 'مواد إعلامية',
                'value'  => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Statistic::insert($statistics);
    }
    }
