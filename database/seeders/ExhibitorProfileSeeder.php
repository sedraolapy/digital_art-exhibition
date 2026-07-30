<?php

namespace Database\Seeders;

use App\Enums\EventOccurrenceStatus;
use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\EventOccurrence;
use App\Models\ExhibitorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExhibitorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::role(RoleEnum::USER->value)->first();
        $occurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();
        $category = Category::first();

        if ($user && $occurrence && $category) {
            $profile1 = ExhibitorProfile::create([
                'user_id'             => $user->id,
                'event_occurrence_id'=> $occurrence->id,
                'category_id'         => $category->id,
                'experience_years'    => 5,
                'portfolio_url'       => 'https://portfolio.example.com/sedra',
                'bio'                 => 'مطور خلفية بخبرة 5 سنوات في Laravel و Filament.',
            ]);

            $profile1->user->socialLinks()->create([
                'platform' => 'Facebook',
                'url'      => 'https://linkedin.com/in/sedra',
            ]);
            $profile1->user->socialLinks()->create([
                'platform' => 'Instagram',
                'url'      => 'https://github.com/sedra',
            ]);
            $profile1->user->socialLinks()->create([
                'platform' => 'Behance',
                'url'      => 'https://github.com/sedra',
            ]);
            $profile1->user->socialLinks()->create([
                'platform' => 'LinkedIn',
                'url'      => 'https://github.com/sedra',
            ]);

            $user->syncRoles(RoleEnum::EXHIBITOR->value);
        }

        $user2 = User::role(RoleEnum::USER->value)->skip(1)->first();
        if ($user2 && $occurrence && $category) {
            $profile2 = ExhibitorProfile::create([
                'user_id'             => $user2->id,
                'event_occurrence_id'=> $occurrence->id,
                'category_id'         => $category->id,
                'experience_years'    => 3,
                'portfolio_url'       => 'https://portfolio.example.com/user2',
                'bio'                 => 'مصمم واجهات وتجارب مستخدم.',
            ]);

            $profile2->user->socialLinks()->create([
                'platform' => 'linkedIn',
                'url'      => 'https://behance.net/user2',
            ]);
            $profile2->user->socialLinks()->create([
                'platform' => 'Instagram',
                'url'      => 'https://dribbble.com/user2',
            ]);
            $profile2->user->socialLinks()->create([
                'platform' => 'Facebook',
                'url'      => 'https://dribbble.com/user2',
            ]);
            $profile2->user->socialLinks()->create([
                'platform' => 'Behance',
                'url'      => 'https://dribbble.com/user2',
            ]);

            $user2->syncRoles(RoleEnum::EXHIBITOR->value);
        }
    }
}
