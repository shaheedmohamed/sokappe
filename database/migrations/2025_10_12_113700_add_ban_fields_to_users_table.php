<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('is_active');
            $table->text('banned_reason')->nullable()->after('is_banned');
            $table->timestamp('banned_at')->nullable()->after('banned_reason');
            
            $table->index('is_banned');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_reason', 'banned_at']);
        });
    }
};
