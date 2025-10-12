<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing conversations table if it exists with old structure
        Schema::dropIfExists('conversations');
        
        // Create new conversations table with correct structure
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('bid_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure unique conversation per bid
            $table->unique(['bid_id']);
            
            // Index for faster queries
            $table->index(['client_id', 'freelancer_id']);
            $table->index(['last_message_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
};
