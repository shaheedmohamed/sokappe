<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('accepted_bid_id')->constrained('bids')->onDelete('cascade');
            
            // حالة المشروع
            $table->enum('status', ['in_progress', 'delivered', 'completed', 'cancelled'])->default('in_progress');
            
            // تواريخ مهمة
            $table->timestamp('started_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // ملاحظات
            $table->text('client_notes')->nullable();
            $table->text('freelancer_notes')->nullable();
            
            $table->timestamps();
            
            // فهرسة
            $table->index(['project_id']);
            $table->index(['client_id']);
            $table->index(['freelancer_id']);
            $table->unique(['project_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_management');
    }
};
