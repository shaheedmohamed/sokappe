<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = User::where('email', 'admin@sokapp.com')->first();
        
        if (!$existingAdmin) {
            User::create([
                'name' => 'مدير النظام',
                'email' => 'admin@sokapp.com',
                'password' => Hash::make('admin/1234'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('✅ تم إنشاء حساب المدير بنجاح');
            $this->command->info('📧 الإيميل: admin@sokapp.com');
            $this->command->info('🔑 كلمة المرور: admin/1234');
        } else {
            $this->command->info('⚠️ حساب المدير موجود بالفعل');
        }
    }
}
