<?php

namespace Database\Seeders;

use App\Enums\EventOccurrenceStatus;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsOccurrencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $summerCycle = Cycle::where('name', 'Summer Cycle 2026')->first();

        EventOccurrence::firstOrCreate([
            'title'   => 'ملتقى دمشق الاول',
            'cycle_id' => $summerCycle->id,
            'location_id' => 1,
            'start_date' => '2026-08-20',
            'end_date'   => '2026-08-23',
            'is_voting_enabled' => false,
            'status' => EventOccurrenceStatus::ACTIVE->value,
        ]);

        EventOccurrence::firstOrCreate([
            'title'   => 'الملتقى الثاني',
            'cycle_id' => $summerCycle->id,
            'location_id' => 2,
            'start_date' => '2026-08-31',
            'end_date'   => '2026-09-05',
            'is_voting_enabled' => false,
            'status' => EventOccurrenceStatus::UPCOMING->value,
        ]);
    }
}
