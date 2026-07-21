<?php

namespace Database\Seeders;

use App\Models\EventDay;
use App\Models\Lecture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LecturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventDay1 = EventDay::where('date', '2026-08-20')->first();
        $eventDay2 = EventDay::where('date', '2026-08-21')->first();

        if ($eventDay1) {
            Lecture::firstOrCreate([
                'title' => 'مقدمة في الذكاء الاصطناعي',
                'description' => 'محاضرة تعريفية حول أساسيات الذكاء الاصطناعي وتطبيقاته.',
                'speaker_name' => 'د. أحمد العلي',
                'max_seats' => 100,
                'event_day_id' => $eventDay1->id,
                'date' => $eventDay1->date,
                'start_time' => '10:00',
                'end_time' => '12:00',
            ]);
        }

        if ($eventDay2) {
            Lecture::firstOrCreate([
                'title' => 'تحليل البيانات باستخدام بايثون',
                'description' => 'ورشة عملية حول أدوات تحليل البيانات.',
                'speaker_name' => 'م. ليلى يوسف',
                'max_seats' => 80,
                'event_day_id' => $eventDay2->id,
                'date' => $eventDay2->date,
                'start_time' => '14:00',
                'end_time' => '16:00',
            ]);
        }
    }
}
