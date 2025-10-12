<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->string('title')->nullable(); // المسمى الوظيفي
            $table->text('bio')->nullable(); // النبذة التعريفية
            $table->string('specialization')->nullable(); // التخصص
            $table->text('experience')->nullable(); // الخبرة
            $table->string('location')->nullable(); // الموقع
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('portfolio_video')->nullable(); // فيديو تعريفي
            $table->decimal('hourly_rate', 8, 2)->nullable(); // السعر بالساعة
            $table->boolean('available_for_hire')->default(true);
            $table->json('languages')->nullable(); // اللغات
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('specialization');
            $table->index('available_for_hire');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
