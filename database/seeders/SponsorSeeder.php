<?php

namespace Database\Seeders;

use App\Enums\CycleStatus;
use App\Enums\SponsorType;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use App\Models\Sponsor;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sponsor1 = Sponsor::create([
            'name' => 'Sukon',
            'type' => SponsorType::LOGISTIC->value,
        ]);

        $sponsor1->addMedia(public_path('storage/sponsors/سكون لوغو.svg'))
            ->preservingOriginal()
            ->toMediaCollection('sponsors');

        $sponsor2 = Sponsor::create([
            'name' => 'Gilgamesh',
            'type' => SponsorType::LOGISTIC->value,
        ]);

        $sponsor2->addMedia(public_path('storage/sponsors/جلجامش لوغو.svg'))
            ->preservingOriginal()
            ->toMediaCollection('sponsors');


        $cycle = Cycle::where('status', CycleStatus::ACTIVE->value)->first();

        if ($cycle) {
            DB::table('cycle_sponsors')->insert([
                'cycle_id' => $cycle->id,
                'sponsor_id' => $sponsor1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cycle_sponsors')->insert([
                'cycle_id' => $cycle->id,
                'sponsor_id' => $sponsor2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
