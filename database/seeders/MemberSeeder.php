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
            'name'          => 'إيمان شبيب',
            'role'          => 'Founder & Project Manager',
            'bio' => 'مصممة ومدربة جرافيك بخبرة 13 عاماً، حاصلة على دبلوم تقني في العلوم المالية والمصرفية, سنة ثالثة في العلوم الشرعية، مديرة مشروع ملتقى الإبداع الرقمي،و ملتقى التصميم الجرافيكي والتسويق الرقمي.',
            'portfolio_url' => 'https://www.behance.net/Eman-shbeeb',
        ]);

        $member1->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/iman.shbeeb.3?mibextid=wwXIfr&mibextid=wwXIfr',
        ]);

        $member1->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/eman-shbeeb-324b38247?utm_source=share_via&utm_content=profile&utm_medium=member_ios',
        ]);
        $member1->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/shbeebeman?igsi=MThkMGpycTdjOG85bA==',
        ]);

        $member1->addMedia(public_path('storage/members/eman.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');


        $member2 = Member::create([
            'name'          => 'محمد الشعراوي',
            'role'          => 'AI Engineer',
            'bio'           => 'مهندس واجهات خلفية وذكاء اصطناعي، يبني أنظمة آمنة وقابلة للتوسع',
            'portfolio_url' => null,
        ]);

        $member2->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/share/1HvaHYH3vs/?mibextid=wwXIfr',
        ]);
        $member2->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/mohammad-alsharawi?utm_source=share_via&utm_content=profile&utm_medium=member_ios',
        ]);

        $member2->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/mohammad__alsharawi?igsi=c2d5cm04YjE4dTZq',
        ]);

        $member2->addMedia(public_path('storage/members/IMG_3122.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('members');

        $member3 = Member::create([
            'name'          => 'عبدالله محمد الحكيم الهندي',
            'role'          => 'Frontend Developer',
            'bio'           => 'مطور واجهات أمامية يحوّل الأفكار إلى تجارب ويب تفاعلية مبتكرة',
            'portfolio_url' => null,
        ]);

        $member3->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/abdullah.alhakim04',
        ]);
        $member3->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/abdullah-alhakim-alhendi-b5b5353ba/',
        ]);

        $member3->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/abdullahalhakim14/',
        ]);

        $member3->addMedia(public_path('storage/members/Abdullah.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');

        $member4 = Member::create([
            'name'          => 'عفيف الغزيري',
            'role'          => 'Frontend Developer',
            'bio'           => 'مطور ويب متخصص بتطوير حلول رقمية حديثة، يركز على الجودة والكفاءة وتقديم تجارب تلبي متطلبات المشاريع',
            'portfolio_url' => 'https://afif-gh.vercel.app/',
        ]);

        $member4->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/afif.ghaziri.2025',
        ]);
        $member4->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/afif-ghaziri2004',
        ]);

        $member4->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/afif.gh99',
        ]);

        $member4->addMedia(public_path('storage/members/Afif.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');


        $member5 = Member::create([
            'name'          => 'مؤمنة شبيب',
            'role'          => 'Social media manager',
            'bio'           => 'مهندسة معمارية، صانعة محتوى، وفنانة',
            'portfolio_url' => null,
        ]);

        $member5->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/moumena.shbeeb?mibextid=wwXIfr&mibextid=wwXIfr',
        ]);
        $member5->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/moumena-shbeeb-a5bb403b3?utm_source=share_via&utm_content=profile&utm_medium=member_ios',
        ]);

        $member5->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://instagram.com/moumena_shbeeb?igshid=1sgby1pgdcypk',
        ]);

        $member5->addMedia(public_path('storage/members/IMG_9047.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');

        $member6 = Member::create([
            'name'          => 'رِوى الحسين',
            'role'          => 'Graphic Designer',
            'bio'           => 'مهندسةالكترونيات واتصالات',
            'portfolio_url' => 'https://www.behance.net/rewahoussien97',
        ]);

        $member6->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/rewa55',
        ]);

        $member6->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/rewa-houssien-b75753248',
        ]);

        $member6->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/rewa.graphic/',
        ]);

        $member6->addMedia(public_path('storage/members/rewaaa.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');


        $member7 = Member::create([
            'name'          => 'ليال يوسف',
            'role'          => 'Communications and Public Relations',
            'bio'           =>  'اجازة في هندسة التصميم والانتاج',
            'portfolio_url' => null,
        ]);

        $member7->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/profile.php?id=61586791658445&mibextid=ZbWKwL',
        ]);

        $member7->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/yousef.layal?igsh=MWo2YW8zaHdiNDdwZg==',
        ]);

        $member7->addMedia(public_path('storage/members/lial.jpeg'))
            ->preservingOriginal()
            ->toMediaCollection('members');


        $member8 = Member::create([
            'name'          => 'محمد ابراهيم',
            'role'          => 'DOP',
            'bio'           => 'حاصل على الإجازة في علوم الإدارة (BSCM)',
            'portfolio_url' => 'https://drive.google.com/drive/folders/1yA8s3nhumd6r61xUryBWJhgn5VS7aTmC',
        ]);

        $member8->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/share/1FdLhrWs8B/',
        ]);

        $member8->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/_mohamad_ibrahem',
        ]);

        $member8->addMedia(public_path('storage/members/mohib.png'))
            ->preservingOriginal()
            ->toMediaCollection('members');

        $member9 = Member::create([
            'name'          => 'سيدرا العلبي',
            'role'          => 'Backend Developer',
            'bio'           => 'مطورة واجهات خلفية تبني أنظمة قوية وموثوقة وحلولاً رقمية مؤثرة',
            'portfolio_url' => null,
        ]);

        $member9->socialLinks()->create([
            'platform' => 'facebook',
            'url'      => 'https://www.facebook.com/profile.php?id=100068074688576&mibextid=wwXIfr&mibextid=wwXIfr',
        ]);

        $member9->socialLinks()->create([
            'platform' => 'linkedin',
            'url'      => 'https://www.linkedin.com/in/sedra-alolapy',
        ]);

        $member9->socialLinks()->create([
            'platform' => 'instagram',
            'url'      => 'https://www.instagram.com/eng__sedra?igsi=bTdzMmw1bzJjMHhk',
        ]);

        $member9->addMedia(public_path('storage/members/sedra.png'))
            ->preservingOriginal()
            ->toMediaCollection('members');
    }

}
