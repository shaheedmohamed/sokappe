<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversation = Conversation::first();
        
        if ($conversation) {
            // رسائل من العميل
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $conversation->client_id,
                'message' => 'مرحبا، أريد مناقشة تفاصيل المشروع معك',
                'created_at' => now()->subHours(2),
            ]);
            
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $conversation->client_id,
                'message' => 'هل يمكنك البدء في العمل خلال الأسبوع القادم؟',
                'created_at' => now()->subHours(1),
            ]);
            
            // رسائل من المستقل
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $conversation->freelancer_id,
                'message' => 'أهلاً وسهلاً، سعيد بالتعامل معك',
                'created_at' => now()->subMinutes(90),
            ]);
            
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $conversation->freelancer_id,
                'message' => 'نعم، يمكنني البدء فوراً. سأرسل لك خطة العمل قريباً',
                'created_at' => now()->subMinutes(30),
            ]);
            
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $conversation->client_id,
                'message' => 'ممتاز! في انتظار خطة العمل',
                'created_at' => now()->subMinutes(15),
            ]);
            
            // تحديث وقت آخر رسالة
            $conversation->update(['last_message_at' => now()->subMinutes(15)]);
            
            $this->command->info('تم إنشاء ' . Message::count() . ' رسالة تجريبية');
        } else {
            $this->command->error('لا توجد محادثات لإضافة رسائل إليها');
        }
    }
}
