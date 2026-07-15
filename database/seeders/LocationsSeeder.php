<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $governorates = [
            'Damascus',
            'Rif Dimashq',
            'Aleppo',
            'Homs',
            'Hama',
            'Latakia',
            'Tartus',
            'Idlib',
            'Raqqa',
            'Deir ez-Zor',
            'Hasakah',
            'Quneitra',
            'Daraa',
            'As-Suwayda',
        ];

        foreach ($governorates as $name) {
            Location::firstOrCreate(['name' => $name]);
        }
    }
}
