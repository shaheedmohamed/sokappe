<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Check if employer_id column exists and make it nullable
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'employer_id')) {
                // Drop foreign key constraint first if it exists
                try {
                    $table->dropForeign(['employer_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Make the column nullable
                $table->unsignedBigInteger('employer_id')->nullable()->change();
            }
        });

        // Update any NULL employer_id values to use user_id
        \Illuminate\Support\Facades\DB::statement('
            UPDATE projects 
            SET employer_id = user_id 
            WHERE employer_id IS NULL AND user_id IS NOT NULL
        ');
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'employer_id')) {
                $table->unsignedBigInteger('employer_id')->nullable(false)->change();
            }
        });
    }
};
