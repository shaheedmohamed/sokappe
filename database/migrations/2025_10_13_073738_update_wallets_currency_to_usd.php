<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تحديث جميع المحافظ الموجودة إلى الدولار
        DB::table('wallets')->update(['currency' => 'USD']);
        
        // تحديث جميع المعاملات الموجودة إلى الدولار
        DB::table('transactions')->update(['currency' => 'USD']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إرجاع العملة إلى الجنيه المصري
        DB::table('wallets')->update(['currency' => 'EGP']);
        DB::table('transactions')->update(['currency' => 'EGP']);
    }
};
