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
        Schema::table('bids', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('bids', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('bids', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('bids', 'delivery_time')) {
                $table->integer('delivery_time')->nullable();
            }
            
            // Rename columns if they exist with old names
            if (Schema::hasColumn('bids', 'freelancer_id') && !Schema::hasColumn('bids', 'user_id')) {
                $table->renameColumn('freelancer_id', 'user_id');
            }
            if (Schema::hasColumn('bids', 'price') && !Schema::hasColumn('bids', 'amount')) {
                $table->renameColumn('price', 'amount');
            }
            if (Schema::hasColumn('bids', 'days') && !Schema::hasColumn('bids', 'delivery_time')) {
                $table->renameColumn('days', 'delivery_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            // Reverse the changes if needed
        });
    }
};
