<?php

namespace Database\Seeders;

use App\Enums\SponsorType;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use App\Models\Sponsor;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diamond = Sponsor::create([
            'name' => 'Diamond Sponsor',
            'type' => SponsorType::DIAMOND->value,
        ]);

        $gold = Sponsor::create([
            'name' => 'Gold Sponsor',
            'type' => SponsorType::GOLD->value,
        ]);

        $silver = Sponsor::create([
            'name' => 'Silver Sponsor',
            'type' => SponsorType::SILVER->value,
        ]);

        $logistic = Sponsor::create([
            'name' => 'Logistic Sponsor',
            'type' => SponsorType::LOGISTIC->value,
        ]);


        $cycle = Cycle::first();
        $occurrence = EventOccurrence::first();


        if ($cycle) {
            DB::table('cycle_sponsors')->insert([
                'cycle_id' => $cycle->id,
                'sponsor_id' => $diamond->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cycle_sponsors')->insert([
                'cycle_id' => $cycle->id,
                'sponsor_id' => $logistic->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($occurrence) {
            DB::table('occurrence_sponsors')->insert([
                'event_occurrence_id' => $occurrence->id,
                'sponsor_id' => $gold->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('occurrence_sponsors')->insert([
                'event_occurrence_id' => $occurrence->id,
                'sponsor_id' => $silver->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
