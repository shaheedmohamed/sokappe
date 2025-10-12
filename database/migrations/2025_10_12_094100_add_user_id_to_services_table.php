<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'user_id')) {
                // First add the column as nullable
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });

        // Update existing records with a default user (first user or create one)
        $firstUser = \App\Models\User::first();
        if (!$firstUser) {
            $firstUser = \App\Models\User::create([
                'name' => 'مستخدم افتراضي',
                'email' => 'default@sokapp.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'freelancer'
            ]);
        }

        // Update all services to have the first user's ID
        \Illuminate\Support\Facades\DB::table('services')
            ->whereNull('user_id')
            ->update(['user_id' => $firstUser->id]);

        // Now make the column NOT NULL and add foreign key
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
