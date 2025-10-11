<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // For SQLite, we need to recreate the table with the new enum values
        // First, let's add a temporary column
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_temp')->nullable();
        });

        // Copy existing role values to temp column
        DB::statement('UPDATE users SET role_temp = role');

        // Drop the old role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Add the new role column with admin included
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['employer', 'freelancer', 'admin'])->nullable()->after('avatar');
        });

        // Copy values back from temp column
        DB::statement('UPDATE users SET role = role_temp');

        // Drop the temporary column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_temp');
        });
    }

    public function down(): void
    {
        // Reverse the process
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_temp')->nullable();
        });

        DB::statement('UPDATE users SET role_temp = role WHERE role IN ("employer", "freelancer")');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['employer', 'freelancer'])->nullable()->after('avatar');
        });

        DB::statement('UPDATE users SET role = role_temp');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_temp');
        });
    }
};
