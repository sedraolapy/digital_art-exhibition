<?php

namespace Database\Seeders;

use App\Enums\CycleStatus;
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
            'name' => 'Cycle 2026',
            'start_date' => '2026-09-15',
            'end_date'   => '2027-09-15',
            'status'   => CycleStatus::ACTIVE->value,
        ]);
    }
}
