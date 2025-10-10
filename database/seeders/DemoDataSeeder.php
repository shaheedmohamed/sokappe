<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo users
        $employer = User::create([
            'name' => 'أحمد محمد',
            'email' => 'employer@demo.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'email_verified_at' => now(),
        ]);

        $freelancer = User::create([
            'name' => 'سارة أحمد',
            'email' => 'freelancer@demo.com',
            'password' => Hash::make('password'),
            'role' => 'freelancer',
            'email_verified_at' => now(),
        ]);

        // Create demo projects
        Project::create([
            'employer_id' => $employer->id,
            'title' => 'تصميم موقع إلكتروني لشركة ناشئة',
            'description' => 'نحتاج إلى تصميم موقع إلكتروني احترافي لشركة تقنية ناشئة. الموقع يجب أن يكون responsive ويدعم اللغة العربية.',
            'budget_min' => 2000,
            'budget_max' => 5000,
            'duration_days' => 14,
        ]);

        Project::create([
            'employer_id' => $employer->id,
            'title' => 'كتابة محتوى تسويقي لمنتج جديد',
            'description' => 'مطلوب كاتب محتوى محترف لكتابة نصوص تسويقية جذابة لمنتج تقني جديد. يجب أن يكون المحتوى باللغة العربية.',
            'budget_min' => 500,
            'budget_max' => 1200,
            'duration_days' => 7,
        ]);

        Project::create([
            'employer_id' => $employer->id,
            'title' => 'تطوير تطبيق جوال للتجارة الإلكترونية',
            'description' => 'نحتاج إلى تطوير تطبيق جوال لمتجر إلكتروني يدعم الدفع الإلكتروني والتوصيل. التطبيق مطلوب لنظامي iOS و Android.',
            'budget_min' => 8000,
            'budget_max' => 15000,
            'duration_days' => 30,
        ]);

        // Create demo services
        Service::create([
            'freelancer_id' => $freelancer->id,
            'title' => 'تصميم لوجو احترافي',
            'description' => 'سأقوم بتصميم لوجو احترافي وفريد لشركتك أو مشروعك مع 3 مفاهيم مختلفة وتعديلات مجانية.',
            'price' => 250,
            'delivery_days' => 3,
            'image' => 'https://picsum.photos/400/300?random=1',
            'rating_avg' => 4.8,
            'rating_count' => 24,
        ]);

        Service::create([
            'freelancer_id' => $freelancer->id,
            'title' => 'كتابة مقال SEO متوافق مع محركات البحث',
            'description' => 'كتابة مقالات حصرية ومتوافقة مع SEO باللغة العربية. 1000 كلمة مع بحث شامل وكلمات مفتاحية.',
            'price' => 150,
            'delivery_days' => 2,
            'image' => 'https://picsum.photos/400/300?random=2',
            'rating_avg' => 4.9,
            'rating_count' => 18,
        ]);

        Service::create([
            'freelancer_id' => $freelancer->id,
            'title' => 'إدارة حسابات وسائل التواصل الاجتماعي',
            'description' => 'إدارة شاملة لحساباتك على وسائل التواصل الاجتماعي مع إنشاء محتوى جذاب وتفاعل مع الجمهور.',
            'price' => 800,
            'delivery_days' => 30,
            'image' => 'https://picsum.photos/400/300?random=3',
            'rating_avg' => 4.7,
            'rating_count' => 12,
        ]);

        Service::create([
            'freelancer_id' => $freelancer->id,
            'title' => 'ترجمة احترافية من الإنجليزية للعربية',
            'description' => 'ترجمة دقيقة واحترافية للنصوص التقنية والتسويقية من الإنجليزية إلى العربية. حتى 1000 كلمة.',
            'price' => 100,
            'delivery_days' => 1,
            'image' => 'https://picsum.photos/400/300?random=4',
            'rating_avg' => 5.0,
            'rating_count' => 31,
        ]);
    }
}
