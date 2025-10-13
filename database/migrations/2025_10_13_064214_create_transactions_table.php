<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique(); // معرف المعاملة الفريد
            $table->enum('type', ['deposit', 'withdrawal', 'payment', 'refund', 'commission', 'bonus']); // نوع المعاملة
            $table->decimal('amount', 15, 2); // المبلغ
            $table->decimal('fee', 15, 2)->default(0.00); // الرسوم
            $table->decimal('net_amount', 15, 2); // المبلغ الصافي
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable(); // طريقة الدفع (opay, bank, etc)
            $table->string('external_id')->nullable(); // معرف خارجي من OPay
            $table->json('gateway_response')->nullable(); // استجابة البوابة
            $table->text('description')->nullable(); // وصف المعاملة
            $table->text('notes')->nullable(); // ملاحظات إدارية
            
            // معلومات المشروع المرتبط (إن وجد)
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('bid_id')->nullable()->constrained()->onDelete('set null');
            
            // معلومات إضافية
            $table->timestamp('processed_at')->nullable(); // وقت المعالجة
            $table->timestamp('completed_at')->nullable(); // وقت الإكمال
            $table->string('ip_address')->nullable(); // عنوان IP
            $table->text('user_agent')->nullable(); // معلومات المتصفح
            
            $table->timestamps();

            // فهرسة
            $table->index(['wallet_id']);
            $table->index(['user_id']);
            $table->index(['type']);
            $table->index(['status']);
            $table->index(['payment_method']);
            $table->index(['external_id']);
            $table->index(['project_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
