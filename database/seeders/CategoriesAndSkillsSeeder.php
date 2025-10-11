<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Skill;

class CategoriesAndSkillsSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'تطوير المواقع', 'slug' => 'web-development'],
            ['name' => 'تطوير التطبيقات', 'slug' => 'mobile-development'],
            ['name' => 'التصميم والجرافيك', 'slug' => 'design'],
            ['name' => 'الكتابة والترجمة', 'slug' => 'writing'],
            ['name' => 'التسويق الرقمي', 'slug' => 'marketing'],
            ['name' => 'إدخال البيانات', 'slug' => 'data-entry'],
            ['name' => 'خدمات الأعمال', 'slug' => 'business'],
            ['name' => 'المونتاج والفيديو', 'slug' => 'video-editing'],
            ['name' => 'التعليق الصوتي', 'slug' => 'voice-over'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Skills
        $skills = [
            'HTML', 'CSS', 'JavaScript', 'PHP', 'Laravel', 'React', 'Vue.js', 'Angular',
            'Node.js', 'Python', 'Java', 'C#', '.NET', 'WordPress', 'Shopify',
            'Photoshop', 'Illustrator', 'InDesign', 'After Effects', 'Premiere Pro',
            'Figma', 'Sketch', 'XD', 'Canva', 'CorelDRAW',
            'SEO', 'SEM', 'Google Ads', 'Facebook Ads', 'Social Media Marketing',
            'Content Writing', 'Copywriting', 'Translation', 'Proofreading',
            'Excel', 'Data Entry', 'Virtual Assistant', 'Customer Service',
            'iOS Development', 'Android Development', 'Flutter', 'React Native',
            'Unity', 'Unreal Engine', '3D Modeling', 'Animation',
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill],
                ['slug' => \Illuminate\Support\Str::slug($skill)]
            );
        }
    }
}
