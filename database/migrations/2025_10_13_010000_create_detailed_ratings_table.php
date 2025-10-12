<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detailed_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bid_id')->constrained()->onDelete('cascade');
            
            // التقييمات التفصيلية
            $table->tinyInteger('professionalism_rating')->unsigned(); // الاحترافية بالتعامل
            $table->tinyInteger('communication_rating')->unsigned(); // التواصل والمتابعة
            $table->tinyInteger('quality_rating')->unsigned(); // جودة العمل المسلم
            $table->tinyInteger('experience_rating')->unsigned(); // الخبرة بمجال المشروع
            $table->tinyInteger('delivery_rating')->unsigned(); // التسليم في الموعد
            $table->tinyInteger('cooperation_rating')->unsigned(); // التعامل معه مرة أخرى
            
            // التقييم العام والتعليق
            $table->decimal('overall_rating', 2, 1); // متوسط التقييمات
            $table->text('comment')->nullable();
            
            $table->timestamps();
            
            // فهرسة
            $table->index(['freelancer_id']);
            $table->index(['project_id']);
            $table->unique(['project_id', 'client_id', 'freelancer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('detailed_ratings');
    }
};
