<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CyclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::firstOrCreate([
            'name' => 'Summer Cycle 2026',
            'start_date' => '2026-8-20',
            'end_date'   => '2026-08-31',
        ]);
    }
}
