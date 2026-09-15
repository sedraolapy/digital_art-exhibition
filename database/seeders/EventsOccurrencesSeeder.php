<?php

namespace Database\Seeders;

use App\Enums\EventOccurrenceStatus;
use App\Models\Cycle;
use App\Models\EventDay;
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
        $summerCycle = Cycle::where('name', 'Cycle 2026')->first();

        $event1 = EventOccurrence::firstOrCreate([
            'title'   => 'معرض الفنون الرقمية',
            'cycle_id' => $summerCycle->id,
            'location_id' => 1,
            'start_date' => '2026-09-17',
            'end_date'   => '2026-09-23',
            'is_voting_enabled' => false,
            'status' => EventOccurrenceStatus::ACTIVE->value,
        ]);
        EventDay::firstOrCreate([
            'event_occurrence_id' => $event1->id,
            'day_number' => 1,
            'date' => '2026-08-20',
        ]);
        EventDay::firstOrCreate([
            'event_occurrence_id' => $event1->id,
            'day_number' => 2,
            'date' => '2026-08-21',
        ]);
        EventDay::firstOrCreate([
            'event_occurrence_id' => $event1->id,
            'day_number' => 3,
            'date' => '2026-08-22',
        ]);

    }
}
