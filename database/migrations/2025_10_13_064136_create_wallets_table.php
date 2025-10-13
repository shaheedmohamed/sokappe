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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0.00); // الرصيد الحالي
            $table->decimal('pending_balance', 15, 2)->default(0.00); // الرصيد المعلق
            $table->decimal('total_earned', 15, 2)->default(0.00); // إجمالي الأرباح
            $table->decimal('total_withdrawn', 15, 2)->default(0.00); // إجمالي المسحوبات
            $table->string('currency', 3)->default('USD'); // العملة
            $table->boolean('is_active')->default(true); // حالة المحفظة
            $table->timestamp('last_transaction_at')->nullable(); // آخر معاملة
            $table->timestamps();

            // فهرسة
            $table->index(['user_id']);
            $table->index(['is_active']);
            $table->unique(['user_id', 'currency']); // محفظة واحدة لكل مستخدم لكل عملة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
