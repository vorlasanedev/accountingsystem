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
        Schema::table('fund_sources', function (Blueprint $table) {
            $table->decimal('initial_usd_balance', 15, 2)->default(0);
            $table->decimal('available_usd_balance', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fund_sources', function (Blueprint $table) {
            $table->dropColumn(['initial_usd_balance', 'available_usd_balance']);
        });
    }
};
