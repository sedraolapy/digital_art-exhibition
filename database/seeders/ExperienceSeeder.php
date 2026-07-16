<?php

namespace Database\Seeders;

use App\Enums\ExperienceStatus;
use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experience1 = Experience::create([
            'title'       => 'ملتقى التصميم الجرافيكي والتسويق الرقمي',
            'description' => 'انطلقت أولى تجاربنا بتنظيم ملتقى التصميم الجرافيكي والتسويق الرقمي في دمشق على مدار يومين، بمشاركة ٣٥ عارضًا وأكثر من ٧٠٠ زائر. وقد جاءت فكرة الملتقى بمبادرة من أ. إيمان شبيب، التي تولّت أيضًا إدارة المشروع والإشراف على جميع مراحل التخطيط والتنفيذ بما أسهم في نجاحه وتحقيق أهدافه. وشهد الملتقى برنامجًا حواريًا وتدريبيًا قدّمه نخبة من المختصين، وهم: أ. وسيم زيادة، أ. طارق العايش، م. عمر بياعة، أ. نوار اسمندر، د. نور الحمصي، أ. أنس عراب، م. مزنة الخن، أ. عبيدة كوراني، أ. وائل الحسن، وأ. إيمان شبيب، حيث تناولت الجلسات موضوعات التصميم الجرافيكي، والتسويق الرقمي، والذكاء الاصطناعي، والعمل الحر، وربط الإبداع باحتياجات سوق العمل.',
            'start_date'  => '2024-02-27',
            'end_date'    => '2024-02-28',
            'status'      => ExperienceStatus::PUBLISHED->value,
        ]);

        $experience1->addMedia(public_path('storage/experience/experience1.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('experience_gallery');

        $experience1->addMedia(public_path('storage/experience/experience2.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('experience_gallery');

        $experience1->addMedia(public_path('storage/experience/experience3.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('experience_gallery');




        $experience2 = Experience::create([
                'title'       => ' ملتقى الإبداع الرقمي الأول',
                'description' => 'شهد ملتقى الإبداع الرقمي الأول في دار الأوبرا بدمشق نقلة نوعية في حجم وتأثير الفعالية، حيث استقطب أكثر من ٢٥٠٠ طلب تسجيل واستقبل ما يزيد على ١٥٠٠ زائر. وقد جاءت فكرة الملتقى من أ. إيمان شبيب، التي شغلت منصب مديرة المشروع وأشرفت على التخطيط والتنظيم والتنسيق العام بما أسهم في إخراج الملتقى بمستوى احترافي. أقيم الملتقى برعاية وزارة الإعلام وبحضور رسمي رفيع المستوى ضم وزير الإعلام ووزير الاتصالات إلى جانب ممثلين عن وزارة الثقافة ووزارة الشؤون الاجتماعية والعمل ووزارة التعليم العالي ووزارة الداخلية ووزارة الدفاع. كما شارك في إدارة الجلسات والحوارات كل من أ. إيمان شبيب ود. نور الحمصي وأ. عبادة مقداد في لقاء جمع صناع القرار مع الخبراء ورواد القطاع الرقمي وأسهم في ترسيخ الملتقى كمنصة وطنية للحوار والإبداع الرقمي.',
                'start_date'  => '2025-06-18',
                'end_date'    => null,
                'status'      => ExperienceStatus::PUBLISHED->value,
            ]);

            $experience2->addMedia(public_path('storage/experience/experience4.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('experience_gallery');

            $experience2->addMedia(public_path('storage/experience/experience5.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('experience_gallery');

            $experience2->addMedia(public_path('storage/experience/experience6.png'))
                ->preservingOriginal()
                ->toMediaCollection('experience_gallery');
    }
}
