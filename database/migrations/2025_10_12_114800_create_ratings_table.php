<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->integer('communication_rating')->unsigned()->default(5); // التواصل والتفاهم
            $table->integer('quality_rating')->unsigned()->default(5); // جودة العمل المسلم
            $table->integer('expertise_rating')->unsigned()->default(5); // الخبرة بالمجال المطلوب
            $table->integer('delivery_rating')->unsigned()->default(5); // التسليم بالموعد
            $table->integer('cooperation_rating')->unsigned()->default(5); // التعامل والأخلاق المهنية
            $table->integer('rehire_rating')->unsigned()->default(5); // إعادة التوظيف
            $table->decimal('overall_rating', 3, 2)->default(5.00); // التقييم الإجمالي
            $table->text('review')->nullable(); // التعليق
            $table->timestamps();
            
            $table->index(['freelancer_id', 'overall_rating']);
            $table->index('project_id');
            $table->unique(['project_id', 'client_id']); // تقييم واحد لكل مشروع
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
