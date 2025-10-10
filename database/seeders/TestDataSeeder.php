<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Service;
use App\Models\Bid;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدمين إضافيين إذا لزم الأمر
        $users = User::all();
        
        if ($users->count() < 3) {
            User::create([
                'name' => 'سارة أحمد',
                'email' => 'sara@example.com',
                'password' => bcrypt('password'),
                'role' => 'freelancer'
            ]);
            
            User::create([
                'name' => 'محمد علي',
                'email' => 'mohamed@example.com',
                'password' => bcrypt('password'),
                'role' => 'employer'
            ]);
        }
        
        $users = User::all();
        
        // إنشاء مشاريع تجريبية
        if (Project::count() == 0) {
            Project::create([
                'user_id' => $users->first()->id,
                'title' => 'تصميم موقع إلكتروني',
                'description' => 'أحتاج لتصميم موقع إلكتروني احترافي لشركتي',
                'budget_min' => 1000,
                'budget_max' => 3000,
                'duration' => '15 يوم',
                'skills' => 'HTML, CSS, JavaScript, PHP'
            ]);
            
            Project::create([
                'user_id' => $users->skip(1)->first()->id,
                'title' => 'تطبيق جوال',
                'description' => 'تطوير تطبيق جوال للتجارة الإلكترونية',
                'budget_min' => 2000,
                'budget_max' => 5000,
                'duration' => '30 يوم',
                'skills' => 'Flutter, Firebase, API'
            ]);
        }
        
        // إنشاء خدمات تجريبية
        if (Service::count() == 0) {
            Service::create([
                'user_id' => $users->first()->id,
                'title' => 'تصميم لوجو احترافي',
                'description' => 'سأقوم بتصميم لوجو احترافي لشركتك',
                'price' => 500,
                'delivery_time' => 3,
                'category' => 'تصميم',
                'image' => null
            ]);
        }
        
        // إنشاء عروض تجريبية
        if (Bid::count() == 0) {
            $project = Project::first();
            $freelancer = $users->skip(1)->first();
            
            if ($project && $freelancer) {
                Bid::create([
                    'project_id' => $project->id,
                    'user_id' => $freelancer->id,
                    'freelancer_id' => $freelancer->id,
                    'amount' => 2500,
                    'price' => 2500,
                    'delivery_time' => 10,
                    'days' => 10,
                    'message' => 'يمكنني تنفيذ هذا المشروع بجودة عالية وفي الوقت المحدد',
                    'status' => 'pending'
                ]);
                
                Bid::create([
                    'project_id' => $project->id,
                    'user_id' => $users->skip(2)->first()->id,
                    'freelancer_id' => $users->skip(2)->first()->id,
                    'amount' => 2000,
                    'price' => 2000,
                    'delivery_time' => 7,
                    'days' => 7,
                    'message' => 'لدي خبرة واسعة في هذا المجال',
                    'status' => 'pending'
                ]);
            }
        }
    }
}
