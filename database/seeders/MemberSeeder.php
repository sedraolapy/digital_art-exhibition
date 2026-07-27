<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member1 = Member::create([
            'name'          => 'عفيف غزاوي',
            'role'          => 'Back-end Developer',
            'bio'           => 'مطور خلفية بخبرة في Laravel و Filament.',
            'portfolio_url' => 'https://portfolio.example.com/sedra',
        ]);

        $member1->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://linkedin.com/in/sedra',
        ]);
        $member1->socialLinks()->create([
            'platform' => 'insatgram',
            'url'      => 'https://github.com/sedra',
        ]);


        $member2 = Member::create([
            'name'          => 'محمد شعراوي',
            'role'          => 'UI/UX Designer',
            'bio'           => 'مصممة واجهات وتجارب مستخدم.',
            'portfolio_url' => 'https://portfolio.example.com/rewa',
        ]);

        $member2->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://behance.net/rewa',
        ]);
        $member2->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://dribbble.com/rewa',
        ]);

    }
}
