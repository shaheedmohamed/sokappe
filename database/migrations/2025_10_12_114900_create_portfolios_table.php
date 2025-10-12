<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category')->nullable();
            $table->json('technologies')->nullable(); // التقنيات المستخدمة
            $table->string('project_url')->nullable(); // رابط المشروع
            $table->string('github_url')->nullable(); // رابط GitHub
            $table->json('images')->nullable(); // صور المشروع
            $table->date('completion_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'is_featured']);
            $table->index('category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
};
