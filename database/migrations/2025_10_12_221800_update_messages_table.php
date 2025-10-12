<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing messages table if it exists with old structure
        Schema::dropIfExists('messages');
        
        // Create new messages table with correct structure
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_system_message')->default(false);
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['conversation_id', 'created_at']);
            $table->index(['sender_id']);
            $table->index(['read_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
