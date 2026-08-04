<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workshop::create([
            'title' => 'مقدمة في الذكاء الاصطناعي',
            'description' => 'ورشة تعريفية تشرح أساسيات الذكاء الاصطناعي وتطبيقاته في مختلف المجالات.',
            'speaker_name' => 'د. أحمد علي',
            'max_seats' => 50,
            'date' => '2026-08-10',
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'status' => 'upcoming',
        ]);

        Workshop::create([
            'title' => 'مستقبل تطوير الويب',
            'description' => 'ورشة حول أحدث تقنيات تطوير الويب والاتجاهات المستقبلية في مجال البرمجة.',
            'speaker_name' => 'م. سارة حسن',
            'max_seats' => 40,
            'date' => '2026-08-11',
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'status' => 'active',

        ]);

        Workshop::create([
            'title' => 'ريادة الأعمال والابتكار',
            'description' => 'ورشة تساعد على تحويل الأفكار إلى مشاريع ناجحة وتطوير مهارات ريادة الأعمال.',
            'speaker_name' => 'محمد خالد',
            'max_seats' => 60,
            'date' => '2026-08-12',
            'start_time' => '11:00:00',
            'end_time' => '13:00:00',
            'status' => 'finished',
        ]);
    }
}
