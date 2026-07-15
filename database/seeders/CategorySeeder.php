<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'التصميم الجرافيكي',
            'الموشن جرافيك',
            'المونتاج',
            'الرسم الرقمي',
            'التصوير',
            'التخطيط الرقمي',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['is_active' => true]
            );
        }
    }
}
